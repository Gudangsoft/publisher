@extends('layouts.admin')

@section('title', 'Ulasan')

@section('content')
@php
    $star = 'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z';
    $tabs = [
        'pending' => ['Menunggu Moderasi', 'bg-blue-600'],
        'approved' => ['Disetujui', 'bg-green-600'],
        'spam' => ['Spam / Karantina', 'bg-red-600'],
        'all' => ['Semua', 'bg-gray-700'],
    ];
@endphp

<!-- Page Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Ulasan</h1>
        <p class="text-gray-600 mt-1">Moderasi ulasan masyarakat sebelum ditampilkan di situs.
            <a href="{{ route('reviews.index') }}" target="_blank" class="text-primary-600 hover:underline">Lihat halaman publik ↗</a>
        </p>
    </div>
    <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Ulasan
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
@endif

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm font-medium text-gray-600">Total Ulasan</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['all'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm font-medium text-gray-600">Rating Rata-rata</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['average'], 1) }} <span class="text-yellow-400 text-2xl">★</span></p>
        <p class="text-xs text-gray-500">dari ulasan disetujui</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm font-medium text-gray-600">Disetujui</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['approved'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm font-medium text-gray-600">Menunggu</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm font-medium text-gray-600">Spam Terblokir</p>
        <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['spam'] }}</p>
        <p class="text-xs text-gray-500">dihapus otomatis &gt; 30 hari</p>
    </div>
</div>

<!-- Tabs & Search -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
    <div class="flex flex-wrap gap-2">
        @foreach($tabs as $key => [$label, $activeColor])
        <a href="{{ route('admin.reviews.index', ['status' => $key]) }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold {{ $status === $key ? $activeColor . ' text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            {{ $label }} <span class="opacity-80">({{ $stats[$key] }})</span>
        </a>
        @endforeach
    </div>
    <form method="GET" class="flex gap-2">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama / isi…" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">Cari</button>
    </form>
</div>

@if($status === 'spam')
<div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg text-sm">
    Ulasan di sini dikarantina otomatis oleh filter (judi online, tautan, nomor kontak, trik penyamaran huruf, dll.) dan <strong>tidak pernah tampil</strong> ke publik.
    Jika ada ulasan asli yang salah terdeteksi, klik <em>Bukan Spam</em> lalu setujui.
</div>
@endif

<!-- List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="divide-y divide-gray-200">
        @forelse($reviews as $review)
        <div class="p-6 hover:bg-gray-50 transition-colors duration-200 {{ $review->is_spam ? 'bg-red-50/40' : '' }}">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                <div class="flex items-start space-x-4 min-w-0">
                    @if($review->reviewer_photo)
                    <img src="{{ asset('storage/' . $review->reviewer_photo) }}" alt="" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                    @else
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold flex-shrink-0">{{ $review->initial }}</div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mb-1">
                            <h3 class="font-semibold text-gray-900">{{ $review->reviewer_name }}</h3>
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 {{ $i < $review->rating ? 'fill-current' : 'fill-gray-300' }}" viewBox="0 0 20 20"><path d="{{ $star }}"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs mb-2">
                            @if($review->reviewer_role)
                            <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700">{{ $review->reviewer_role }}</span>
                            @endif
                            <span class="px-2 py-0.5 rounded {{ $review->source === 'public' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $review->source === 'public' ? 'Formulir publik' : 'Input admin' }}
                            </span>
                            @if($review->book)
                            <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700">Buku: {{ $review->book->title }}</span>
                            @endif
                            @if($review->reviewer_email)
                            <span class="text-gray-500">{{ $review->reviewer_email }}</span>
                            @endif
                            @if($review->is_featured)
                            <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 font-medium">★ Beranda</span>
                            @endif
                        </div>
                        <p class="text-gray-700 whitespace-pre-line break-words">{{ $review->review_text }}</p>

                        @if($review->spam_score > 0 || $review->is_spam)
                        <div class="mt-3 text-xs rounded-lg px-3 py-2 {{ $review->is_spam ? 'bg-red-100 text-red-800' : 'bg-amber-50 text-amber-800' }}">
                            <strong>Skor filter: {{ $review->spam_score }}</strong>
                            @if($review->spam_reasons) — {{ implode('; ', $review->spam_reasons) }} @endif
                        </div>
                        @endif

                        @if($review->moderated_at)
                        <p class="mt-2 text-xs text-gray-400">Dimoderasi {{ $review->moderated_at->format('d M Y H:i') }}@if($review->moderator) oleh {{ $review->moderator->name }}@endif</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 lg:justify-end lg:flex-shrink-0">
                    @php
                        $actions = [];
                        if ($review->is_spam) {
                            $actions[] = ['not_spam', 'Bukan Spam', 'bg-gray-700 hover:bg-gray-800'];
                        } else {
                            $actions[] = $review->is_approved
                                ? ['unapprove', 'Batalkan', 'bg-gray-500 hover:bg-gray-600']
                                : ['approve', 'Setujui', 'bg-green-600 hover:bg-green-700'];
                            $actions[] = $review->is_featured
                                ? ['unfeature', 'Lepas Beranda', 'bg-purple-400 hover:bg-purple-500']
                                : ['feature', 'Tampil di Beranda', 'bg-purple-600 hover:bg-purple-700'];
                            $actions[] = ['spam', 'Spam', 'bg-red-600 hover:bg-red-700'];
                        }
                    @endphp
                    @foreach($actions as [$action, $label, $color])
                    <form action="{{ route('admin.reviews.moderate', $review) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="{{ $action }}">
                        <button type="submit" class="px-3 py-1.5 {{ $color }} text-white text-xs font-medium rounded-full transition-colors">{{ $label }}</button>
                    </form>
                    @endforeach

                    <a href="{{ route('admin.reviews.edit', $review) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada ulasan pada tab ini</h3>
            <p class="mt-1 text-sm text-gray-500">Ulasan dari formulir publik akan muncul di tab <em>Menunggu Moderasi</em>.</p>
        </div>
        @endforelse
    </div>

    @if($reviews->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">{{ $reviews->links() }}</div>
    @endif
</div>
@endsection
