@extends('layouts.app')

@section('title', 'Koleksi Skripsi - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<section class="relative py-16 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-display">
                Koleksi Skripsi
            </h1>
            <p class="text-xl text-primary-100">
                Kumpulan skripsi taruna yang sudah dipublikasikan.
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">

            <form method="GET" action="{{ route('repository.collection') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 flex flex-wrap items-center gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau nama..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 flex-1 min-w-[200px]">
                <select name="korps" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Korps</option>
                    @foreach($korpsOptions as $k)
                    <option value="{{ $k }}" @selected(request('korps') === $k)>{{ $k }}</option>
                    @endforeach
                </select>
                <select name="angkatan" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatanOptions as $a)
                    <option value="{{ $a }}" @selected(request('angkatan') === $a)>{{ $a }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Cari</button>
                @if(request()->anyFilled(['search', 'korps', 'angkatan']))
                <a href="{{ route('repository.collection') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm">Reset</a>
                @endif
            </form>

            @if($submissions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($submissions as $s)
                <a href="{{ route('repository.collection.show', $s->submission_code) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $s->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $s->taruna->name }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span class="px-2 py-1 bg-primary-50 text-primary-700 rounded-full font-medium">{{ $s->taruna->korps }} &middot; Angkatan {{ $s->taruna->angkatan }}</span>
                        <span>{{ $s->published_at?->format('d M Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $submissions->links() }}
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <p class="text-gray-500">Belum ada skripsi yang dipublikasikan{{ request()->anyFilled(['search', 'korps', 'angkatan']) ? ' untuk filter ini' : '' }}.</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
