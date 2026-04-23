@extends('layouts.app')

@section('title', $news->title . ' - Publisher')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-primary-600">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="/news" class="hover:text-primary-600">Berita</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ Str::limit($news->title, 50) }}</span>
        </nav>
    </div>
</div>

<!-- Article Header -->
<article class="py-12 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Category & Date -->
        <div class="flex items-center space-x-4 mb-6">
            <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-bold">
                {{ $news->category->name ?? 'Berita' }}
            </span>
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $news->published_at ? $news->published_at->format('d F Y') : date('d F Y') }}
            </div>
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-6 leading-tight">
            {{ $news->title }}
        </h1>

        <!-- Author & Share -->
        <div class="flex items-center justify-between pb-8 mb-8 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    AD
                </div>
                <div>
                    <div class="font-semibold text-gray-900">Admin Publisher</div>
                    <div class="text-sm text-gray-500">Editor</div>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600 mr-2">Bagikan:</span>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="p-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                
                <!-- Twitter/X -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="p-2 bg-black hover:bg-gray-800 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
                
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->fullUrl()) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="p-2 bg-green-500 hover:bg-green-600 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </a>
                
                <!-- LinkedIn -->
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($news->title) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="p-2 bg-blue-700 hover:bg-blue-800 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="mb-12">
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" 
                     alt="{{ $news->title }}" 
                     class="w-full rounded-2xl shadow-2xl object-cover" style="max-height: 500px;">
            @else
                <div class="w-full aspect-[2/1] bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                    <svg class="w-32 h-32 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Article Content -->
        <div class="prose prose-lg max-w-none">
            @if($news->summary)
            <p class="text-xl text-gray-700 leading-relaxed mb-8 font-medium border-l-4 border-primary-500 pl-6">
                {{ $news->summary }}
            </p>
            @endif

            <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                {!! nl2br(e($news->content)) !!}
            </div>

            <div class="grid md:grid-cols-2 gap-6 my-8">
                <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-primary-500 transition-colors duration-200">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&h=400&fit=crop&q=80" 
                         alt="Event" 
                         class="w-full h-48 object-cover rounded-lg mb-4">
                    <h4 class="font-bold text-lg text-gray-900 mb-2">Book Fair Jakarta</h4>
                    <p class="text-gray-600 text-sm mb-2">15-17 Desember 2024</p>
                    <p class="text-gray-700">Jakarta Convention Center</p>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-primary-500 transition-colors duration-200">
                    <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600&h=400&fit=crop&q=80" 
                         alt="Event" 
                         class="w-full h-48 object-cover rounded-lg mb-4">
                    <h4 class="font-bold text-lg text-gray-900 mb-2">Author Meet & Greet</h4>
                    <p class="text-gray-600 text-sm mb-2">20 Desember 2024</p>
                    <p class="text-gray-700">Toko Buku Publisher Jakarta</p>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Cara Pemesanan</h3>

            <p class="text-gray-700 leading-relaxed mb-6">
                Buku-buku dari koleksi terbaru ini sudah dapat dipesan melalui:
            </p>

            <ol class="list-decimal list-inside space-y-2 mb-8 text-gray-700">
                <li>Website resmi Publisher di <a href="/books" class="text-primary-600 hover:text-primary-700 font-semibold">katalog buku</a></li>
                <li>Toko buku Partner di seluruh Indonesia</li>
                <li>Marketplace online (Tokopedia, Shopee, Bukalapak)</li>
                <li>Pemesanan langsung via WhatsApp: +62 812 3456 7890</li>
            </ol>

            <p class="text-gray-700 leading-relaxed">
                Untuk informasi lebih lanjut tentang koleksi terbaru kami atau untuk jadwal acara peluncuran di kota Anda, silakan hubungi tim customer service kami atau kunjungi halaman <a href="/contact" class="text-primary-600 hover:text-primary-700 font-semibold">kontak</a> kami.
            </p>
        </div>

        <!-- Tags -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-semibold text-gray-600">Tags:</span>
                @foreach(['Rilis Buku', 'Koleksi Baru', 'Promo', 'Event'] as $tag)
                <a href="#" class="px-4 py-2 bg-gray-100 hover:bg-primary-50 hover:text-primary-600 text-gray-700 rounded-full text-sm font-medium transition-colors duration-200">
                    {{ $tag }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</article>

<!-- Related News -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-bold text-gray-900 mb-8">Berita Terkait</h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            @for($i = 1; $i <= 3; $i++)
            <article class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[16/9]">
                    <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600&h=400&fit=crop&q=80&sig={{ $i }}" 
                         alt="Related News" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ date('d M Y', strtotime('-'.$i.' days')) }}
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200">
                        Berita Menarik Lainnya Tentang Dunia Literasi {{ $i }}
                    </h3>
                    <a href="/news/{{ $i }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endfor
        </div>
    </div>
</section>

<!-- Newsletter CTA -->
<section class="py-16 bg-gradient-to-br from-primary-600 to-primary-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4">Dapatkan Update Berita Terbaru</h2>
        <p class="text-xl text-primary-100 mb-8">
            Subscribe newsletter kami untuk mendapatkan berita, artikel, dan info promo terbaru
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            <input type="email" placeholder="Masukkan email Anda" 
                   class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition-all duration-200">
            <button type="submit" class="px-8 py-4 bg-white hover:bg-gray-100 text-primary-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                Subscribe
            </button>
        </form>
    </div>
</section>
@endsection
