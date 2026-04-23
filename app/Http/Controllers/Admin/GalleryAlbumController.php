<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryAlbumController extends Controller
{
    /**
     * Display album listing
     */
    public function index(Request $request)
    {
        $query = GalleryAlbum::withCount(['galleries', 'galleries as active_galleries_count' => function ($q) {
            $q->where('is_active', true);
        }]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $albums = $query->ordered()->paginate(20);

        return view('admin.gallery-albums.index', compact('albums'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.gallery-albums.create');
    }

    /**
     * Store a new album with multiple photos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
            'display_order' => $validated['display_order'] ?? 0,
        ];

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('gallery-albums', 'public');
        }

        $album = GalleryAlbum::create($data);

        // Handle multiple photo uploads
        if ($request->hasFile('photos')) {
            $order = 0;
            foreach ($request->file('photos') as $photo) {
                $filePath = $photo->store('galleries', 'public');
                Gallery::create([
                    'title' => pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME),
                    'type' => 'photo',
                    'file_path' => $filePath,
                    'gallery_album_id' => $album->id,
                    'is_active' => true,
                    'display_order' => $order++,
                ]);
            }
        }

        $photoCount = $request->hasFile('photos') ? count($request->file('photos')) : 0;
        $message = 'Album berhasil ditambahkan!';
        if ($photoCount > 0) {
            $message .= " {$photoCount} foto berhasil diupload.";
        }

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', $message);
    }

    /**
     * Show album detail with its photos
     */
    public function show(GalleryAlbum $gallery_album)
    {
        $gallery_album->load(['galleries' => function ($q) {
            $q->ordered();
        }]);

        return view('admin.gallery-albums.show', ['album' => $gallery_album]);
    }

    /**
     * Show edit form
     */
    public function edit(GalleryAlbum $gallery_album)
    {
        return view('admin.gallery-albums.edit', ['album' => $gallery_album]);
    }

    /**
     * Update an album
     */
    public function update(Request $request, GalleryAlbum $gallery_album)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
            'display_order' => $validated['display_order'] ?? 0,
        ];

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($gallery_album->cover_image) {
                Storage::disk('public')->delete($gallery_album->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('gallery-albums', 'public');
        }

        // Handle cover image removal
        if ($request->has('remove_cover') && $request->remove_cover) {
            if ($gallery_album->cover_image) {
                Storage::disk('public')->delete($gallery_album->cover_image);
            }
            $data['cover_image'] = null;
        }

        $gallery_album->update($data);

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            $maxOrder = $gallery_album->galleries()->max('display_order') ?? -1;
            $order = $maxOrder + 1;
            foreach ($request->file('photos') as $photo) {
                $filePath = $photo->store('galleries', 'public');
                Gallery::create([
                    'title' => pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME),
                    'type' => 'photo',
                    'file_path' => $filePath,
                    'gallery_album_id' => $gallery_album->id,
                    'is_active' => true,
                    'display_order' => $order++,
                ]);
            }
        }

        $photoCount = $request->hasFile('photos') ? count($request->file('photos')) : 0;
        $message = 'Album berhasil diperbarui!';
        if ($photoCount > 0) {
            $message .= " {$photoCount} foto baru ditambahkan.";
        }

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', $message);
    }

    /**
     * Delete an album
     */
    public function destroy(GalleryAlbum $gallery_album)
    {
        // Delete cover image
        if ($gallery_album->cover_image) {
            Storage::disk('public')->delete($gallery_album->cover_image);
        }

        // Delete all gallery photos in this album
        foreach ($gallery_album->galleries as $gallery) {
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            if ($gallery->thumbnail) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            $gallery->delete();
        }

        $gallery_album->delete();

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Album dan semua foto di dalamnya berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(GalleryAlbum $gallery_album)
    {
        $gallery_album->update(['is_active' => !$gallery_album->is_active]);

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Status album berhasil diubah!');
    }

    /**
     * Add photos to an existing album
     */
    public function addPhotos(Request $request, GalleryAlbum $gallery_album)
    {
        $request->validate([
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $maxOrder = $gallery_album->galleries()->max('display_order') ?? -1;
        $order = $maxOrder + 1;
        $count = 0;

        foreach ($request->file('photos') as $photo) {
            $filePath = $photo->store('galleries', 'public');
            Gallery::create([
                'title' => pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME),
                'type' => 'photo',
                'file_path' => $filePath,
                'gallery_album_id' => $gallery_album->id,
                'is_active' => true,
                'display_order' => $order++,
            ]);
            $count++;
        }

        return redirect()->route('admin.gallery-albums.show', $gallery_album)
            ->with('success', "{$count} foto berhasil ditambahkan ke album!");
    }

    /**
     * Delete a single photo from album
     */
    public function addVideo(Request $request, GalleryAlbum $gallery_album)
    {
        $request->validate([
            'video_url' => 'required|url',
            'title' => 'required|string|max:255',
        ]);

        $maxOrder = $gallery_album->galleries()->max('display_order') ?? -1;

        Gallery::create([
            'title' => $request->title,
            'type' => 'video',
            'video_url' => $request->video_url,
            'gallery_album_id' => $gallery_album->id,
            'is_active' => true,
            'display_order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.gallery-albums.show', $gallery_album)
            ->with('success', 'Video berhasil ditambahkan ke album!');
    }

    /**
     * Delete a single photo from album
     */
    public function deletePhoto(GalleryAlbum $gallery_album, Gallery $gallery)
    {
        if ($gallery->gallery_album_id !== $gallery_album->id) {
            abort(404);
        }

        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        if ($gallery->thumbnail) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery-albums.show', $gallery_album)
            ->with('success', 'Foto berhasil dihapus dari album!');
    }
}
