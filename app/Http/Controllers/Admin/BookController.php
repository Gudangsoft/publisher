<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $books = Book::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.books.form', ['book' => new Book]);
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'edition' => 'nullable|string|max:100',
            'pages' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:50',
            'binding_type' => 'nullable|in:Softcover,Hardcover',
            'paper_type' => 'nullable|in:HVS,Bookpaper,Art Paper,Lainnya',
            'dimensions' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'has_print_version' => 'nullable|boolean',
            'print_version_link' => 'nullable|url|max:500',
            'has_digital_version' => 'nullable|boolean',
            'digital_version_link' => 'nullable|url|max:500',
            'whatsapp_link' => 'nullable|string|max:500',
            'shopee_link' => 'nullable|url|max:500',
            'tokopedia_link' => 'nullable|url|max:500',
            'lazada_link' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('books', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('books/gallery', 'public');
            }
            $data['images'] = $imagePaths;
        }

        Book::create($data);
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dibuat');
    }

    public function edit(Book $book)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.books.form', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'edition' => 'nullable|string|max:100',
            'pages' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:50',
            'binding_type' => 'nullable|in:Softcover,Hardcover',
            'paper_type' => 'nullable|in:HVS,Bookpaper,Art Paper,Lainnya',
            'dimensions' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'has_print_version' => 'nullable|boolean',
            'print_version_link' => 'nullable|url|max:500',
            'has_digital_version' => 'nullable|boolean',
            'digital_version_link' => 'nullable|url|max:500',
            'whatsapp_link' => 'nullable|string|max:500',
            'shopee_link' => 'nullable|url|max:500',
            'tokopedia_link' => 'nullable|url|max:500',
            'lazada_link' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('books', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            // Delete old images if exists
            if ($book->images && is_array($book->images)) {
                foreach ($book->images as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('books/gallery', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $book->update($data);
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Book $book)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}
