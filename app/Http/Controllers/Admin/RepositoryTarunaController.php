<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepositoryTaruna;
use App\Models\ThesisSubmission;
use App\Services\RepositoryTarunaRosterImporter;
use App\Services\RepositoryTarunaRosterTemplateBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RepositoryTarunaController extends Controller
{
    public function index(Request $request)
    {
        $query = RepositoryTaruna::with('submission');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('academic_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('korps')) {
            $query->where('korps', $request->korps);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('status')) {
            if ($request->status === 'sudah') {
                $query->whereHas('submission');
            } elseif ($request->status === 'belum') {
                $query->whereDoesntHave('submission');
            } elseif ($request->status === 'published') {
                $query->whereHas('submission', fn ($q) => $q->where('is_published', true));
            } elseif ($request->status === 'pending') {
                $query->whereHas('submission', fn ($q) => $q->where('is_published', false));
            }
        }

        $tarunas = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.repository-taruna.index', [
            'tarunas' => $tarunas,
            'korpsOptions' => RepositoryTaruna::KORPS_OPTIONS,
            'angkatanOptions' => RepositoryTaruna::angkatanOptions(),
            'totalTaruna' => RepositoryTaruna::count(),
            'totalSubmitted' => RepositoryTaruna::has('submission')->count(),
            'totalPublished' => ThesisSubmission::where('is_published', true)->count(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'academic_number' => ['required', 'string', 'max:100', 'unique:repository_tarunas,academic_number'],
            'korps' => ['required', Rule::in(RepositoryTaruna::KORPS_OPTIONS)],
            'angkatan' => ['required', 'string', 'max:10'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'academic_number.required' => 'Nomor Akademik wajib diisi',
            'academic_number.unique' => 'Nomor Akademik sudah terdaftar',
            'korps.in' => 'Korps harus salah satu dari: ' . implode(', ', RepositoryTaruna::KORPS_OPTIONS),
        ]);

        RepositoryTaruna::create($data);

        return back()->with('success', 'Data taruna berhasil ditambahkan.');
    }

    public function update(Request $request, RepositoryTaruna $repositoryTaruna)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'academic_number' => ['required', 'string', 'max:100', 'unique:repository_tarunas,academic_number,' . $repositoryTaruna->id],
            'korps' => ['required', Rule::in(RepositoryTaruna::KORPS_OPTIONS)],
            'angkatan' => ['required', 'string', 'max:10'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'academic_number.required' => 'Nomor Akademik wajib diisi',
            'academic_number.unique' => 'Nomor Akademik sudah terdaftar',
            'korps.in' => 'Korps harus salah satu dari: ' . implode(', ', RepositoryTaruna::KORPS_OPTIONS),
        ]);

        $repositoryTaruna->update($data);

        return back()->with('success', 'Data taruna berhasil diperbarui.');
    }

    public function destroy(RepositoryTaruna $repositoryTaruna)
    {
        $submission = $repositoryTaruna->submission;

        if ($submission) {
            foreach (array_keys(ThesisSubmission::FILE_FIELDS) as $field) {
                if ($submission->{"{$field}_path"}) {
                    Storage::disk('public')->delete($submission->{"{$field}_path"});
                }
            }
        }

        $repositoryTaruna->delete();

        return back()->with('success', 'Data taruna berhasil dihapus.');
    }

    public function publish(RepositoryTaruna $repositoryTaruna)
    {
        $submission = $repositoryTaruna->submission;

        if (!$submission || !$submission->isComplete()) {
            return back()->with('import_warning', 'Berkas belum lengkap, tidak bisa dipublikasikan.');
        }

        $submission->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('success', 'Skripsi berhasil dipublikasikan ke koleksi publik.');
    }

    public function unpublish(RepositoryTaruna $repositoryTaruna)
    {
        $submission = $repositoryTaruna->submission;

        if ($submission) {
            $submission->update(['is_published' => false, 'published_at' => null]);
        }

        return back()->with('success', 'Publikasi skripsi ditarik kembali.');
    }

    public function template()
    {
        $spreadsheet = (new RepositoryTarunaRosterTemplateBuilder())->build();

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="contoh-format-roster-taruna.xlsx"',
        ];

        return new StreamedResponse(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $result = (new RepositoryTarunaRosterImporter())->import($request->file('file')->getRealPath());

        if (!empty($result['skipped'])) {
            $messages = collect($result['skipped'])->take(6)->map(function ($s) {
                return "Sheet {$s['sheet']}" . ($s['row'] ? " baris {$s['row']}" : '') . ": {$s['reason']}";
            })->implode(' | ');

            $extra = count($result['skipped']) > 6 ? ' (+' . (count($result['skipped']) - 6) . ' lainnya)' : '';

            return back()->with('import_warning', "Diimpor: {$result['imported']} baru, {$result['updated']} diperbarui. Dilewati: " . count($result['skipped']) . ". {$messages}{$extra}");
        }

        return back()->with('success', "Daftar taruna berhasil diimpor: {$result['imported']} baru, {$result['updated']} diperbarui.");
    }
}
