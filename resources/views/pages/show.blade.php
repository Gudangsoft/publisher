@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? $page->excerpt)

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-primary-50 via-white to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
                {{ $page->title }}
            </h1>
            @if($page->excerpt)
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $page->excerpt }}
            </p>
            @endif
            @if($page->published_at)
            <div class="flex items-center justify-center mt-4 text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Dipublikasi: {{ $page->published_at->format('d F Y') }}
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Page Content -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($page->featured_image)
        <div class="mb-12 rounded-2xl overflow-hidden shadow-xl">
            <img src="{{ asset('storage/' . $page->featured_image) }}" 
                 alt="{{ $page->title }}" 
                 class="w-full h-auto">
        </div>
        @endif

        <article class="prose prose-lg max-w-none">
            <div class="text-gray-700 leading-relaxed space-y-6">
                {!! nl2br(e($page->content)) !!}
            </div>
        </article>

        <!-- Share Section -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 font-medium">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('pages.show', $page->slug)) }}" 
                       target="_blank" 
                       rel="noopener"
                       class="w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('pages.show', $page->slug)) }}&text={{ urlencode($page->title) }}" 
                       target="_blank" 
                       rel="noopener"
                       class="w-10 h-10 rounded-full bg-sky-500 hover:bg-sky-600 flex items-center justify-center text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($page->title . ' - ' . route('pages.show', $page->slug)) }}" 
                       target="_blank" 
                       rel="noopener"
                       class="w-10 h-10 rounded-full bg-green-600 hover:bg-green-700 flex items-center justify-center text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Pages or Navigation -->
<section class="py-16 bg-gradient-to-br from-primary-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Halaman Lainnya</h2>
            <p class="text-gray-600">Jelajahi halaman-halaman lain yang mungkin Anda minati</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
                $relatedPages = \App\Models\Page::published()
                    ->where('id', '!=', $page->id)
                    ->ordered()
                    ->take(3)
                    ->get();
            @endphp
            
            @foreach($relatedPages as $relatedPage)
            <a href="{{ route('pages.show', $relatedPage->slug) }}" 
               class="bg-white rounded-xl p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                @if($relatedPage->featured_image)
                <img src="{{ asset('storage/' . $relatedPage->featured_image) }}" 
                     alt="{{ $relatedPage->title }}" 
                     class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                    {{ $relatedPage->title }}
                </h3>
                @if($relatedPage->excerpt)
                <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $relatedPage->excerpt }}</p>
                @endif
                <span class="inline-flex items-center text-primary-600 font-semibold text-sm group-hover:gap-2 transition-all">
                    Baca selengkapnya
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
