<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Order;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get user's submissions
        $submissions = Submission::where('submitter_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get user's orders
        $orders = Order::where('user_id', $user->id)
            ->orWhere('customer_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate stats
        $stats = [
            'total_submissions' => Submission::where('submitter_email', $user->email)->count(),
            'pending_submissions' => Submission::where('submitter_email', $user->email)
                ->where('status', 'pending')
                ->count(),
            'approved_submissions' => Submission::where('submitter_email', $user->email)
                ->where('status', 'approved')
                ->count(),
            'total_orders' => Order::where('user_id', $user->id)
                ->orWhere('customer_email', $user->email)
                ->count(),
            'total_spent' => Order::where(function($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('customer_email', $user->email);
                })
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
        ];

        return view('user.dashboard', compact('submissions', 'orders', 'stats'));
    }

    /**
     * Display all submissions for user
     */
    public function submissions(Request $request)
    {
        $user = auth()->user();
        
        $query = Submission::where('submitter_email', $user->email);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $submissions = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.submissions', compact('submissions'));
    }

    /**
     * Display single submission detail
     */
    public function showSubmission($id)
    {
        $user = auth()->user();
        
        $submission = Submission::where('submitter_email', $user->email)
            ->where('id', $id)
            ->firstOrFail();

        return view('user.submission-detail', compact('submission'));
    }

    public function reviseSubmission(Request $request, $id)
    {
        $user = auth()->user();

        $submission = Submission::where('submitter_email', $user->email)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'manuscript_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'cover_proposal' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // If user uploads a new file, store it and update the record.
        if ($request->hasFile('manuscript_file')) {
            // Delete old file if exists
            if ($submission->manuscript_file) {
                Storage::disk('public')->delete($submission->manuscript_file);
            }
            $submission->manuscript_file = $request->file('manuscript_file')
                ->store('submissions/manuscripts', 'public');
        }

        if ($request->hasFile('cover_proposal')) {
            if ($submission->cover_proposal) {
                Storage::disk('public')->delete($submission->cover_proposal);
            }
            $submission->cover_proposal = $request->file('cover_proposal')
                ->store('submissions/covers', 'public');
        }

        // When user submits a revision, clear the previous review note and mark it for re-review
        $submission->reviewed_by = null;
        $submission->reviewed_at = null;
        $submission->status = 'reviewing';
        $submission->revision_notes = null;
        $submission->save();

        return redirect()->route('user.submissions.show', $submission->id)
            ->with('success', 'Revisi Anda telah berhasil dikirim. Tim kami akan meninjau kembali.');
    }

    /**
     * Display all orders for user
     */
    public function orders(Request $request)
    {
        $user = auth()->user();
        
        $query = Order::where('user_id', $user->id)
            ->orWhere('customer_email', $user->email);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    /**
     * Display single order detail
     */
    public function showOrder($id)
    {
        $user = auth()->user();
        
        $order = Order::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->where('id', $id)
            ->with('items.book')
            ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }
}
