@extends('layouts.app')

@section('title', $book->title . ' - Publisher')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-primary-600">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="/books" class="hover:text-primary-600">Katalog Buku</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ Str::limit($book->title, 50) }}</span>
        </nav>
    </div>
</div>

<!-- Book Detail -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Book Image -->
            <div class="space-y-4">
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden shadow-2xl" id="main-image">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-auto object-cover">
                    @else
                        <div class="aspect-[3/4] flex items-center justify-center">
                            <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Gallery Thumbnails -->
                @if($book->images && count($book->images) > 0)
                <div class="grid grid-cols-4 gap-3">
                    @if($book->cover)
                    <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 ring-primary-500 transition-all duration-200 border-2 border-primary-500" onclick="changeImage('{{ asset('storage/' . $book->cover) }}', this)">
                        <img src="{{ asset('storage/' . $book->cover) }}" 
                             alt="Cover" 
                             class="w-full h-full object-cover">
                    </div>
                    @endif
                    
                    @foreach($book->images as $image)
                    <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 ring-primary-500 transition-all duration-200" onclick="changeImage('{{ asset('storage/' . $image) }}', this)">
                        <img src="{{ asset('storage/' . $image) }}" 
                             alt="Gallery {{ $loop->iteration }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                
                <script>
                    function changeImage(src, element) {
                        document.querySelector('#main-image img').src = src;
                        // Remove border from all thumbnails
                        document.querySelectorAll('.grid > div').forEach(el => {
                            el.classList.remove('border-2', 'border-primary-500');
                        });
                        // Add border to clicked thumbnail
                        element.classList.add('border-2', 'border-primary-500');
                    }
                </script>
                @endif
            </div>

            <!-- Book Info -->
            <div>
                <!-- Category Badge -->
                <div class="mb-4">
                    <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-semibold">
                        {{ $book->category->name ?? 'Tanpa Kategori' }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4 leading-tight">
                    {{ $book->title }}
                </h1>

                <!-- Author -->
                <p class="text-xl text-gray-600 mb-6">
                    Oleh <span class="text-primary-600 font-semibold">{{ $book->author }}</span>
                </p>

                <!-- Availability -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <p class="text-sm text-green-600 font-medium">
                        ✓ Buku tersedia di katalog kami
                    </p>
                </div>

                <!-- Book Details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="font-bold text-gray-900 mb-4">Detail Buku</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        @if($book->isbn)
                        <div>
                            <span class="text-gray-600">ISBN:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $book->isbn }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="text-gray-600">Penerbit:</span>
                            <span class="font-medium text-gray-900 ml-2">Publisher</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Kategori:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $book->category->name ?? '-' }}</span>
                        </div>
                        @if($book->published_at)
                        <div>
                            <span class="text-gray-600">Tanggal Terbit:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $book->published_at->format('d F Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="mb-8">
                    <a href="/books" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Katalog
                    </a>
                </div>

                <!-- Share -->
                <div class="flex items-center space-x-4 pt-6 border-t border-gray-200">
                    <span class="text-gray-700 font-medium">Bagikan:</span>
                    <div class="flex space-x-2">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="p-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 group">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        
                        <!-- Twitter/X -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->title . ' - ' . $book->author) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="p-2 bg-black hover:bg-gray-800 rounded-lg transition-colors duration-200 group">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($book->title . ' - ' . $book->author . ' ' . request()->fullUrl()) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="p-2 bg-green-500 hover:bg-green-600 rounded-lg transition-colors duration-200 group">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                        
                        <!-- Telegram -->
                        <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->title . ' - ' . $book->author) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="p-2 bg-blue-500 hover:bg-blue-600 rounded-lg transition-colors duration-200 group">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </a>
                        
                        <!-- Copy Link -->
                        <button onclick="copyToClipboard('{{ request()->fullUrl() }}')" 
                                class="p-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition-colors duration-200 group">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <script>
                    function copyToClipboard(text) {
                        navigator.clipboard.writeText(text).then(() => {
                            alert('Link berhasil disalin!');
                        }).catch(err => {
                            console.error('Gagal menyalin link: ', err);
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</section>

<!-- Book Description & Tabs -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="{ activeTab: 'description' }" class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <div class="flex space-x-8 px-8">
                    <button @click="activeTab = 'description'" 
                            :class="activeTab === 'description' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-4 px-1 border-b-2 font-semibold transition-colors duration-200">
                        Deskripsi
                    </button>
                    <button @click="activeTab = 'details'" 
                            :class="activeTab === 'details' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-4 px-1 border-b-2 font-semibold transition-colors duration-200">
                        Spesifikasi
                    </button>
                    <button @click="activeTab = 'reviews'" 
                            :class="activeTab === 'reviews' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-4 px-1 border-b-2 font-semibold transition-colors duration-200">
                        Ulasan (245)
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" class="prose prose-lg max-w-none">
                    @if($book->description)
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $book->description }}
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ada deskripsi untuk buku ini.</p>
                    @endif
                </div>

                <!-- Details Tab -->
                <div x-show="activeTab === 'details'">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            @if($book->isbn)
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">ISBN</span>
                                <span class="font-medium text-gray-900">{{ $book->isbn }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Penerbit</span>
                                <span class="font-medium text-gray-900">Publisher</span>
                            </div>
                            @if($book->published_at)
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Tanggal Terbit</span>
                                <span class="font-medium text-gray-900">{{ $book->published_at->format('d F Y') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Penulis</span>
                                <span class="font-medium text-gray-900">{{ $book->author }}</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Kategori</span>
                                <span class="font-medium text-gray-900">{{ $book->category->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Berat</span>
                                <span class="font-medium text-gray-900">400 gram</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Dimensi</span>
                                <span class="font-medium text-gray-900">14 x 21 cm</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="text-gray-600">Jenis Cover</span>
                                <span class="font-medium text-gray-900">Soft Cover</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" class="space-y-6">
                    <!-- Review Summary -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-8">
                            <div class="text-center">
                                <div class="text-5xl font-bold text-gray-900 mb-2">4.5</div>
                                <div class="flex text-yellow-400 mb-2">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">245 ulasan</div>
                            </div>
                            <div class="flex-1 space-y-2">
                                @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600 w-8">{{ $i }} ★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ rand(20, 90) }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-12 text-right">{{ rand(20, 120) }}</span>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Individual Reviews -->
                    @for($i = 1; $i <= 3; $i++)
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                A{{ $i }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Pembeli {{ $i }}</h4>
                                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                                            <span>{{ date('d M Y', strtotime('-'.$i.' days')) }}</span>
                                            <span>•</span>
                                            <span class="text-green-600">✓ Verified Purchase</span>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for($j = 0; $j < 5; $j++)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700 leading-relaxed">
                                    Buku yang sangat bagus dan menarik! Ceritanya mengalir dengan baik dan karakternya sangat kuat. Sangat direkomendasikan untuk pecinta fiksi.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endfor

                    <button class="w-full py-3 border-2 border-gray-300 hover:border-primary-500 text-gray-700 hover:text-primary-600 rounded-xl font-semibold transition-all duration-200">
                        Lihat Semua Ulasan
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Books -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-bold text-gray-900 mb-8">Buku Terkait</h2>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @for($i = 1; $i <= 5; $i++)
            <div class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <a href="/books/{{ $i }}">
                    <div class="aspect-[3/4] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&h=600&fit=crop&q=80" 
                             alt="Related Book" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="font-bold text-sm text-gray-900 mb-2 line-clamp-2">Buku Terkait {{ $i }}</h3>
                    <p class="text-sm text-gray-600 mb-2">Penulis</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-primary-600">Rp 85.000</span>
                        <div class="flex text-yellow-400">
                            @for($j = 0; $j < 5; $j++)
                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>
@endsection
