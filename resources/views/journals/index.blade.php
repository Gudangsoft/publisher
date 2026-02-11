@extends('layouts.app')

@section('title', 'Jurnal Ilmiah')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Jurnal Ilmiah</h1>
        <p class="text-xl opacity-90">Publikasi ilmiah dan penelitian terkini</p>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white shadow-sm border-b">
    <div class="container mx-auto px-4 py-6">
        <form method="GET" action="{{ route('journals.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari jurnal berdasarkan judul, abstrak, penulis, atau kata kunci..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-primary-600 text-white px-8 py-2 rounded-lg hover:bg-primary-700 transition duration-300 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
        </form>
    </div>
</div>

<!-- Journals Grid -->
<div class="container mx-auto px-4 py-12">
    @if($journals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($journals as $journal)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                    <!-- Cover Image -->
                    @if($journal->cover_image)
                        <div class="h-64 bg-gray-200 overflow-hidden">
                            <img src="{{ Storage::url($journal->cover_image) }}" 
                                 alt="{{ $journal->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-64 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-primary-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="p-6">
                        <!-- Category Badge -->
                        @if($journal->category)
                            <span class="inline-block bg-primary-100 text-primary-800 text-xs px-3 py-1 rounded-full font-semibold mb-3">
                                {{ $journal->category->name }}
                            </span>
                        @endif

                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                            {{ $journal->title }}
                        </h3>

                        <!-- Authors -->
                        <p class="text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ Str::limit($journal->authors, 50) }}
                        </p>

                        <!-- Abstract -->
                        <p class="text-gray-700 mb-4 line-clamp-3">
                            {{ Str::limit($journal->abstract, 150) }}
                        </p>

                        <!-- Metadata -->
                        <div class="border-t pt-4 mt-4">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                                @if($journal->volume || $journal->issue)
                                    <span>
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        Vol. {{ $journal->volume ?? '-' }}, No. {{ $journal->issue ?? '-' }}
                                    </span>
                                @endif
                                @if($journal->year)
                                    <span>{{ $journal->year }}</span>
                                @endif
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-4">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ number_format($journal->views) }} views
                                </span>
                                <span>
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    {{ number_format($journal->downloads) }} downloads
                                </span>
                            </div>
                        </div>

                        <!-- Read More Button -->
                        <a href="{{ route('journals.show', $journal->slug) }}" 
                           class="inline-block w-full mt-4 bg-primary-600 text-white text-center px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-300 font-semibold">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $journals->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">Belum ada jurnal</h3>
            <p class="text-gray-500">Jurnal ilmiah akan segera hadir.</p>
        </div>
    @endif
</div>
@endsection
