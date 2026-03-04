<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate and download invoice PDF for user's order
     */
    public function downloadUserInvoice($orderId)
    {
        $user = auth()->user();
        
        $order = Order::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->where('id', $orderId)
            ->with('items.book')
            ->firstOrFail();

        return $this->generatePdf($order);
    }

    /**
     * Generate and download invoice PDF for admin
     */
    public function downloadAdminInvoice($orderId)
    {
        $user = auth()->user();
        
        if (!$user->is_admin) {
            abort(403);
        }

        $order = Order::with('items.book')->findOrFail($orderId);

        return $this->generatePdf($order);
    }

    /**
     * Generate PDF
     */
    private function generatePdf(Order $order)
    {
        $data = [
            'order' => $order,
            'company' => [
                'name' => \App\Models\Setting::get('site_name', 'Naval Academy Publishing'),
                'address' => \App\Models\Setting::get('company_address', 'Jakarta, Indonesia'),
                'phone' => \App\Models\Setting::get('company_phone', '-'),
                'email' => \App\Models\Setting::get('company_email', 'info@navalacademypublishing.com'),
                'logo' => \App\Models\Setting::get('site_logo', null),
            ],
        ];

        $pdf = Pdf::loadView('invoices.order', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'invoice-' . $order->order_number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Stream PDF (view in browser)
     */
    public function streamInvoice($orderId)
    {
        $user = auth()->user();
        
        $order = Order::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->where('id', $orderId)
            ->with('items.book')
            ->firstOrFail();

        $data = [
            'order' => $order,
            'company' => [
                'name' => \App\Models\Setting::get('site_name', 'Naval Academy Publishing'),
                'address' => \App\Models\Setting::get('company_address', 'Jakarta, Indonesia'),
                'phone' => \App\Models\Setting::get('company_phone', '-'),
                'email' => \App\Models\Setting::get('company_email', 'info@navalacademypublishing.com'),
                'logo' => \App\Models\Setting::get('site_logo', null),
            ],
        ];

        $pdf = Pdf::loadView('invoices.order', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('invoice-' . $order->order_number . '.pdf');
    }
}
