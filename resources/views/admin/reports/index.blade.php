@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Laporan Penjualan</h1>
        <p class="text-gray-600 mt-1">Analisis dan laporan kinerja penjualan tahun {{ $year }}</p>
    </div>
    <div class="flex items-center space-x-3">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" onchange="this.form.submit()">
                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-primary-100 p-3 rounded-lg">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-600 mb-1">Total Pendapatan</p>
        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-2">Tahun {{ $year }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-blue-100 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-600 mb-1">Total Pesanan</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $totalCustomers }} pelanggan</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-green-100 p-3 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-600 mb-1">Buku Terjual</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalBooks) }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ \App\Models\Book::count() }} judul buku</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-purple-100 p-3 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-600 mb-1">Rata-rata per Pesanan</p>
        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($avgPerOrder, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $totalOrders > 0 ? number_format($totalBooks / $totalOrders, 1) : 0 }} buku/pesanan</p>
    </div>
</div>

<!-- Sales Chart -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Grafik Penjualan Bulanan</h2>
        <div class="flex items-center space-x-2">
            <button class="px-4 py-2 text-sm bg-primary-100 text-primary-700 rounded-lg font-medium">Pendapatan</button>
            <button class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg font-medium">Pesanan</button>
            <button class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg font-medium">Buku</button>
        </div>
    </div>
    <canvas id="revenueChart" height="80"></canvas>
</div>

<!-- Monthly Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Detail Penjualan per Bulan</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bulan</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Pendapatan</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Pesanan</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Buku Terjual</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Rata-rata</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Trend</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($salesData as $index => $data)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-900">{{ $data['month'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-lg font-bold text-gray-900">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-gray-900 font-medium">{{ number_format($data['orders']) }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-gray-900 font-medium">{{ number_format($data['books_sold']) }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-gray-900 font-medium">
                            @if($data['orders'] > 0)
                                Rp {{ number_format($data['revenue'] / $data['orders'], 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($index > 0 && $salesData[$index - 1]['orders'] > 0)
                            @php
                            $prevRevenue = $salesData[$index - 1]['revenue'];
                            $change = $prevRevenue > 0 ? (($data['revenue'] - $prevRevenue) / $prevRevenue) * 100 : 0;
                            @endphp
                            @if($change >= 0)
                            <span class="inline-flex items-center text-green-600 text-sm font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                {{ number_format($change, 1) }}%
                            </span>
                            @else
                            <span class="inline-flex items-center text-red-600 text-sm font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                                {{ number_format(abs($change), 1) }}%
                            </span>
                            @endif
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                <tr>
                    <td class="px-6 py-4 font-bold text-gray-900">TOTAL</td>
                    <td class="px-6 py-4 text-right font-bold text-primary-600 text-lg">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">{{ number_format($totalOrders) }}</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">{{ number_format($totalBooks) }}</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($avgPerOrder, 0, ',', '.') }}</td>
                    <td class="px-6 py-4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Top Selling Books -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Buku Terlaris</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Terjual</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($topBooks as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($item->book && $item->book->cover_image)
                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-10 h-14 object-cover rounded mr-3">
                            @else
                            <div class="w-10 h-14 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item->book ? $item->book->title : 'Unknown' }}</p>
                                <p class="text-sm text-gray-500">{{ $item->book ? $item->book->author : '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-lg font-bold text-gray-900">{{ number_format($item->total_sold) }} pcs</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-lg font-bold text-primary-600">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($salesData, 'month')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode(array_column($salesData, 'revenue')) !!},
                borderColor: 'rgb(238, 109, 38)',
                backgroundColor: 'rgba(238, 109, 38, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + 'M';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
