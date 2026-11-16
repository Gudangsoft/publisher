<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $query = Review::with(['book:id,title', 'moderator:id,name']);
        match ($status) {
            'pending' => $query->pending(),
            'approved' => $query->approved(),
            'spam' => $query->spam(),
            default => $status = 'all',
        };

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                  ->orWhere('review_text', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'all' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'spam' => Review::spam()->count(),
            'average' => round((float) Review::approved()->avg('rating'), 1),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats', 'status'));
    }

    /**
     * Aksi moderasi cepat: approve, reject (kembali ke antrean), spam, not_spam, feature, unfeature.
     */
    public function moderate(Request $request, Review $review)
    {
        $action = $request->validate([
            'action' => 'required|in:approve,unapprove,spam,not_spam,feature,unfeature',
        ])['action'];

        $changes = match ($action) {
            'approve' => ['is_approved' => true, 'is_spam' => false],
            'unapprove' => ['is_approved' => false, 'is_featured' => false],
            'spam' => ['is_spam' => true, 'is_approved' => false, 'is_featured' => false],
            'not_spam' => ['is_spam' => false],
            'feature' => ['is_featured' => true, 'is_approved' => true, 'is_spam' => false],
            'unfeature' => ['is_featured' => false],
        };

        $review->update($changes + ['moderated_at' => now(), 'moderated_by' => auth()->id()]);

        $labels = [
            'approve' => 'disetujui', 'unapprove' => 'dikembalikan ke antrean', 'spam' => 'ditandai spam',
            'not_spam' => 'dipulihkan dari spam', 'feature' => 'ditampilkan di beranda', 'unfeature' => 'dihapus dari beranda',
        ];

        return back()->with('success', 'Ulasan dari ' . $review->reviewer_name . ' ' . $labels[$action] . '.');
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
            'reviewer_role' => 'nullable|string|max:50',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:book,publisher',
        ]);

        // Handle checkboxes explicitly
        $validated['is_approved'] = $request->has('is_approved') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        if ($validated['is_approved']) {
            $validated['is_spam'] = false;
        }
        $validated['moderated_at'] = now();
        $validated['moderated_by'] = auth()->id();

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
            'reviewer_role' => 'nullable|string|max:50',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:book,publisher',
        ]);

        // Handle checkboxes explicitly
        $validated['is_approved'] = $request->has('is_approved') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        if ($validated['is_approved']) {
            $validated['is_spam'] = false;
        }
        $validated['moderated_at'] = now();
        $validated['moderated_by'] = auth()->id();

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
