@extends('layouts.app')

@section('title', 'Katalog Buku - Publisher')
@section('meta_description', 'Jelajahi koleksi lengkap buku dari publisher terpercaya. Temukan buku favorit Anda dari berbagai kategori.')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-primary-50 to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl font-display font-bold text-gray-900 mb-4">Katalog Buku</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Temukan buku yang Anda cari dari koleksi lengkap kami
            </p>
        </div>
    </div>
</section>

<!-- Filters & Search -->
<section class="bg-white border-b border-gray-200 sticky top-20 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row gap-4 items-center">
            <!-- Search -->
            <div class="flex-1 w-full">
                <div class="relative">
                    <input type="text" 
                           placeholder="Cari berdasarkan judul, penulis, atau ISBN..." 
                           class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Category Filter -->
            <select class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200 bg-white">
                <option value="">Semua Kategori</option>
                <option value="fiksi">Fiksi</option>
                <option value="non-fiksi">Non-Fiksi</option>
                <option value="pendidikan">Pendidikan</option>
                <option value="biografi">Biografi</option>
                <option value="teknologi">Teknologi</option>
                <option value="anak">Anak-Anak</option>
            </select>

            <!-- Sort -->
            <select class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200 bg-white">
                <option value="latest">Terbaru</option>
                <option value="popular">Terpopuler</option>
                <option value="price-low">Harga Terendah</option>
                <option value="price-high">Harga Tertinggi</option>
                <option value="title">Judul A-Z</option>
            </select>

            <!-- View Toggle -->
            <div class="hidden md:flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                <button class="p-3 bg-primary-500 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button class="p-3 bg-white text-gray-400 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Books Grid -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Results Info -->
        <div class="flex justify-between items-center mb-8">
            <p class="text-gray-600">
                Menampilkan <span class="font-semibold">{{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }}</span> dari <span class="font-semibold">{{ $books->total() }}</span> buku
            </p>
        </div>

        <!-- Books Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-12">
            @forelse($books as $book)
            <div class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                <div class="relative">
                    <a href="{{ route('books.show', $book->id) }}">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-purple-100">
                                    <svg class="w-24 h-24 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </a>
                    
                    <!-- Category Badge -->
                    @if($book->category)
                    <div class="absolute top-3 left-3 bg-primary-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                        {{ $book->category->name }}
                    </div>
                    @endif

                    <!-- Wishlist Button -->
                    <button class="absolute top-3 right-3 bg-white/90 hover:bg-white p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>

                <div class="p-5">
                    @if($book->category)
                    <div class="mb-2">
                        <span class="text-xs text-primary-600 font-semibold">{{ $book->category->name }}</span>
                    </div>
                    @endif
                    <a href="{{ route('books.show', $book->id) }}">
                        <h3 class="font-bold text-base text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200">
                            {{ $book->title }}
                        </h3>
                    </a>
                    <p class="text-sm text-gray-600 mb-3">{{ $book->author }}</p>
                    
                    @if($book->description)
                    <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ Str::limit($book->description, 80) }}</p>
                    @endif

                    @if($book->isbn)
                    <p class="text-xs text-gray-400 mb-3">ISBN: {{ $book->isbn }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada buku tersedia</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="flex justify-center">
            {{ $books->links() }}
        </div>
        @endif
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

<!-- Newsletter CTA -->
<section class="py-16 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4">Tidak Menemukan Buku yang Anda Cari?</h2>
        <p class="text-xl text-primary-100 mb-8">
            Hubungi kami atau subscribe newsletter untuk mendapat info buku terbaru
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/contact" class="px-8 py-4 bg-white hover:bg-gray-100 text-primary-600 rounded-xl font-bold transition-all duration-200">
                Hubungi Kami
            </a>
            <a href="#newsletter" class="px-8 py-4 border-2 border-white hover:bg-white hover:text-primary-600 text-white rounded-xl font-bold transition-all duration-200">
                Subscribe Newsletter
            </a>
        </div>
    </div>
</section>
@endsection
