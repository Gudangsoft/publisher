<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Category;
use App\Models\BookTemplate;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Show submission form
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $templates = BookTemplate::active()->orderBy('display_order')->orderBy('name')->get();
        return view('submissions.create', compact('categories', 'templates'));
    }

    /**
     * Store new submission
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:book,journal',
            'category_id' => 'nullable|exists:categories,id',
            'book_template_id' => 'nullable|exists:book_templates,id',
            'submitter_name' => 'required|string|max:255',
            'submitter_email' => 'required|email|max:255',
            'submitter_phone' => 'required|string|max:20',
            'submitter_institution' => 'nullable|string|max:255',
            'submitter_address' => 'nullable|string|max:1000',
            'description' => 'required|string|max:2000',
            'synopsis' => 'nullable|string|max:5000',
            'estimated_pages' => 'nullable|integer|min:1|max:10000',
            'target_audience' => 'nullable|string|max:255',
            'language' => 'required|string|max:50',
            'manuscript_file' => 'required|file|mimes:pdf,doc,docx|max:20480', // Max 20MB
            'cover_proposal' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'additional_files.*' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:10240', // Max 10MB each
        ], [
            'title.required' => 'Judul naskah wajib diisi',
            'type.required' => 'Jenis pengajuan wajib dipilih',
            'submitter_name.required' => 'Nama lengkap wajib diisi',
            'submitter_email.required' => 'Email wajib diisi',
            'submitter_email.email' => 'Format email tidak valid',
            'submitter_phone.required' => 'Nomor telepon wajib diisi',
            'description.required' => 'Deskripsi naskah wajib diisi',
            'manuscript_file.required' => 'File naskah wajib diunggah',
            'manuscript_file.mimes' => 'File naskah harus berformat PDF, DOC, atau DOCX',
            'manuscript_file.max' => 'Ukuran file naskah maksimal 20MB',
            'cover_proposal.image' => 'Cover proposal harus berupa gambar',
            'cover_proposal.max' => 'Ukuran cover proposal maksimal 5MB',
        ]);

        // Generate submission number
        $data['submission_number'] = Submission::generateSubmissionNumber();
        $data['status'] = 'pending';

        // Upload manuscript file
        if ($request->hasFile('manuscript_file')) {
            $data['manuscript_file'] = $request->file('manuscript_file')
                ->store('submissions/manuscripts', 'public');
        }

        // Upload cover proposal
        if ($request->hasFile('cover_proposal')) {
            $data['cover_proposal'] = $request->file('cover_proposal')
                ->store('submissions/covers', 'public');
        }

        // Upload additional files
        if ($request->hasFile('additional_files')) {
            $additionalPaths = [];
            foreach ($request->file('additional_files') as $file) {
                $additionalPaths[] = $file->store('submissions/additional', 'public');
            }
            $data['additional_files'] = $additionalPaths;
        }

        $submission = Submission::create($data);

        return redirect()->route('submissions.success', $submission->submission_number)
            ->with('success', 'Pengajuan berhasil dikirim!');
    }

    /**
     * Show success page
     */
    public function success(string $submissionNumber)
    {
        $submission = Submission::where('submission_number', $submissionNumber)->firstOrFail();
        return view('submissions.success', compact('submission'));
    }

    /**
     * Track submission status
     */
    public function track(Request $request)
    {
        $submission = null;
        
        if ($request->filled('number')) {
            $submission = Submission::where('submission_number', $request->number)->first();
        }
        
        return view('submissions.track', compact('submission'));
    }

    /**
     * Download book template file
     */
    public function downloadTemplate(BookTemplate $template)
    {
        if (!$template->template_file || !$template->is_active) {
            abort(404, 'File template tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $template->template_file);
        
        if (!file_exists($path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return response()->download($path);
    }
}
