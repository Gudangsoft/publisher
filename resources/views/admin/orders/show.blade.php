@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . substr($order->order_number, -4))

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan #{{ substr($order->order_number, -4) }}</h1>
            <p class="text-gray-600 mt-1">Order Number: {{ $order->order_number }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Update Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="grid grid-cols-2 gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refund</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        Update Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Item Pesanan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Buku</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-12 h-16 object-cover rounded mr-3">
                                    @else
                                    <div class="w-12 h-16 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->book->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->book->author }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-medium text-gray-900">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900">Total:</td>
                            <td class="px-6 py-4 text-right font-bold text-primary-600 text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($order->notes)
        <!-- Notes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Catatan</h2>
            <p class="text-gray-600">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Customer Info Sidebar -->
    <div class="space-y-6">
        <!-- Customer -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h2>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Nama</label>
                    <p class="text-gray-900 font-medium">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Email</label>
                    <p class="text-gray-900">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Telepon</label>
                    <p class="text-gray-900">{{ $order->customer_phone }}</p>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
            <p class="text-gray-900">{{ $order->shipping_address }}</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h2>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $order->status_color['bg'] }} {{ $order->status_color['text'] }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Metode Pembayaran</label>
                    <p class="text-gray-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Status Pembayaran</label>
                    <p class="text-gray-900 capitalize">
                        @if($order->payment_status == 'paid')
                            <span class="text-green-600 font-medium">Sudah Dibayar</span>
                        @elseif($order->payment_status == 'unpaid')
                            <span class="text-yellow-600 font-medium">Belum Dibayar</span>
                        @else
                            <span class="text-red-600 font-medium">Refund</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Tanggal Pesanan</label>
                    <p class="text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
