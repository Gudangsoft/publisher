<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .invoice-container {
            padding: 30px;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #EE6D26;
            padding-bottom: 20px;
        }
        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #EE6D26;
            margin-bottom: 5px;
        }
        .company-info {
            font-size: 11px;
            color: #666;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 14px;
            color: #666;
        }
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .info-box {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info-box-right {
            margin-left: 15px;
        }
        .info-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 12px;
            color: #333;
            font-weight: normal;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #EE6D26;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        .items-table th:last-child {
            text-align: right;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        .items-table td:last-child {
            text-align: right;
        }
        .items-table tr:nth-child(even) {
            background: #fafafa;
        }
        .totals-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .totals-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        .totals-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }
        .totals-table {
            width: 100%;
        }
        .totals-table td {
            padding: 8px 10px;
            font-size: 12px;
        }
        .totals-table .total-row {
            background: #f8f9fa;
            font-weight: bold;
            font-size: 14px;
        }
        .totals-table .total-row td:last-child {
            color: #EE6D26;
        }
        .totals-table td:last-child {
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .status-pending { background: #FEF3C7; color: #92400E; }
        .status-processing { background: #DBEAFE; color: #1E40AF; }
        .status-shipped { background: #E9D5FF; color: #6B21A8; }
        .status-completed { background: #D1FAE5; color: #065F46; }
        .status-cancelled { background: #FEE2E2; color: #991B1B; }
        .notes-section {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .notes-title {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .notes-content {
            font-size: 11px;
            color: #666;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .footer-text {
            font-size: 11px;
            color: #999;
        }
        .thank-you {
            font-size: 14px;
            font-weight: bold;
            color: #EE6D26;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="company-name">{{ $company['name'] }}</div>
                <div class="company-info">
                    {{ $company['address'] }}<br>
                    {{ $company['phone'] }}<br>
                    {{ $company['email'] }}
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">{{ $order->order_number }}</div>
                <div style="margin-top: 10px;">
                    <span class="status-badge status-{{ $order->status }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-box">
                <div class="info-label">Tagihan Kepada</div>
                <div class="info-value">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}<br><br>
                    {{ $order->shipping_address }}
                </div>
            </div>
            <div class="info-box info-box-right" style="margin-left: 15px; text-align: right;">
                <div class="info-label">Detail Invoice</div>
                <div class="info-value">
                    <strong>Tanggal:</strong> {{ $order->created_at->format('d F Y') }}<br>
                    <strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method ?? 'Transfer') }}<br>
                    <strong>Status Pembayaran:</strong> {{ ucfirst($order->payment_status ?? 'Pending') }}
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Item</th>
                    <th style="width: 15%;">Harga</th>
                    <th style="width: 15%;">Qty</th>
                    <th style="width: 20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->book->title ?? 'Produk tidak tersedia' }}</strong>
                        @if($item->book && $item->book->author)
                        <br><span style="color: #666; font-size: 11px;">oleh {{ $item->book->author }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <div class="totals-left">
                @if($order->notes)
                <div class="notes-section">
                    <div class="notes-title">Catatan</div>
                    <div class="notes-content">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
            <div class="totals-right">
                <table class="totals-table">
                    <tr>
                        <td>Subtotal</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Ongkos Kirim</td>
                        <td>Rp 0</td>
                    </tr>
                    <tr class="total-row">
                        <td>Total</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Terima kasih atas pembelian Anda!</div>
            <div class="footer-text">
                Invoice ini dibuat secara otomatis.<br>
                Untuk pertanyaan, silakan hubungi {{ $company['email'] }}
            </div>
        </div>
    </div>
</body>
</html>
