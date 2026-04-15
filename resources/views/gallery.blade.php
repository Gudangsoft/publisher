@extends('layouts.app')

@section('title', 'Galeri Foto & Video - ' . \App\Models\Setting::get('site_name', 'Publisher'))
@section('meta_description', 'Lihat koleksi foto dan video dari ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-primary-900 py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        </div>
        <!-- Floating Elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-primary-500/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-primary-400/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-primary-300 text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
                Galeri Media
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-display">
                Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-300">Foto & Video</span>
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Jelajahi koleksi dokumentasi kegiatan, acara, dan momen berharga kami
            </p>
        </div>
    </section>

    <!-- Filter & Gallery Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" 
             x-data="{ 
                activeFilter: '{{ request('type', 'all') }}', 
                activeCategory: '{{ request('category', '') }}',
                lightbox: false,
                lightboxImg: '',
                lightboxTitle: '',
                lightboxDesc: '',
                lightboxVideo: '',
                lightboxType: 'photo',
                openLightbox(type, src, title, desc) {
                    this.lightboxType = type;
                    if (type === 'photo') {
                        this.lightboxImg = src;
                        this.lightboxVideo = '';
                    } else {
                        this.lightboxVideo = src;
                        this.lightboxImg = '';
                    }
                    this.lightboxTitle = title;
                    this.lightboxDesc = desc;
                    this.lightbox = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLightbox() {
                    this.lightbox = false;
                    this.lightboxVideo = '';
                    document.body.style.overflow = '';
                }
             }">
        
        <!-- Filters -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10">
            <!-- Type Tabs -->
            <div class="flex items-center bg-gray-100 rounded-xl p-1 gap-1">
                <a href="{{ route('gallery', ['category' => request('category')]) }}" 
                   class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 {{ !request('type') ? 'bg-white shadow-sm text-primary-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Semua
                </a>
                <a href="{{ route('gallery', ['type' => 'photo', 'category' => request('category')]) }}" 
                   class="px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 transition-all duration-200 {{ request('type') === 'photo' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                    📷 Foto
                </a>
                <a href="{{ route('gallery', ['type' => 'video', 'category' => request('category')]) }}" 
                   class="px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 transition-all duration-200 {{ request('type') === 'video' ? 'bg-white shadow-sm text-red-600' : 'text-gray-600 hover:text-gray-900' }}">
                    🎬 Video
                </a>
            </div>

            <!-- Category Filter -->
            @if($categories->count())
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <a href="{{ route('gallery', ['type' => request('type')]) }}" 
                   class="px-3 py-1.5 rounded-full text-xs font-medium border transition-all {{ !request('category') ? 'bg-primary-50 border-primary-300 text-primary-700' : 'bg-white border-gray-200 text-gray-600 hover:border-primary-300' }}">
                    Semua Album
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('gallery', ['type' => request('type'), 'category' => $cat]) }}" 
                   class="px-3 py-1.5 rounded-full text-xs font-medium border transition-all {{ request('category') === $cat ? 'bg-primary-50 border-primary-300 text-primary-700' : 'bg-white border-gray-200 text-gray-600 hover:border-primary-300' }}">
                    {{ $cat }}
                </a>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Gallery Grid -->
        @if($galleries->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galleries as $gallery)
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 cursor-pointer"
                 @click="openLightbox(
                    '{{ $gallery->type }}', 
                    '{{ $gallery->type === 'photo' ? asset('storage/' . $gallery->file_path) : $gallery->youtube_embed_url }}',
                    '{{ addslashes($gallery->title) }}',
                    '{{ addslashes($gallery->description ?? '') }}'
                 )">
                
                <!-- Image/Thumbnail -->
                <div class="relative aspect-[4/3] overflow-hidden">
                    @if($gallery->type === 'photo' && $gallery->file_path)
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                             loading="lazy">
                    @elseif($gallery->display_thumbnail)
                        <img src="{{ $gallery->display_thumbnail }}" alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                    <!-- Video Play Button -->
                    @if($gallery->type === 'video')
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-red-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                    @endif

                    <!-- Zoom Icon (for photos) -->
                    @if($gallery->type === 'photo')
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                    @endif

                    <!-- Type Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-full backdrop-blur-sm {{ $gallery->type === 'photo' ? 'bg-blue-500/80 text-white' : 'bg-red-500/80 text-white' }}">
                            {{ $gallery->type === 'photo' ? '📷' : '🎬' }}
                        </span>
                    </div>

                    <!-- Category -->
                    @if($gallery->category)
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-black/40 text-white backdrop-blur-sm">
                            {{ $gallery->category }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg group-hover:text-primary-600 transition-colors duration-300">{{ $gallery->title }}</h3>
                    @if($gallery->description)
                    <p class="text-sm text-gray-500 mt-2 line-clamp-2 leading-relaxed">{{ $gallery->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $galleries->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Galeri</h3>
            <p class="text-gray-500">Konten galeri sedang disiapkan. Silakan kunjungi kembali nanti.</p>
        </div>
        @endif

        <!-- Lightbox Modal -->
        <div x-show="lightbox" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeLightbox()"
             @keydown.escape.window="closeLightbox()"
             class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm flex items-center justify-center p-4"
             x-cloak>
            
            <!-- Close Button -->
            <button @click="closeLightbox()" class="absolute top-4 right-4 z-50 p-2 bg-white/10 hover:bg-white/20 rounded-full text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Content -->
            <div @click.stop class="max-w-5xl w-full max-h-[90vh] flex flex-col items-center">
                <!-- Photo -->
                <template x-if="lightboxType === 'photo'">
                    <img :src="lightboxImg" :alt="lightboxTitle" class="max-h-[75vh] max-w-full object-contain rounded-lg shadow-2xl">
                </template>
                
                <!-- Video -->
                <template x-if="lightboxType === 'video'">
                    <div class="w-full aspect-video rounded-lg overflow-hidden shadow-2xl bg-black">
                        <iframe :src="lightboxVideo + '?autoplay=1'" class="w-full h-full" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </div>
                </template>

                <!-- Title & Description -->
                <div class="mt-4 text-center max-w-2xl" x-show="lightboxTitle">
                    <h3 class="text-xl font-bold text-white" x-text="lightboxTitle"></h3>
                    <p class="text-gray-300 mt-1 text-sm" x-text="lightboxDesc" x-show="lightboxDesc"></p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
