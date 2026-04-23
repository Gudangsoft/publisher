<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $year = $request->get('year', date('Y'));
        
        // Monthly sales data
        $salesData = [];
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            
            $orders = Order::whereBetween('created_at', [$startDate, $endDate])
                          ->where('status', '!=', 'cancelled')
                          ->get();
            
            $revenue = $orders->sum('total_amount');
            $orderCount = $orders->count();
            $booksCount = OrderItem::whereIn('order_id', $orders->pluck('id'))->sum('quantity');
            
            $salesData[] = [
                'month' => $months[$month - 1],
                'revenue' => $revenue,
                'orders' => $orderCount,
                'books_sold' => $booksCount,
            ];
        }
        
        // Summary statistics
        $totalRevenue = array_sum(array_column($salesData, 'revenue'));
        $totalOrders = array_sum(array_column($salesData, 'orders'));
        $totalBooks = array_sum(array_column($salesData, 'books_sold'));
        $avgPerOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Top selling books
        $topBooks = OrderItem::select('book_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->with('book')
            ->groupBy('book_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // Recent orders
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Status breakdown
        $statusBreakdown = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        // Customer statistics
        $totalCustomers = User::where('is_admin', false)->count();
        $customersWithOrders = Order::distinct('user_id')->count('user_id');
        
        return view('admin.reports.index', compact(
            'salesData',
            'totalRevenue',
            'totalOrders',
            'totalBooks',
            'avgPerOrder',
            'topBooks',
            'recentOrders',
            'statusBreakdown',
            'totalCustomers',
            'customersWithOrders',
            'year'
        ));
    }
}
