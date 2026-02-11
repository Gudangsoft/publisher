@extends('layouts.app')

@section('title', 'Berita & Artikel - Publisher')
@section('meta_description', 'Baca berita terkini, artikel menarik, dan update terbaru seputar dunia literasi dan penerbitan buku.')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-primary-50 to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl font-display font-bold text-gray-900 mb-4">Berita & Artikel</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Update terkini seputar dunia literasi, penulis, dan buku terbaru
            </p>
        </div>
    </div>
</section>

<!-- Featured Post -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl overflow-hidden shadow-2xl">
            <div class="grid lg:grid-cols-2">
                <div class="relative h-80 lg:h-auto">
                    <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&h=600&fit=crop&q=80" 
                         alt="Featured News" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-6 left-6">
                        <span class="bg-primary-500 text-white px-4 py-2 rounded-full text-sm font-bold">
                            FEATURED
                        </span>
                    </div>
                </div>
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="flex items-center text-gray-400 text-sm mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ date('d F Y') }}
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-display font-bold text-white mb-4 leading-tight">
                        Peluncuran Koleksi Buku Terbaru: Karya Penulis Terbaik 2024
                    </h2>
                    <p class="text-gray-300 text-lg mb-6 leading-relaxed">
                        Kami dengan bangga mempersembahkan koleksi buku terbaru dari penulis-penulis terbaik Indonesia. Temukan cerita inspiratif dan pengetahuan berharga dalam setiap halamannya.
                    </p>
                    <a href="/news/1" class="inline-flex items-center text-primary-400 hover:text-primary-300 font-semibold text-lg group">
                        Baca Selengkapnya
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Filter -->
<section class="bg-gray-50 border-y border-gray-200 sticky top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-wrap gap-3 justify-center">
            <button class="px-6 py-2 bg-primary-500 text-white rounded-full font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                Semua
            </button>
            @foreach(['Rilis Buku', 'Wawancara Penulis', 'Tips Menulis', 'Event', 'Promo'] as $category)
            <button class="px-6 py-2 bg-white hover:bg-gray-100 text-gray-700 rounded-full font-medium border-2 border-gray-200 hover:border-primary-500 transition-all duration-200">
                {{ $category }}
            </button>
            @endforeach
        </div>
    </div>
</section>

<!-- News Grid -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($newsItems as $news)
            <article class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                <div class="relative">
                    <a href="{{ route('news.show', $news->id) }}">
                        <div class="aspect-[16/9] overflow-hidden bg-gray-100">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" 
                                     alt="{{ $news->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-purple-100">
                                    <svg class="w-24 h-24 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </a>
                    @if($news->category)
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-sm text-primary-600 px-3 py-1 rounded-full text-xs font-bold">
                            {{ $news->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $news->published_at->format('d M Y') }}
                        @if($news->content)
                        <span class="mx-2">•</span>
                        <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca</span>
                        @endif
                    </div>
                    
                    <a href="{{ route('news.show', $news->id) }}">
                        <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200 leading-tight">
                            {{ $news->title }}
                        </h3>
                    </a>
                    
                    @if($news->summary)
                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                        {{ $news->summary }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($news->title, 0, 2)) }}
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Admin</span>
                        </div>
                        
                        <a href="{{ route('news.show', $news->id) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm group/link">
                            Baca
                            <svg class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($newsItems->hasPages())
        <div class="flex justify-center mt-12">
            {{ $newsItems->links() }}
        </div>
        @endif
        <div class="flex justify-center items-center space-x-2 mt-12">
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                Previous
            </button>
            @for($i = 1; $i <= 5; $i++)
            <button class="px-4 py-2 {{ $i == 1 ? 'bg-primary-500 text-white' : 'border border-gray-300 text-gray-600 hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                {{ $i }}
            </button>
            @endfor
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                Next
            </button>
        </div>
    </div>
</section>

<!-- Newsletter Subscription -->
<section class="py-16 bg-gradient-to-br from-primary-600 to-primary-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-4xl font-display font-bold mb-4">Jangan Lewatkan Berita Terbaru</h2>
        <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
            Subscribe newsletter kami dan dapatkan update berita, artikel, dan info buku terbaru langsung ke email Anda
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            <input type="email" placeholder="Masukkan email Anda" 
                   class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition-all duration-200">
            <button type="submit" class="px-8 py-4 bg-white hover:bg-gray-100 text-primary-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                Subscribe
            </button>
        </form>
        <p class="text-sm text-primary-200 mt-4">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Privasi Anda terjaga. Unsubscribe kapan saja.
        </p>
    </div>
</section>
@endsection
