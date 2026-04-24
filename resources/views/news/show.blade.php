@extends('layouts.app')

@section('title', $news->title . ' - Publisher')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-primary-600 font-medium">Beranda</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="/news" class="hover:text-primary-600 font-medium">Berita</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-semibold">{{ Str::limit($news->title, 50) }}</span>
        </nav>
    </div>
</div>

<!-- Main Content Area -->
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Column: Article -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <!-- Featured Image -->
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-auto max-h-[500px] object-cover">
                    @else
                        <div class="w-full aspect-[2/1] bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                            <svg class="w-32 h-32 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="p-8 lg:p-12">
                        <!-- Category & Date -->
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <a href="{{ route('news.index', ['category' => $news->category_id]) }}" class="inline-block bg-primary-50 text-primary-700 hover:bg-primary-100 hover:text-primary-800 transition px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">
                                {{ $news->category->name ?? 'Berita' }}
                            </a>
                            <div class="flex items-center text-gray-500 text-sm font-medium">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $news->published_at ? $news->published_at->format('d F Y') : date('d F Y') }}
                            </div>
                            <div class="flex items-center text-gray-500 text-sm font-medium">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($news->views ?? rand(50,500)) }} kali dibaca
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl lg:text-4xl font-display font-bold text-gray-900 mb-8 leading-tight">
                            {{ $news->title }}
                        </h1>

                        <!-- Author & Share -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-8 mb-8 border-b border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-inner">
                                    AD
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">Admin Tim Redaksi</div>
                                    <div class="text-sm text-gray-500">Publisher News</div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-bold text-gray-900 mr-2 uppercase tracking-wide">Bagikan:</span>
                                
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-[#1877F2] text-gray-600 hover:text-white rounded-full transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                
                                <!-- Twitter/X -->
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-black text-gray-600 hover:text-white rounded-full transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                                
                                <!-- WhatsApp -->
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->fullUrl()) }}" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-[#25D366] text-gray-600 hover:text-white rounded-full transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="prose prose-lg max-w-none prose-indigo">
                            @if($news->summary)
                            <div class="text-xl text-gray-800 leading-relaxed mb-10 font-medium p-6 bg-gray-50 border-l-4 border-primary-500 rounded-r-xl italic">
                                "{{ $news->summary }}"
                            </div>
                            @endif

                            <div class="text-gray-800 leading-relaxed whitespace-pre-line text-[17px]">
                                {!! nl2br(e($news->content)) !!}
                            </div>
                        </div>

                        <!-- Tags / Keywords -->
                        @if($news->keywords)
                        <div class="mt-12 pt-8 border-t border-gray-100 flex items-center flex-wrap gap-2">
                            <span class="text-sm font-bold text-gray-900 mr-2 uppercase tracking-wide">Tags:</span>
                            @foreach(explode(',', $news->keywords) as $keyword)
                            <span class="inline-block px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer">
                                #{{ trim($keyword) }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </article>


            </div>

            <!-- Right Column: Sidebar -->
            <aside class="lg:col-span-4 space-y-8">
                
                <!-- Search Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari Berita
                    </h3>
                    <form action="{{ route('news.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Ketik kata kunci..." class="w-full pl-4 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:outline-none bg-gray-50 focus:bg-white transition">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-primary-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                <!-- Categories -->
                @if(isset($categories) && $categories->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Kategori Berita
                    </h3>
                    <ul class="space-y-3">
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('news.index', ['category' => $cat->id]) }}" class="flex items-center justify-between group py-1">
                                <span class="text-gray-600 group-hover:text-primary-600 font-medium transition flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-gray-300 group-hover:text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $cat->name }}
                                </span>
                                <span class="bg-gray-100 text-gray-500 group-hover:bg-primary-100 group-hover:text-primary-600 px-2.5 py-0.5 rounded-full text-xs font-bold transition">{{ $cat->news_count ?? 0 }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Popular News -->
                @if(isset($popularNews) && $popularNews->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Berita Terpopuler
                    </h3>
                    <div class="space-y-6">
                        @foreach($popularNews as $index => $pop)
                        <a href="{{ route('news.show', $pop->slug) }}" class="flex group items-start">
                            <div class="flex-shrink-0 relative w-20 h-20 rounded-xl overflow-hidden mr-4 shadow-sm">
                                <div class="absolute top-0 left-0 bg-primary-600 text-white w-6 h-6 flex items-center justify-center text-xs font-bold z-10 rounded-br-lg">{{ $index + 1 }}</div>
                                @if($pop->image)
                                <img src="{{ asset('storage/' . $pop->image) }}" alt="{{ $pop->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                <div class="w-full h-full bg-primary-100 flex items-center justify-center text-primary-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition leading-snug">{{ $pop->title }}</h4>
                                <div class="text-xs text-gray-500 flex items-center font-medium">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $pop->published_at ? $pop->published_at->format('d M Y') : '' }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Subscribe Widget -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-900 rounded-2xl shadow-lg p-8 text-white text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-5 rounded-full translate-y-10 -translate-x-10"></div>
                    
                    <svg class="w-12 h-12 mx-auto text-primary-200 mb-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <h3 class="text-xl font-bold mb-2 relative z-10">Langganan Newsletter</h3>
                    <p class="text-primary-100 text-sm mb-6 relative z-10">Dapatkan update berita, artikel, dan pengumuman terbaru ke inbox Anda.</p>
                    <form class="relative z-10">
                        <input type="email" placeholder="Alamat Email Anda" class="w-full px-4 py-3 rounded-xl text-gray-900 mb-3 focus:outline-none focus:ring-2 focus:ring-white bg-white/90">
                        <button type="button" class="w-full px-4 py-3 bg-white text-primary-800 font-bold rounded-xl hover:bg-gray-50 transition shadow-lg">Berlangganan Sekarang</button>
                    </form>
                </div>

            </aside>
        </div>
    </div>
</div>

<!-- Related News -->
<section class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-primary-500 pl-4">Berita Terkait</h2>
            <a href="{{ route('news.index') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center transition group">
                Lihat Semua
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @forelse($relatedNews as $related)
            <article class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[16/9] bg-gray-100">
                    <a href="{{ route('news.show', $related->slug) }}">
                        @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" 
                             alt="{{ $related->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-purple-100">
                            <svg class="w-16 h-16 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        @endif
                    </a>
                    @if($related->category)
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur text-primary-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            {{ $related->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center text-xs text-gray-500 mb-3 font-medium">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $related->published_at ? $related->published_at->format('d M Y') : '' }}
                    </div>
                    <a href="{{ route('news.show', $related->slug) }}">
                        <h3 class="font-bold text-lg text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200 leading-snug">
                            {{ $related->title }}
                        </h3>
                    </a>
                    <a href="{{ route('news.show', $related->slug) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold group/link text-sm">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border border-gray-100">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <p class="text-gray-500 font-medium">Belum ada berita terkait.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
