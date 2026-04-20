<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Submission;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Export orders to CSV
     */
    public function orders(Request $request)
    {
        
        $query = Order::with(['user', 'items']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $filename = 'orders-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () {
            $orders = Order::with(['user', 'items'])->latest()->get();
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'No. Pesanan',
                'Tanggal',
                'Nama Pelanggan',
                'Email',
                'Telepon',
                'Total',
                'Status',
                'Status Pembayaran',
                'Metode Pembayaran',
                'Alamat',
                'Jumlah Item',
            ]);

            // Data
            foreach ($orders as $order) {
                fputcsv($file, array_map([$this, 'sanitizeForCsv'], [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->total_amount,
                    $order->status_label,
                    ucfirst($order->payment_status ?? 'pending'),
                    ucfirst($order->payment_method ?? '-'),
                    $order->shipping_address,
                    $order->items->count(),
                ]));
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export submissions to CSV
     */
    public function submissions(Request $request)
    {
        
        $query = Submission::with(['category', 'bookTemplate']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $submissions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'submissions-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'No. Submisi',
                'Tanggal',
                'Judul',
                'Jenis',
                'Kategori',
                'Nama Pengirim',
                'Email',
                'Telepon',
                'Institusi',
                'Est. Halaman',
                'Status',
                'Estimasi Biaya',
                'Diulas Oleh',
                'Tanggal Review',
            ]);

            // Data
            $typeLabels = [
                'book' => 'Buku',
                'journal' => 'Jurnal',
                'thesis' => 'Skripsi/Tesis',
                'other' => 'Lainnya',
            ];

            $statusLabels = [
                'pending' => 'Menunggu',
                'in_review' => 'Direview',
                'revision_required' => 'Perlu Revisi',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'in_production' => 'Produksi',
                'completed' => 'Selesai',
            ];

            foreach ($submissions as $submission) {
                fputcsv($file, array_map([$this, 'sanitizeForCsv'], [
                    $submission->submission_number,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->title,
                    $typeLabels[$submission->type] ?? $submission->type,
                    $submission->category->name ?? '-',
                    $submission->submitter_name,
                    $submission->submitter_email,
                    $submission->submitter_phone,
                    $submission->submitter_institution ?? '-',
                    $submission->estimated_pages ?? '-',
                    $statusLabels[$submission->status] ?? $submission->status,
                    $submission->estimated_cost ?? '-',
                    $submission->reviewed_by ?? '-',
                    $submission->reviewed_at ? $submission->reviewed_at->format('Y-m-d H:i:s') : '-',
                ]));
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export books to CSV
     */
    public function books(Request $request)
    {
        
        $query = Book::with(['category']);
        
        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->orderBy('created_at', 'desc')->get();

        $filename = 'books-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($books) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'ID',
                'Judul',
                'Penulis',
                'ISBN',
                'Kategori',
                'Harga',
                'Stok',
                'Penerbit',
                'Tahun Terbit',
                'Halaman',
                'Tanggal Dibuat',
            ]);

            foreach ($books as $book) {
                fputcsv($file, array_map([$this, 'sanitizeForCsv'], [
                    $book->id,
                    $book->title,
                    $book->author ?? '-',
                    $book->isbn ?? '-',
                    $book->category->name ?? '-',
                    $book->price ?? 0,
                    $book->stock ?? 0,
                    $book->publisher ?? '-',
                    $book->publish_year ?? '-',
                    $book->pages ?? '-',
                    $book->created_at->format('Y-m-d H:i:s'),
                ]));
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export users to CSV
     */
    public function users(Request $request)
    {
        
        $users = User::orderBy('created_at', 'desc')->get();

        $filename = 'users-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'ID',
                'Nama',
                'Email',
                'Admin',
                'Tanggal Daftar',
            ]);

            foreach ($users as $user) {
                fputcsv($file, array_map([$this, 'sanitizeForCsv'], [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->is_admin ? 'Ya' : 'Tidak',
                    $user->created_at->format('Y-m-d H:i:s'),
                ]));
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Sanitize data for CSV to prevent formula injection
     */
    private function sanitizeForCsv($value)
    {
        if (is_numeric($value)) {
            return $value;
        }

        $value = (string) $value;
        $triggers = ['=', '+', '-', '@'];

        if (strlen($value) > 0 && in_array($value[0], $triggers)) {
            return "'" . $value;
        }

        return $value;
    }

}
