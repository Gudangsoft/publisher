@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600 mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Books -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Buku</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_books']) }}</p>
                <p class="text-sm {{ $stats['books_change']['positive'] ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($stats['books_change']['positive'])
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        @endif
                    </svg>
                    <span>{{ $stats['books_change']['value'] }}% dari bulan lalu</span>
                </p>
            </div>
            <div class="bg-primary-100 p-4 rounded-xl">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                <p class="text-sm {{ $stats['orders_change']['positive'] ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($stats['orders_change']['positive'])
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        @endif
                    </svg>
                    <span>{{ $stats['orders_change']['value'] }}% dari bulan lalu</span>
                </p>
            </div>
            <div class="bg-blue-100 p-4 rounded-xl">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Pendapatan</p>
                <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'] / 1000000, 1, ',', '.') }}M</p>
                <p class="text-sm {{ $stats['revenue_change']['positive'] ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($stats['revenue_change']['positive'])
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        @endif
                    </svg>
                    <span>{{ $stats['revenue_change']['value'] }}% dari bulan lalu</span>
                </p>
            </div>
            <div class="bg-green-100 p-4 rounded-xl">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                <p class="text-sm {{ $stats['users_change']['positive'] ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($stats['users_change']['positive'])
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        @endif
                    </svg>
                    <span>{{ $stats['users_change']['value'] }}% dari bulan lalu</span>
                </p>
            </div>
            <div class="bg-purple-100 p-4 rounded-xl">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-center">
        <div class="bg-yellow-100 p-3 rounded-lg mr-4">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-yellow-800">Pesanan Pending</p>
            <p class="text-2xl font-bold text-yellow-900">{{ $stats['pending_orders'] }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}?status=pending" class="ml-auto text-yellow-700 hover:text-yellow-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center">
        <div class="bg-blue-100 p-3 rounded-lg mr-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-blue-800">Submisi Menunggu</p>
            <p class="text-2xl font-bold text-blue-900">{{ $stats['pending_submissions'] }}</p>
        </div>
        <a href="{{ route('admin.submissions.index') }}?status=pending" class="ml-auto text-blue-700 hover:text-blue-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center">
        <div class="bg-green-100 p-3 rounded-lg mr-4">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-green-800">Submisi Disetujui</p>
            <p class="text-2xl font-bold text-green-900">{{ $submissionStats['approved'] ?? 0 }}</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Penjualan Bulanan</h2>
                <p class="text-sm text-gray-500 mt-1">Performa penjualan 12 bulan terakhir</p>
            </div>
        </div>
        <div class="relative" style="height: 300px;">
            <canvas id="salesChart"></canvas>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-6 pt-4 border-t border-gray-200">
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Total Penjualan</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ $monthlySales['total'] }}M</p>
            </div>
            <div class="text-center border-l border-gray-200">
                <p class="text-xs text-gray-500 mb-1">Rata-rata/Bulan</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ $monthlySales['average'] }}M</p>
            </div>
            <div class="text-center border-l border-gray-200">
                <p class="text-xs text-gray-500 mb-1">Pertumbuhan</p>
                <p class="text-lg font-bold {{ $stats['revenue_change']['positive'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ $stats['revenue_change']['positive'] ? '+' : '-' }}{{ $stats['revenue_change']['value'] }}%
                </p>
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Distribusi Kategori</h2>
            <p class="text-sm text-gray-500 mt-1">Berdasarkan jumlah buku</p>
        </div>
        <div class="flex items-center justify-center" style="height: 300px;">
            <canvas id="categoryChart"></canvas>
        </div>
        @if(count($categoryDistribution) > 0)
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-3">
                @foreach($categoryDistribution as $category)
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category['color'] }}"></div>
                    <span class="text-sm text-gray-600">{{ $category['name'] }}</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">{{ $category['percentage'] }}%</span>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="mt-6 pt-4 border-t border-gray-200 text-center text-gray-500">
            Belum ada data kategori
        </div>
        @endif
    </div>
</div>

<!-- Recent Orders & Top Books -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentOrders as $order)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">
                            #{{ substr($order->order_number, -4) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order->customer_name ?? ($order->user->name ?? 'Guest') }}</p>
                            <p class="text-sm text-gray-500">{{ $order->items->count() }} item(s)</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_color['bg'] }} {{ $order->status_color['text'] }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Belum ada pesanan
            </div>
            @endforelse
        </div>
    </div>

    <!-- Top Selling Books -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Buku Terlaris</h2>
                <a href="{{ route('admin.books.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($topBooks as $book)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-16 bg-gray-200 rounded overflow-hidden mr-4">
                        @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $book->title }}</p>
                        <p class="text-sm text-gray-500">{{ $book->author ?? '-' }}</p>
                    </div>
                    <div class="text-right ml-4">
                        <p class="font-bold text-primary-600">{{ $book->total_sold ?? 0 }}</p>
                        <p class="text-xs text-gray-500">terjual</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Belum ada buku
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Aktivitas Terbaru</h2>
    </div>
    <div class="p-6">
        <div class="flow-root">
            <ul class="-mb-8">
                @forelse($recentActivities as $index => $activity)
                <li>
                    <div class="relative pb-8">
                        @if($index < count($recentActivities) - 1)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif
                        <div class="relative flex space-x-3">
                            <div>
                                @php
                                $iconColors = [
                                    'primary' => 'bg-orange-100 text-orange-600',
                                    'green' => 'bg-green-100 text-green-600',
                                    'blue' => 'bg-blue-100 text-blue-600',
                                    'yellow' => 'bg-yellow-100 text-yellow-600',
                                    'purple' => 'bg-purple-100 text-purple-600',
                                ];
                                $colorClass = $iconColors[$activity['color']] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="h-8 w-8 rounded-full {{ $colorClass }} flex items-center justify-center ring-8 ring-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($activity['icon'] == 'book')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        @elseif($activity['icon'] == 'shopping')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        @elseif($activity['icon'] == 'document')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        @elseif($activity['icon'] == 'user')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        @endif
                                    </svg>
                                </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                <div>
                                    <p class="text-sm text-gray-900">{{ $activity['text'] }}</p>
                                </div>
                                <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                    <time>{{ $activity['time_formatted'] }}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @empty
                <li class="text-center text-gray-500 py-4">
                    Belum ada aktivitas
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart with dynamic data
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlySales['labels']) !!},
            datasets: [{
                label: 'Penjualan',
                data: {!! json_encode($monthlySales['data']) !!},
                borderColor: 'rgb(238, 109, 38)',
                backgroundColor: 'rgba(238, 109, 38, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: 'rgb(238, 109, 38)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverBackgroundColor: 'rgb(238, 109, 38)',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Penjualan: Rp ' + context.parsed.y + 'M';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return 'Rp ' + value + 'M';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Category Chart with dynamic data
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    @php
    $categoryNames = array_column($categoryDistribution, 'name');
    $categoryPercentages = array_column($categoryDistribution, 'percentage');
    $categoryColors = array_column($categoryDistribution, 'color');
    @endphp
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryNames) !!},
            datasets: [{
                data: {!! json_encode($categoryPercentages) !!},
                backgroundColor: {!! json_encode($categoryColors) !!},
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
