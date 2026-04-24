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
        return view('admin.journals.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'journal_link' => 'required|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:51200',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('journals/covers', 'public');
        }

        Journal::create($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $journal = Journal::findOrFail($id);
        return view('admin.journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $journal = Journal::findOrFail($id);
        return view('admin.journals.form', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $journal = Journal::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'journal_link' => 'required|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:51200',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($journal->cover_image) {
                Storage::disk('public')->delete($journal->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('journals/covers', 'public');
        }

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
        if ($journal->cover_image) {
            Storage::disk('public')->delete($journal->cover_image);
        }

        $journal->delete();

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
