<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan Diperbarui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #EE6D26, #f39c12);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #EE6D26;
            padding: 15px;
            margin: 20px 0;
        }
        .status-change {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 25px 0;
            flex-wrap: wrap;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        .status-old {
            background: #e5e7eb;
            color: #6b7280;
        }
        .status-arrow {
            margin: 0 15px;
            font-size: 24px;
            color: #9ca3af;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-shipped { background: #e9d5ff; color: #6b21a8; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .order-progress {
            margin: 30px 0;
        }
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
        }
        .progress-step {
            text-align: center;
            flex: 1;
        }
        .progress-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }
        .progress-active {
            background: #EE6D26;
        }
        .progress-inactive {
            background: #e5e7eb;
            color: #9ca3af;
        }
        .progress-complete {
            background: #10b981;
        }
        .progress-label {
            font-size: 12px;
            color: #666;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th {
            background: #f8f9fa;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .total-row {
            font-weight: bold;
            background: #f8f9fa;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }
        .btn {
            display: inline-block;
            background: #EE6D26;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @php
    $statusLabels = [
        'pending' => 'Pending',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
    
    $statusMessages = [
        'processing' => 'Pesanan Anda sedang diproses dan akan segera dikirim.',
        'shipped' => 'Pesanan Anda telah dikirim! Silakan pantau pengiriman Anda.',
        'completed' => 'Pesanan Anda telah selesai. Terima kasih atas pembelian Anda!',
        'cancelled' => 'Pesanan Anda telah dibatalkan.',
    ];
    
    $statusOrder = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'completed' => 4];
    $currentOrder = $statusOrder[$newStatus] ?? 0;
    @endphp

    <div class="header">
        <h1>📦 Status Pesanan Diperbarui</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $order->customer_name }}</strong>,</p>
        
        <p>Status pesanan Anda telah diperbarui:</p>
        
        <div class="status-change">
            <span class="status-badge status-old">{{ $statusLabels[$oldStatus] ?? ucfirst($oldStatus) }}</span>
            <span class="status-arrow">→</span>
            <span class="status-badge status-{{ $newStatus }}">{{ $statusLabels[$newStatus] ?? ucfirst($newStatus) }}</span>
        </div>

        @if($newStatus != 'cancelled')
        <!-- Progress Bar -->
        <div class="order-progress">
            <div class="progress-steps">
                @foreach(['pending' => 'Pending', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai'] as $key => $label)
                @php
                    $stepOrder = $statusOrder[$key];
                    $isComplete = $currentOrder > $stepOrder;
                    $isActive = $currentOrder == $stepOrder;
                @endphp
                <div class="progress-step">
                    <div class="progress-circle {{ $isComplete ? 'progress-complete' : ($isActive ? 'progress-active' : 'progress-inactive') }}">
                        @if($isComplete)
                            ✓
                        @else
                            {{ $stepOrder }}
                        @endif
                    </div>
                    <div class="progress-label">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="info-box">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">No. Pesanan:</td>
                    <td style="padding: 8px 0;">{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Tanggal Pesanan:</td>
                    <td style="padding: 8px 0;">{{ $order->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Total:</td>
                    <td style="padding: 8px 0; font-weight: bold; color: #EE6D26;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <p>{{ $statusMessages[$newStatus] ?? 'Status pesanan Anda telah diperbarui.' }}</p>

        <h3>Detail Pesanan</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->book->title ?? 'Item' }}</td>
                    <td style="text-align: right;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td style="text-align: right;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Alamat Pengiriman</h3>
        <p>
            {{ $order->customer_name }}<br>
            {{ $order->customer_phone }}<br>
            {{ $order->shipping_address }}
        </p>

        <center>
            <a href="{{ url('/dashboard/orders/' . $order->id) }}" class="btn">Lihat Detail Pesanan</a>
        </center>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
