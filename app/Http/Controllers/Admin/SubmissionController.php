<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $query = Submission::with(['category', 'reviewer']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('submission_number', 'like', '%' . $search . '%')
                  ->orWhere('submitter_name', 'like', '%' . $search . '%')
                  ->orWhere('submitter_email', 'like', '%' . $search . '%');
            });
        }
        
        $submissions = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get counts for dashboard
        $counts = [
            'total' => Submission::count(),
            'pending' => Submission::pending()->count(),
            'reviewing' => Submission::reviewing()->count(),
            'approved' => Submission::approved()->count(),
        ];
        
        return view('admin.submissions.index', compact('submissions', 'counts'));
    }

    public function show(Submission $submission)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $submission->load(['category', 'reviewer']);
        
        return view('admin.submissions.show', compact('submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $data = $request->validate([
            'status' => 'required|in:pending,reviewing,revision,approved,rejected,in_progress,completed',
            'admin_notes' => 'nullable|string',
            'revision_notes' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'print_quantity' => 'nullable|integer|min:1',
        ]);
        
        $data['reviewed_by'] = auth()->id();
        $data['reviewed_at'] = now();
        
        $submission->update($data);
        
        return redirect()->route('admin.submissions.show', $submission)
            ->with('success', 'Status pengajuan berhasil diperbarui');
    }

    public function destroy(Submission $submission)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete associated files
        if ($submission->manuscript_file) {
            Storage::disk('public')->delete($submission->manuscript_file);
        }
        
        if ($submission->cover_proposal) {
            Storage::disk('public')->delete($submission->cover_proposal);
        }
        
        if ($submission->additional_files) {
            foreach ($submission->additional_files as $file) {
                Storage::disk('public')->delete($file);
            }
        }
        
        $submission->delete();
        
        return redirect()->route('admin.submissions.index')
            ->with('success', 'Pengajuan berhasil dihapus');
    }

    public function download(Submission $submission, string $fileType)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $filePath = match($fileType) {
            'manuscript' => $submission->manuscript_file,
            'cover' => $submission->cover_proposal,
            default => null
        };
        
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }
        
        return Storage::disk('public')->download($filePath);
    }
}
