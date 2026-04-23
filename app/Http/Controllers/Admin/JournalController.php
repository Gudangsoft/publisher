<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journals = Journal::with('category')->latest()->get();
        return view('admin.journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'journal')->get();
        return view('admin.journals.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'nullable|string',
            'authors' => 'required|string',
            'affiliation' => 'nullable|string',
            'doi' => 'nullable|string',
            'volume' => 'nullable|string',
            'issue' => 'nullable|string',
            'pages' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'issn' => 'nullable|string',
            'language' => 'nullable|string',
            'citation_format' => 'nullable|string',
            'journal_link' => 'nullable|url',
            'is_published' => 'nullable|boolean',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file uploads
        if ($request->hasFile('file_pdf')) {
            $validated['file_pdf'] = $request->file('file_pdf')->store('journals/pdf', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('journals/covers', 'public');
        }

        $validated['is_published'] = $request->has('is_published');

        Journal::create($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $journal = Journal::with('category')->findOrFail($id);
        return view('admin.journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $journal = Journal::findOrFail($id);
        $categories = Category::where('type', 'journal')->get();
        return view('admin.journals.form', compact('journal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $journal = Journal::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'nullable|string',
            'authors' => 'required|string',
            'affiliation' => 'nullable|string',
            'doi' => 'nullable|string',
            'volume' => 'nullable|string',
            'issue' => 'nullable|string',
            'pages' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'issn' => 'nullable|string',
            'language' => 'nullable|string',
            'citation_format' => 'nullable|string',
            'journal_link' => 'nullable|url',
            'is_published' => 'nullable|boolean',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file uploads
        if ($request->hasFile('file_pdf')) {
            // Delete old file
            if ($journal->file_pdf) {
                Storage::disk('public')->delete($journal->file_pdf);
            }
            $validated['file_pdf'] = $request->file('file_pdf')->store('journals/pdf', 'public');
        }

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($journal->cover_image) {
                Storage::disk('public')->delete($journal->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('journals/covers', 'public');
        }

        $validated['is_published'] = $request->has('is_published');

        $journal->update($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $journal = Journal::findOrFail($id);

        // Delete associated files
        if ($journal->file_pdf) {
            Storage::disk('public')->delete($journal->file_pdf);
        }
        if ($journal->cover_image) {
            Storage::disk('public')->delete($journal->cover_image);
        }

        $journal->delete();

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
