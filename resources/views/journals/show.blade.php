@extends('layouts.app')

@section('title', $journal->title)

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="container mx-auto px-4">
        <nav class="text-sm mb-4 opacity-90">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('journals.index') }}" class="hover:underline">Jurnal</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold">{{ $journal->title }}</h1>
    </div>
</div>

<!-- Journal Content -->
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Cover Image -->
                @if($journal->cover_image)
                    <div class="mb-8">
                        <img src="{{ Storage::url($journal->cover_image) }}" 
                             alt="{{ $journal->title }}" 
                             class="w-full max-w-md mx-auto rounded-lg shadow-md">
                    </div>
                @endif

                <!-- Abstract -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Abstrak</h2>
                    <p class="text-gray-700 leading-relaxed text-justify">{{ $journal->abstract }}</p>
                </div>

                <!-- Keywords -->
                @if($journal->keywords)
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Kata Kunci</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $journal->keywords) as $keyword)
                                <span class="inline-block bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm">
                                    {{ trim($keyword) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Citation -->
                @if($journal->citation_format)
                    <div class="bg-gray-50 border-l-4 border-primary-600 p-6 rounded mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Cara Mengutip</h3>
                        <p class="text-gray-700 italic">{{ $journal->citation_format }}</p>
                        <button onclick="copyCitation()" class="mt-3 text-primary-600 hover:text-primary-800 text-sm font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Salin Sitasi
                        </button>
                    </div>
                @endif

                <!-- Download Section -->
                @if($journal->file_pdf)
                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-6 mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">File Jurnal (PDF)</h3>
                                <p class="text-sm text-gray-600">Download full paper dalam format PDF</p>
                            </div>
                            <a href="{{ Storage::url($journal->file_pdf) }}" 
                               target="_blank"
                               onclick="incrementDownload()"
                               class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-300 font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Share Buttons -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Bagikan Jurnal</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('journals.show', $journal->slug)) }}" 
                           target="_blank"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('journals.show', $journal->slug)) }}&text={{ urlencode($journal->title) }}" 
                           target="_blank"
                           class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            Twitter / X
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($journal->title . ' - ' . route('journals.show', $journal->slug)) }}" 
                           target="_blank"
                           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            WhatsApp
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('journals.show', $journal->slug)) }}&title={{ urlencode($journal->title) }}" 
                           target="_blank"
                           class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Journal Info Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-4">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Jurnal</h3>
                
                <!-- Category -->
                @if($journal->category)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Kategori</p>
                        <span class="inline-block bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $journal->category->name }}
                        </span>
                    </div>
                @endif

                <!-- Authors -->
                <div class="mb-4 pb-4 border-b">
                    <p class="text-sm text-gray-600 mb-2">Penulis</p>
                    <p class="text-gray-900 font-semibold">{{ $journal->authors }}</p>
                </div>

                <!-- Affiliation -->
                @if($journal->affiliation)
                    <div class="mb-4 pb-4 border-b">
                        <p class="text-sm text-gray-600 mb-2">Afiliasi</p>
                        <p class="text-gray-900">{{ $journal->affiliation }}</p>
                    </div>
                @endif

                <!-- Publication Details -->
                <div class="mb-4 pb-4 border-b">
                    <p class="text-sm text-gray-600 mb-3">Detail Publikasi</p>
                    @if($journal->volume || $journal->issue)
                        <p class="text-sm text-gray-700 mb-2">
                            <span class="font-semibold">Volume:</span> {{ $journal->volume ?? '-' }}, 
                            <span class="font-semibold">Issue:</span> {{ $journal->issue ?? '-' }}
                        </p>
                    @endif
                    @if($journal->pages)
                        <p class="text-sm text-gray-700 mb-2">
                            <span class="font-semibold">Halaman:</span> {{ $journal->pages }}
                        </p>
                    @endif
                    @if($journal->year)
                        <p class="text-sm text-gray-700 mb-2">
                            <span class="font-semibold">Tahun:</span> {{ $journal->year }}
                        </p>
                    @endif
                    @if($journal->publication_date)
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Tanggal:</span> {{ $journal->publication_date->format('d M Y') }}
                        </p>
                    @endif
                </div>

                <!-- DOI -->
                @if($journal->doi)
                    <div class="mb-4 pb-4 border-b">
                        <p class="text-sm text-gray-600 mb-2">DOI</p>
                        <a href="https://doi.org/{{ $journal->doi }}" target="_blank" class="text-primary-600 hover:text-primary-800 text-sm break-all">
                            {{ $journal->doi }}
                        </a>
                    </div>
                @endif

                <!-- ISSN -->
                @if($journal->issn)
                    <div class="mb-4 pb-4 border-b">
                        <p class="text-sm text-gray-600 mb-2">ISSN</p>
                        <p class="text-gray-900 font-mono text-sm">{{ $journal->issn }}</p>
                    </div>
                @endif

                <!-- External Journal Link -->
                @if($journal->journal_link)
                    <div class="mb-4 pb-4 border-b">
                        <a href="{{ $journal->journal_link }}" target="_blank" 
                           class="flex items-center justify-between p-3 bg-gradient-to-r from-primary-50 to-primary-100 hover:from-primary-100 hover:to-primary-200 rounded-lg transition-all duration-300 group">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <span class="text-sm font-semibold text-primary-800">Lihat Jurnal Online</span>
                            </div>
                            <svg class="w-4 h-4 text-primary-600 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endif

                <!-- Language -->
                <div class="mb-4 pb-4 border-b">
                    <p class="text-sm text-gray-600 mb-2">Bahasa</p>
                    <p class="text-gray-900">
                        @if($journal->language == 'id')
                            Indonesia
                        @elseif($journal->language == 'en')
                            English
                        @elseif($journal->language == 'ar')
                            العربية (Arabic)
                        @else
                            {{ $journal->language }}
                        @endif
                    </p>
                </div>

                <!-- Stats -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span class="text-sm">Views</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ number_format($journal->views) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span class="text-sm">Downloads</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ number_format($journal->downloads) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyCitation() {
    const citation = @json($journal->citation_format);
    navigator.clipboard.writeText(citation).then(() => {
        alert('Sitasi berhasil disalin ke clipboard!');
    }).catch(err => {
        console.error('Failed to copy citation:', err);
    });
}

function incrementDownload() {
    fetch('{{ route("journals.show", $journal->slug) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ action: 'download' })
    });
}
</script>
@endpush
@endsection
