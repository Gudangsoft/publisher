@extends('layouts.app')

@section('title', 'Pesanan ' . $order->order_number . ' - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-primary-600">Dashboard</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('user.orders') }}" class="text-gray-500 hover:text-primary-600">Pesanan</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium">{{ $order->order_number }}</li>
            </ol>
        </nav>

        <!-- Order Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h1>
                        <p class="text-gray-500 mt-1">Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <span class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $order->status_color['bg'] }} {{ $order->status_color['text'] }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            <!-- Order Progress -->
            @if($order->status != 'cancelled')
            <div class="p-6 bg-gray-50">
                @php
                $steps = [
                    'pending' => ['label' => 'Pending', 'order' => 1],
                    'processing' => ['label' => 'Diproses', 'order' => 2],
                    'shipped' => ['label' => 'Dikirim', 'order' => 3],
                    'completed' => ['label' => 'Selesai', 'order' => 4],
                ];
                $currentOrder = $steps[$order->status]['order'] ?? 0;
                @endphp
                <div class="flex items-center justify-between">
                    @foreach($steps as $key => $step)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentOrder >= $step['order'] ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if($currentOrder > $step['order'])
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            @else
                            {{ $step['order'] }}
                            @endif
                        </div>
                        <span class="text-xs mt-2 {{ $currentOrder >= $step['order'] ? 'text-primary-600 font-medium' : 'text-gray-500' }}">{{ $step['label'] }}</span>
                    </div>
                    @if(!$loop->last)
                    <div class="flex-1 h-0.5 {{ $currentOrder > $step['order'] ? 'bg-primary-600' : 'bg-gray-200' }} mx-2"></div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Item Pesanan</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-16 h-20 bg-gray-100 rounded overflow-hidden mr-4">
                                    @if($item->book && $item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900">{{ $item->book->title ?? 'Buku tidak tersedia' }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Jumlah: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-500">Harga satuan: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="ml-4 text-right">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Order Summary -->
                    <div class="p-6 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span>Total</span>
                            <span class="text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Info -->
            <div class="space-y-6">
                <!-- Shipping Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Pengiriman</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500">Nama</p>
                            <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="font-medium text-gray-900">{{ $order->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Telepon</p>
                            <p class="font-medium text-gray-900">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Alamat</p>
                            <p class="font-medium text-gray-900">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Pembayaran</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($order->payment_method ?? 'Transfer') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>
                            @php
                            $paymentColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'failed' => 'bg-red-100 text-red-800',
                            ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($order->payment_status ?? 'Pending') }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                <!-- Notes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Catatan</h2>
                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                </div>
                @endif

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ route('user.orders.invoice', $order->id) }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Invoice
                    </a>
                    <a href="{{ route('user.orders.invoice.view', $order->id) }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Invoice
                    </a>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('user.orders') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
