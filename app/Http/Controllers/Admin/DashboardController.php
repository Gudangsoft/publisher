<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\Submission;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Main Statistics
        $stats = [
            'total_books' => Book::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_users' => User::where('is_admin', false)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'pending_submissions' => Submission::where('status', 'pending')->count(),
        ];

        // Calculate percentage changes from last month
        $lastMonth = Carbon::now()->subMonth();
        $stats['books_change'] = $this->calculatePercentageChange(
            Book::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count(),
            Book::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count()
        );
        $stats['orders_change'] = $this->calculatePercentageChange(
            Order::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count(),
            Order::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count()
        );
        $stats['revenue_change'] = $this->calculatePercentageChange(
            Order::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->where('status', '!=', 'cancelled')->sum('total_amount'),
            Order::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('status', '!=', 'cancelled')->sum('total_amount')
        );
        $stats['users_change'] = $this->calculatePercentageChange(
            User::where('is_admin', false)->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count(),
            User::where('is_admin', false)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count()
        );

        // Monthly sales data for chart (last 12 months)
        $monthlySales = $this->getMonthlySalesData();

        // Category distribution
        $categoryDistribution = $this->getCategoryDistribution();

        // Recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top selling books (based on order items if available)
        $topBooks = $this->getTopSellingBooks();

        // Recent activities
        $recentActivities = $this->getRecentActivities();

        // Submissions chart data (per status)
        $submissionStats = Submission::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'monthlySales',
            'categoryDistribution',
            'recentOrders',
            'topBooks',
            'recentActivities',
            'submissionStats'
        ));
    }

    private function calculatePercentageChange($oldValue, $newValue): array
    {
        if ($oldValue == 0) {
            return ['value' => $newValue > 0 ? 100 : 0, 'positive' => $newValue > 0];
        }
        
        $change = (($newValue - $oldValue) / $oldValue) * 100;
        return ['value' => round(abs($change)), 'positive' => $change >= 0];
    }

    private function getMonthlySalesData(): array
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');
            
            $revenue = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
            
            $data[] = round($revenue / 1000000, 1); // Convert to millions
        }

        $totalSales = array_sum($data);
        $avgSales = count($data) > 0 ? round($totalSales / count($data), 1) : 0;

        return [
            'labels' => $months,
            'data' => $data,
            'total' => $totalSales,
            'average' => $avgSales,
        ];
    }

    private function getCategoryDistribution(): array
    {
        $totalBooks = Book::count();
        
        if ($totalBooks === 0) {
            return [];
        }

        $categories = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->limit(6)
            ->get();

        $distribution = [];
        $colors = ['#EE6D26', '#3B82F6', '#10B981', '#FBBF24', '#8B5CF6', '#6B7280'];
        
        foreach ($categories as $index => $category) {
            $percentage = round(($category->books_count / $totalBooks) * 100);
            if ($percentage > 0) {
                $distribution[] = [
                    'name' => $category->name,
                    'count' => $category->books_count,
                    'percentage' => $percentage,
                    'color' => $colors[$index] ?? '#6B7280',
                ];
            }
        }

        return $distribution;
    }

    private function getTopSellingBooks(): \Illuminate\Database\Eloquent\Collection
    {
        // Get books with most order items
        return Book::select('books.*')
            ->leftJoin('order_items', 'books.id', '=', 'order_items.book_id')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->groupBy('books.id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
    }

    private function getRecentActivities(): array
    {
        $activities = [];

        // Recent books
        $recentBooks = Book::orderBy('created_at', 'desc')->limit(2)->get();
        foreach ($recentBooks as $book) {
            $activities[] = [
                'icon' => 'book',
                'text' => 'Buku baru "' . \Str::limit($book->title, 30) . '" ditambahkan',
                'time' => $book->created_at,
                'color' => 'primary',
            ];
        }

        // Recent orders
        $recentOrdersActivity = Order::orderBy('created_at', 'desc')->limit(2)->get();
        foreach ($recentOrdersActivity as $order) {
            $activities[] = [
                'icon' => 'shopping',
                'text' => 'Pesanan #' . $order->order_number . ' - ' . $order->status_label,
                'time' => $order->created_at,
                'color' => 'green',
            ];
        }

        // Recent submissions
        $recentSubmissions = Submission::orderBy('created_at', 'desc')->limit(2)->get();
        foreach ($recentSubmissions as $submission) {
            $activities[] = [
                'icon' => 'document',
                'text' => 'Submisi baru "' . \Str::limit($submission->title, 30) . '"',
                'time' => $submission->created_at,
                'color' => 'blue',
            ];
        }

        // Recent users
        $recentUsers = User::where('is_admin', false)->orderBy('created_at', 'desc')->limit(1)->get();
        foreach ($recentUsers as $user) {
            $activities[] = [
                'icon' => 'user',
                'text' => 'Pengguna baru mendaftar: ' . $user->email,
                'time' => $user->created_at,
                'color' => 'purple',
            ];
        }

        // Sort by time
        usort($activities, function ($a, $b) {
            return $b['time'] <=> $a['time'];
        });

        // Format time and limit to 5
        return array_slice(array_map(function ($activity) {
            $activity['time_formatted'] = $activity['time']->diffForHumans();
            return $activity;
        }, $activities), 0, 5);
    }
}
