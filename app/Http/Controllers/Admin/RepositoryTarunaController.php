<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RepositoryTarunaTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\RepositoryTarunaImport;
use App\Models\RepositoryTaruna;
use App\Models\ThesisSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

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
        return Excel::download(new RepositoryTarunaTemplateExport(), 'template-data-taruna.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new RepositoryTarunaImport();
        Excel::import($import, $request->file('file'));

        if ($import->failures()->isNotEmpty()) {
            $messages = $import->failures()->take(5)->map(function ($failure) {
                return 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            })->implode(' | ');

            return back()->with('import_warning', 'Sebagian baris gagal diimpor. ' . $messages);
        }

        return back()->with('success', 'Daftar taruna berhasil diimpor.');
    }
}
