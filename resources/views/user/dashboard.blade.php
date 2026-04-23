@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Submissions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Submisi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_submissions'] }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Submissions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menunggu Review</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_submissions'] }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Approved Submissions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Submisi Disetujui</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['approved_submissions'] }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_orders'] }}</p>
                    </div>
                    <div class="bg-primary-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('submissions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white rounded-xl p-6 flex items-center transition-colors">
                <div class="bg-white/20 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Ajukan Naskah Baru</p>
                    <p class="text-sm opacity-80">Kirim naskah untuk diterbitkan</p>
                </div>
            </a>
            <a href="{{ route('user.submissions') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-6 flex items-center transition-colors">
                <div class="bg-white/20 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Lihat Semua Submisi</p>
                    <p class="text-sm opacity-80">Pantau status pengajuan Anda</p>
                </div>
            </a>
            <a href="{{ route('user.orders') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-6 flex items-center transition-colors">
                <div class="bg-white/20 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Riwayat Pesanan</p>
                    <p class="text-sm opacity-80">Lihat semua pesanan Anda</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Submissions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Submisi Terbaru</h2>
                    <a href="{{ route('user.submissions') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($submissions as $submission)
                    <a href="{{ route('user.submissions.show', $submission->id) }}" class="block p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $submission->title }}</p>
                                <p class="text-sm text-gray-500">{{ $submission->submission_number }}</p>
                            </div>
                            @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'in_review' => 'bg-blue-100 text-blue-800',
                                'revision_required' => 'bg-orange-100 text-orange-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'in_production' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-gray-100 text-gray-800',
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
                            @endphp
                            <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$submission->status] ?? ucfirst($submission->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400">{{ $submission->created_at->format('d M Y, H:i') }}</p>
                    </a>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>Belum ada submisi</p>
                        <a href="{{ route('submissions.create') }}" class="text-primary-600 hover:underline text-sm">Ajukan naskah pertama Anda</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
                    <a href="{{ route('user.orders') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <a href="{{ route('user.orders.show', $order->id) }}" class="block p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->items->count() }} item(s)</p>
                            </div>
                            <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_color['bg'] }} {{ $order->status_color['text'] }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            <p class="font-semibold text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p>Belum ada pesanan</p>
                        <a href="{{ route('books.index') }}" class="text-primary-600 hover:underline text-sm">Lihat katalog buku kami</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
