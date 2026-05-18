@extends('layouts.user')
@section('title', 'Dashboard Saya')

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Saya</h1>
    <p class="text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Total Submisi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Submisi</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_submissions'] }}</p>
            </div>
            <div class="bg-blue-100 p-3.5 rounded-xl">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Menunggu Review -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Menunggu Review</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_submissions'] }}</p>
            </div>
            <div class="bg-yellow-100 p-3.5 rounded-xl">
                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Disetujui -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Submisi Disetujui</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['approved_submissions'] }}</p>
            </div>
            <div class="bg-green-100 p-3.5 rounded-xl">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Pesanan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                @if($stats['total_spent'] > 0)
                <p class="text-xs text-gray-400 mt-1">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                @endif
            </div>
            <div class="bg-primary-100 p-3.5 rounded-xl">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <a href="{{ route('submissions.create') }}"
       class="flex items-center gap-4 p-5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-sm transition-colors">
        <div class="bg-white/20 p-3 rounded-lg shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold">Ajukan Naskah Baru</p>
            <p class="text-sm opacity-80">Kirim naskah untuk diterbitkan</p>
        </div>
    </a>
    <a href="{{ route('user.submissions') }}"
       class="flex items-center gap-4 p-5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-sm transition-colors">
        <div class="bg-white/20 p-3 rounded-lg shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold">Lihat Submisi Saya</p>
            <p class="text-sm opacity-80">Pantau status pengajuan Anda</p>
        </div>
    </a>
    <a href="{{ route('user.orders') }}"
       class="flex items-center gap-4 p-5 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-sm transition-colors">
        <div class="bg-white/20 p-3 rounded-lg shrink-0">
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

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Submissions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">Submisi Terbaru</h2>
            <a href="{{ route('user.submissions') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($submissions as $submission)
            @php
            $statusColors = [
                'pending'           => 'bg-yellow-100 text-yellow-800',
                'reviewing'         => 'bg-blue-100 text-blue-800',
                'in_review'         => 'bg-blue-100 text-blue-800',
                'revision_required' => 'bg-orange-100 text-orange-800',
                'approved'          => 'bg-green-100 text-green-800',
                'rejected'          => 'bg-red-100 text-red-800',
                'in_production'     => 'bg-purple-100 text-purple-800',
                'completed'         => 'bg-gray-100 text-gray-700',
            ];
            $statusLabels = [
                'pending'           => 'Menunggu',
                'reviewing'         => 'Direview',
                'in_review'         => 'Direview',
                'revision_required' => 'Perlu Revisi',
                'approved'          => 'Disetujui',
                'rejected'          => 'Ditolak',
                'in_production'     => 'Produksi',
                'completed'         => 'Selesai',
            ];
            @endphp
            <a href="{{ route('user.submissions.show', $submission->id) }}"
               class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 truncate text-sm">{{ $submission->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $submission->created_at->format('d M Y') }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium shrink-0 {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $statusLabels[$submission->status] ?? ucfirst($submission->status) }}
                </span>
            </a>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mb-2">Belum ada submisi</p>
                <a href="{{ route('submissions.create') }}" class="text-sm text-primary-600 hover:underline font-medium">Ajukan naskah pertama Anda</a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">Pesanan Terbaru</h2>
            <a href="{{ route('user.orders') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($orders as $order)
            <a href="{{ route('user.orders.show', $order->id) }}"
               class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y') }} · {{ $order->items->count() }} item</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-bold text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $order->status_color['bg'] }} {{ $order->status_color['text'] }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </a>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mb-2">Belum ada pesanan</p>
                <a href="{{ route('books.index') }}" class="text-sm text-primary-600 hover:underline font-medium">Lihat katalog buku kami</a>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
