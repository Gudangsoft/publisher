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
                <p class="text-3xl font-bold text-gray-900">1,284</p>
                <p class="text-sm text-green-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span>12% dari bulan lalu</span>
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
                <p class="text-3xl font-bold text-gray-900">856</p>
                <p class="text-sm text-green-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span>8% dari bulan lalu</span>
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
                <p class="text-3xl font-bold text-gray-900">Rp 127,5M</p>
                <p class="text-sm text-green-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span>23% dari bulan lalu</span>
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
                <p class="text-sm font-medium text-gray-600 mb-1">Pengguna Aktif</p>
                <p class="text-3xl font-bold text-gray-900">2,543</p>
                <p class="text-sm text-red-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                    <span>3% dari bulan lalu</span>
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

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Penjualan Bulanan</h2>
                <p class="text-sm text-gray-500 mt-1">Performa penjualan tahun ini</p>
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                <option>2024</option>
                <option>2023</option>
            </select>
        </div>
        <div class="relative" style="height: 300px;">
            <canvas id="salesChart"></canvas>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-6 pt-4 border-t border-gray-200">
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Total Penjualan</p>
                <p class="text-lg font-bold text-gray-900">Rp 1.1M</p>
            </div>
            <div class="text-center border-l border-gray-200">
                <p class="text-xs text-gray-500 mb-1">Rata-rata</p>
                <p class="text-lg font-bold text-gray-900">Rp 92K</p>
            </div>
            <div class="text-center border-l border-gray-200">
                <p class="text-xs text-gray-500 mb-1">Pertumbuhan</p>
                <p class="text-lg font-bold text-green-600">+23%</p>
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
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-primary-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Fiksi</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">30%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Non-Fiksi</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">25%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Pendidikan</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">20%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Anak-anak</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">12%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-purple-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Teknologi</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">8%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-gray-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Lainnya</span>
                    <span class="ml-auto text-sm font-semibold text-gray-900">5%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Top Books -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @for($i = 1; $i <= 5; $i++)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">
                            #{{ 1000 + $i }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Customer {{ $i }}</p>
                            <p class="text-sm text-gray-500">{{ rand(1, 5) }} items</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">Rp {{ number_format(rand(100, 500) * 1000, 0, ',', '.') }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $i % 3 == 0 ? 'bg-green-100 text-green-800' : ($i % 2 == 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ $i % 3 == 0 ? 'Selesai' : ($i % 2 == 0 ? 'Proses' : 'Baru') }}
                        </span>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Top Selling Books -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Buku Terlaris</h2>
                <a href="/admin/books" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @for($i = 1; $i <= 5; $i++)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-16 bg-gray-200 rounded overflow-hidden mr-4">
                        <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=200&h=300&fit=crop" alt="Book" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 truncate">Buku Terlaris {{ $i }}</p>
                        <p class="text-sm text-gray-500">Penulis {{ $i }}</p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400 mr-2">
                                @for($j = 0; $j < 5; $j++)
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">({{ rand(100, 500) }} ulasan)</span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="font-bold text-primary-600">{{ rand(100, 500) }}</p>
                        <p class="text-xs text-gray-500">terjual</p>
                    </div>
                </div>
            </div>
            @endfor
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
                @php
                $activities = [
                    ['icon' => 'book', 'text' => 'Buku baru "Judul Buku Menarik" ditambahkan', 'time' => '5 menit yang lalu', 'color' => 'primary'],
                    ['icon' => 'shopping', 'text' => 'Pesanan #1025 telah dikonfirmasi', 'time' => '15 menit yang lalu', 'color' => 'green'],
                    ['icon' => 'star', 'text' => 'Review baru diterima untuk "Buku Populer"', 'time' => '1 jam yang lalu', 'color' => 'yellow'],
                    ['icon' => 'user', 'text' => 'Pengguna baru mendaftar: user@example.com', 'time' => '2 jam yang lalu', 'color' => 'blue'],
                    ['icon' => 'news', 'text' => 'Berita "Event Peluncuran Buku" dipublikasikan', 'time' => '3 jam yang lalu', 'color' => 'purple'],
                ];
                @endphp

                @foreach($activities as $index => $activity)
                <li>
                    <div class="relative pb-8">
                        @if($index < count($activities) - 1)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif
                        <div class="relative flex space-x-3">
                            <div>
                                <span class="h-8 w-8 rounded-full bg-{{ $activity['color'] }}-100 flex items-center justify-center ring-8 ring-white">
                                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($activity['icon'] == 'book')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        @elseif($activity['icon'] == 'shopping')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        @elseif($activity['icon'] == 'star')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
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
                                    <time>{{ $activity['time'] }}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Penjualan',
                data: [45, 52, 48, 65, 72, 68, 85, 92, 88, 95, 102, 110],
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

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Fiksi', 'Non-Fiksi', 'Pendidikan', 'Anak-anak', 'Teknologi', 'Lainnya'],
            datasets: [{
                data: [30, 25, 20, 12, 8, 5],
                backgroundColor: [
                    'rgb(238, 109, 38)',
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(251, 191, 36)',
                    'rgb(139, 92, 246)',
                    'rgb(107, 114, 128)'
                ],
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
