<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('book')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $books = Book::orderBy('title')->get();
        return view('admin.reviews.form', ['review' => new Review(), 'books' => $books]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'nullable|exists:books,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'reviewer_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:book,publisher',
        ]);

        // Handle checkboxes explicitly
        $validated['is_approved'] = $request->has('is_approved') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('reviewer_photo')) {
            $validated['reviewer_photo'] = $request->file('reviewer_photo')->store('reviews', 'public');
        }

        Review::create($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil ditambahkan.');
    }

    public function edit(Review $review)
    {
        $books = Book::orderBy('title')->get();
        return view('admin.reviews.form', compact('review', 'books'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'book_id' => 'nullable|exists:books,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'reviewer_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:book,publisher',
        ]);

        // Handle checkboxes explicitly
        $validated['is_approved'] = $request->has('is_approved') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('reviewer_photo')) {
            if ($review->reviewer_photo) {
                Storage::disk('public')->delete($review->reviewer_photo);
            }
            $validated['reviewer_photo'] = $request->file('reviewer_photo')->store('reviews', 'public');
        }

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil diperbarui.');
    }

    public function destroy(Review $review)
    {
        if ($review->reviewer_photo) {
            Storage::disk('public')->delete($review->reviewer_photo);
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil dihapus.');
    }
}
