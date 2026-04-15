<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display gallery listing
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $galleries = $query->ordered()->paginate(20);
        $categories = Gallery::getCategories();

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = Gallery::getCategories();
        return view('admin.galleries.create', compact('categories'));
    }

    /**
     * Store a new gallery item
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ];

        if ($request->type === 'photo') {
            $rules['file'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['video_url'] = 'required|url';
            $rules['thumbnail_file'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        $validated = $request->validate($rules);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'category' => $request->category_new ?: ($validated['category'] ?? null),
            'is_active' => $request->has('is_active'),
            'display_order' => $validated['display_order'] ?? 0,
        ];

        // Handle photo upload
        if ($request->type === 'photo' && $request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('galleries', 'public');
        }

        // Handle video
        if ($request->type === 'video') {
            $data['video_url'] = $validated['video_url'] ?? null;
            
            if ($request->hasFile('thumbnail_file')) {
                $data['thumbnail'] = $request->file('thumbnail_file')->store('galleries/thumbnails', 'public');
            }
        }

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Item galeri berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function edit(Gallery $gallery)
    {
        $categories = Gallery::getCategories();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    /**
     * Update a gallery item
     */
    public function update(Request $request, Gallery $gallery)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ];

        if ($request->type === 'photo') {
            $rules['file'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['video_url'] = 'required|url';
            $rules['thumbnail_file'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        $validated = $request->validate($rules);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'category' => $request->category_new ?: ($validated['category'] ?? null),
            'is_active' => $request->has('is_active'),
            'display_order' => $validated['display_order'] ?? 0,
        ];

        // Handle photo upload
        if ($request->type === 'photo' && $request->hasFile('file')) {
            // Delete old file
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $data['file_path'] = $request->file('file')->store('galleries', 'public');
        }

        // Handle video
        if ($request->type === 'video') {
            $data['video_url'] = $validated['video_url'] ?? null;
            
            if ($request->hasFile('thumbnail_file')) {
                // Delete old thumbnail
                if ($gallery->thumbnail) {
                    Storage::disk('public')->delete($gallery->thumbnail);
                }
                $data['thumbnail'] = $request->file('thumbnail_file')->store('galleries/thumbnails', 'public');
            }
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Item galeri berhasil diperbarui!');
    }

    /**
     * Delete a gallery item
     */
    public function destroy(Gallery $gallery)
    {
        // Delete associated files
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        if ($gallery->thumbnail) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Item galeri berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Status item galeri berhasil diubah!');
    }
}
