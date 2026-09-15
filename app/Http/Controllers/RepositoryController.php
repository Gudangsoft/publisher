<?php

namespace App\Http\Controllers;

use App\Models\RepositoryTaruna;
use App\Models\Setting;
use App\Models\ThesisSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RepositoryController extends Controller
{
    private const MAX_VERIFY_ATTEMPTS = 10;
    private const VERIFY_DECAY_SECONDS = 300;
    private const MAX_SEARCH_ATTEMPTS = 30;
    private const SEARCH_DECAY_SECONDS = 300;

    public function identity()
    {
        return view('repository.identity', [
            'korpsOptions' => RepositoryTaruna::KORPS_OPTIONS,
            'angkatanOptions' => RepositoryTaruna::angkatanOptions(),
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'korps' => ['required', 'string'],
            'angkatan' => ['required', 'string'],
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $throttleKey = 'repo-search|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_SEARCH_ATTEMPTS)) {
            return response()->json(['results' => [], 'message' => 'Terlalu banyak percobaan, coba lagi sebentar lagi.'], 429);
        }

        RateLimiter::hit($throttleKey, self::SEARCH_DECAY_SECONDS);

        $query = RepositoryTaruna::where('korps', $request->korps)
            ->where('angkatan', $request->angkatan);

        $term = trim((string) $request->input('q'));

        if ($term !== '') {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('academic_number', 'like', "%{$term}%");
            });
        }

        $results = $query->orderBy('name')->limit(10)->get(['id', 'name', 'academic_number']);

        return response()->json(['results' => $results]);
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'academic_number' => ['required', 'string', 'max:100'],
            'korps' => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'string', 'max:10'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'academic_number.required' => 'Nomor Akademik wajib diisi',
            'korps.required' => 'Korps wajib dipilih',
            'angkatan.required' => 'Angkatan wajib dipilih',
        ]);

        $throttleKey = 'repo-verify|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_VERIFY_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'academic_number' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ])->withInput();
        }

        $taruna = RepositoryTaruna::where('academic_number', trim($data['academic_number']))
            ->where('korps', $data['korps'])
            ->where('angkatan', $data['angkatan'])
            ->whereRaw('LOWER(name) = ?', [Str::lower(trim($data['name']))])
            ->first();

        if (!$taruna) {
            RateLimiter::hit($throttleKey, self::VERIFY_DECAY_SECONDS);

            return back()->withErrors([
                'academic_number' => 'Data tidak ditemukan di daftar taruna tingkat akhir. Periksa kembali Korps, Angkatan, Nama, dan Nomor Akademik, atau hubungi admin.',
            ])->withInput();
        }

        RateLimiter::clear($throttleKey);
        $request->session()->put('repository_taruna_id', $taruna->id);

        return redirect()->route('repository.upload');
    }

    public function upload()
    {
        $taruna = $this->currentTaruna();

        if (!$taruna) {
            return redirect()->route('repository.identity');
        }

        return view('repository.upload', [
            'taruna' => $taruna,
            'submission' => $taruna->submission,
        ]);
    }

    public function store(Request $request)
    {
        $taruna = $this->currentTaruna();

        if (!$taruna) {
            return redirect()->route('repository.identity');
        }

        if (Str::lower(trim((string) $request->input('confirm_academic_number'))) !== Str::lower($taruna->academic_number)) {
            return back()->withErrors([
                'confirm_academic_number' => 'Kode konfirmasi (Nomor Akademik) yang Anda ketik tidak sesuai. Silakan coba lagi.',
            ])->withInput();
        }

        $existingSubmission = $taruna->submission;
        $maxSizes = [
            'cover' => 5120, 'pengesahan' => 5120, 'abstrak' => 5120,
            'bab1' => 10240, 'bab2' => 10240, 'bab3' => 10240, 'bab4' => 10240, 'bab5' => 10240,
        ];
        $labels = ThesisSubmission::FILE_FIELDS;

        $rules = ['title' => ['required', 'string', 'max:255']];
        $messages = ['title.required' => 'Judul skripsi wajib diisi'];

        foreach (array_keys($labels) as $field) {
            $mode = $request->input("{$field}_mode", 'file');

            if ($mode === 'link') {
                $rules["{$field}_link"] = ['required', 'url', 'max:2048'];
                $messages["{$field}_link.required"] = "Tautan {$labels[$field]} wajib diisi";
                $messages["{$field}_link.url"] = "Tautan {$labels[$field]} harus berupa URL yang valid";
            } else {
                $keepsExistingFile = $existingSubmission && $existingSubmission->{"{$field}_path"};
                $rules[$field] = [$keepsExistingFile ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:' . $maxSizes[$field]];
                $messages["{$field}.required"] = "File {$labels[$field]} wajib diunggah";
                $messages["{$field}.mimes"] = "File {$labels[$field]} harus berformat PDF";
                $messages["{$field}.max"] = "Ukuran file {$labels[$field]} maksimal " . round($maxSizes[$field] / 1024) . 'MB';
            }
        }

        $data = $request->validate($rules, $messages);

        $submission = $existingSubmission ?: new ThesisSubmission([
            'repository_taruna_id' => $taruna->id,
            'submission_code' => $this->generateSubmissionCode(),
        ]);

        $submission->title = $data['title'];

        // Any re-submission needs to be reviewed again before it can be public.
        $submission->is_published = false;
        $submission->published_at = null;

        foreach (array_keys($labels) as $field) {
            $mode = $request->input("{$field}_mode", 'file');

            if ($mode === 'file' && !$request->hasFile($field)) {
                // No new file chosen for this field: keep the existing file as-is.
                continue;
            }

            if ($submission->{"{$field}_path"}) {
                Storage::disk('public')->delete($submission->{"{$field}_path"});
            }

            $submission->{"{$field}_path"} = null;
            $submission->{"{$field}_original_name"} = null;
            $submission->{"{$field}_url"} = null;

            if ($mode === 'link') {
                $submission->{"{$field}_url"} = $request->input("{$field}_link");
            } else {
                $file = $request->file($field);
                $submission->{"{$field}_path"} = $file->store('repository/' . $taruna->id, 'public');
                $submission->{"{$field}_original_name"} = $file->getClientOriginalName();
            }
        }

        $submission->save();

        return redirect()->route('repository.receipt');
    }

    public function receipt()
    {
        $taruna = $this->currentTaruna();

        if (!$taruna || !$taruna->submission) {
            return redirect()->route('repository.identity');
        }

        return view('repository.receipt', [
            'taruna' => $taruna,
            'submission' => $taruna->submission,
        ]);
    }

    public function downloadReceipt()
    {
        $taruna = $this->currentTaruna();

        if (!$taruna || !$taruna->submission) {
            return redirect()->route('repository.identity');
        }

        $submission = $taruna->submission;

        $verifyUrl = route('repository.verify-code', $submission->submission_code);
        $qrDataUri = (new Builder(
            writer: new PngWriter(),
            data: $verifyUrl,
            size: 160,
            margin: 6,
        ))->build()->getDataUri();

        $logoPath = Setting::get('site_logo', '');
        $logoAbsolutePath = ($logoPath && Storage::disk('public')->exists($logoPath))
            ? Storage::disk('public')->path($logoPath)
            : null;

        $pdf = Pdf::loadView('repository.receipt-pdf', [
            'taruna' => $taruna,
            'submission' => $submission,
            'qrDataUri' => $qrDataUri,
            'logoAbsolutePath' => $logoAbsolutePath,
        ]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('bukti-submit-' . $submission->submission_code . '.pdf');
    }

    public function verifyCode(string $code)
    {
        $submission = ThesisSubmission::with('taruna')->where('submission_code', $code)->first();

        return view('repository.verify-code', [
            'submission' => $submission,
            'code' => $code,
        ]);
    }

    public function reset(Request $request)
    {
        $request->session()->forget('repository_taruna_id');

        return redirect()->route('repository.identity');
    }

    public function collection(Request $request)
    {
        $query = ThesisSubmission::with('taruna')->where('is_published', true);

        if ($request->filled('korps')) {
            $query->whereHas('taruna', fn ($q) => $q->where('korps', $request->korps));
        }

        if ($request->filled('angkatan')) {
            $query->whereHas('taruna', fn ($q) => $q->where('angkatan', $request->angkatan));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('taruna', fn ($t) => $t->where('name', 'like', "%{$search}%"));
            });
        }

        $submissions = $query->orderByDesc('published_at')->paginate(12)->withQueryString();

        return view('repository.collection.index', [
            'submissions' => $submissions,
            'korpsOptions' => RepositoryTaruna::KORPS_OPTIONS,
            'angkatanOptions' => RepositoryTaruna::angkatanOptions(),
        ]);
    }

    public function collectionShow(string $code)
    {
        $submission = ThesisSubmission::with('taruna')
            ->where('submission_code', $code)
            ->where('is_published', true)
            ->firstOrFail();

        return view('repository.collection.show', [
            'submission' => $submission,
        ]);
    }

    private function currentTaruna(): ?RepositoryTaruna
    {
        $id = session('repository_taruna_id');

        if (!$id) {
            return null;
        }

        return RepositoryTaruna::with('submission')->find($id);
    }

    private function generateSubmissionCode(): string
    {
        do {
            $code = 'REPO-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (ThesisSubmission::where('submission_code', $code)->exists());

        return $code;
    }
}
