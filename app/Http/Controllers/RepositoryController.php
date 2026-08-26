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
    private const MAX_LOOKUP_ATTEMPTS = 20;
    private const LOOKUP_DECAY_SECONDS = 300;

    public function identity()
    {
        return view('repository.identity');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'academic_number' => ['required', 'string', 'max:100'],
        ]);

        $throttleKey = 'repo-lookup|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_LOOKUP_ATTEMPTS)) {
            return response()->json(['found' => false, 'message' => 'Terlalu banyak percobaan, coba lagi sebentar lagi.'], 429);
        }

        RateLimiter::hit($throttleKey, self::LOOKUP_DECAY_SECONDS);

        $taruna = RepositoryTaruna::where('academic_number', trim($request->academic_number))->first();

        if (!$taruna) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'name' => $taruna->name,
            'korps' => $taruna->korps,
        ]);
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'academic_number' => ['required', 'string', 'max:100'],
            'korps' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'academic_number.required' => 'Nomor Akademik wajib diisi',
            'korps.required' => 'Korps wajib diisi',
        ]);

        $throttleKey = 'repo-verify|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_VERIFY_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'academic_number' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ])->withInput();
        }

        $taruna = RepositoryTaruna::where('academic_number', trim($data['academic_number']))
            ->whereRaw('LOWER(name) = ?', [Str::lower(trim($data['name']))])
            ->whereRaw('LOWER(korps) = ?', [Str::lower(trim($data['korps']))])
            ->first();

        if (!$taruna) {
            RateLimiter::hit($throttleKey, self::VERIFY_DECAY_SECONDS);

            return back()->withErrors([
                'academic_number' => 'Data tidak ditemukan di daftar taruna tingkat akhir. Periksa kembali data Anda atau hubungi admin.',
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
        $maxSizes = ['cover' => 5120, 'pengesahan' => 5120, 'abstrak' => 5120, 'naskah' => 20480];
        $labels = ThesisSubmission::FILE_FIELDS;

        $rules = [];
        $messages = [];

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

        $request->validate($rules, $messages);

        $submission = $existingSubmission ?: new ThesisSubmission([
            'repository_taruna_id' => $taruna->id,
            'submission_code' => $this->generateSubmissionCode(),
        ]);

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
