@extends('layouts.app')

@section('title', 'Beranda - Publisher Buku Berkualitas')
@section('meta_description', 'Temukan koleksi buku terbaik dari publisher terpercaya di Indonesia. Berbagai genre untuk semua kalangan.')

@section('content')
<!-- Professional Hero Slider Section -->
<section class="relative w-full overflow-hidden bg-slate-900 h-[500px] lg:h-[600px] xl:h-[700px]">
    @if($heroSliders->count() > 0)
    
    <!-- Alpine.js Slider Data -->
    <div x-data="{
        currentSlide: 0,
        slides: {{ $heroSliders->count() }},
        init() {
            if (this.slides > 1) {
                setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.slides; }, 6000);
            }
        }
    }" class="relative h-full">
        
        <!-- Slider Items -->
        @foreach($heroSliders as $index => $slider)
        <div x-cloak x-show="currentSlide === {{ $index }}" 
             x-transition:enter="transition duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0">
            
            <!-- Image Background -->
            <img src="{{ str_starts_with($slider->image, 'http') ? $slider->image : asset('storage/' . $slider->image) }}" 
                 alt="{{ $slider->title }}" 
                 class="absolute inset-0 w-full h-full object-contain object-center"
                 loading="lazy">
            
            <!-- Professional Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/85 via-slate-900/50 to-slate-900/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex items-center">
                <div class="w-full px-6 sm:px-8 md:px-12 lg:px-16">
                    <div class="max-w-3xl">
                        <!-- Subtitle Badge -->
                        @if($slider->subtitle)
                        <div class="inline-block mb-4 sm:mb-6"
                             x-show="currentSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-700 delay-100"
                             x-transition:enter-start="opacity-0 -translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <span class="inline-block px-4 py-2 bg-gradient-to-r from-primary-500/80 to-primary-600/80 text-white text-sm font-semibold rounded-full backdrop-blur-sm border border-primary-400/30">
                                {{ $slider->subtitle }}
                            </span>
                        </div>
                        @endif
                        
                        <!-- Main Title -->
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-display font-black text-white mb-4 md:mb-6 leading-tight tracking-tight drop-shadow-2xl"
                            x-show="currentSlide === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-200"
                            x-transition:enter-start="opacity-0 -translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            {{ $slider->title }}
                        </h1>
                        
                        <!-- Description -->
                        @if($slider->description)
                        <p class="text-lg sm:text-xl text-gray-100 mb-8 md:mb-10 max-w-2xl leading-relaxed font-light drop-shadow-lg"
                           x-show="currentSlide === {{ $index }}"
                           x-transition:enter="transition ease-out duration-700 delay-300"
                           x-transition:enter-start="opacity-0 -translate-y-4"
                           x-transition:enter-end="opacity-100 translate-y-0">
                            {{ $slider->description }}
                        </p>
                        @endif
                        
                        <!-- CTA Button -->
                        @if($slider->button_text && $slider->button_link)
                        <div class="flex flex-wrap gap-4"
                             x-show="currentSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-700 delay-400"
                             x-transition:enter-start="opacity-0 -translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <a href="{{ $slider->button_link }}" 
                               class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                                <span>{{ $slider->button_text }}</span>
                                <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Navigation Controls -->
        @if($heroSliders->count() > 1)
        <div class="absolute bottom-8 left-0 right-0 z-20">
            <div class="flex items-center justify-center md:justify-start md:pl-12 lg:pl-16 gap-8">
                <!-- Previous Button -->
                <button @click="currentSlide = (currentSlide - 1 + slides) % slides" 
                        class="group p-3 rounded-full bg-white/10 hover:bg-white/20 border border-white/30 hover:border-white/50 text-white transition-all duration-300 backdrop-blur-sm">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <!-- Slide Indicators -->
                <div class="flex gap-3">
                    @foreach($heroSliders as $index => $slider)
                    <button @click="currentSlide = {{ $index }}"
                            :class="currentSlide === {{ $index }} ? 'bg-white w-10' : 'bg-white/50 hover:bg-white/70 w-3'"
                            class="h-1.5 rounded-full transition-all duration-300">
                    </button>
                    @endforeach
                </div>
                
                <!-- Next Button -->
                <button @click="currentSlide = (currentSlide + 1) % slides" 
                        class="group p-3 rounded-full bg-white/10 hover:bg-white/20 border border-white/30 hover:border-white/50 text-white transition-all duration-300 backdrop-blur-sm">
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Slide Counter -->
        <div class="absolute top-8 right-8 z-20 text-white">
            <div class="text-sm font-medium">
                <span x-text="currentSlide + 1"></span> / <span>{{ $heroSliders->count() }}</span>
            </div>
        </div>
        
    </div>
    @else
    <!-- Fallback Banner -->
    <div class="relative h-full flex items-center bg-gradient-to-br from-slate-900 to-slate-800 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500 rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-40 right-10 w-96 h-96 bg-primary-600 rounded-full filter blur-3xl"></div>
        </div>
        
        <div class="relative w-full px-6 sm:px-8 md:px-12 lg:px-16 pt-32 lg:pt-28">
            <div class="max-w-3xl">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-display font-black text-white mb-6 leading-tight tracking-tight">
                    Jendela Ilmu <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-600">Untuk Semua</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-300 mb-8 max-w-2xl leading-relaxed font-light">
                    Temukan koleksi buku terlengkap dan berkualitas dari penerbit terpercaya. Berbagai genre untuk semua kalangan.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/books" 
                       class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <span>Jelajahi Katalog</span>
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

    @else
    <!-- Default/Fallback Hero when no sliders are active -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in-up">
                <h1 class="text-5xl lg:text-7xl font-display font-bold text-gray-900 mb-6 leading-tight">
                    Jendela Ilmu <br>
                    <span class="text-gradient">Untuk Semua</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Temukan koleksi buku terlengkap dan berkualitas dari penerbit terpercaya. Dari fiksi hingga non-fiksi, kami hadir untuk mencerdaskan bangsa.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/books" class="px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                        Jelajahi Katalog
                    </a>
                    <a href="/about" class="px-8 py-4 bg-white border-2 border-gray-200 hover:border-primary-500 text-gray-900 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                        Tentang Kami
                    </a>
                </div>
                
                <!-- Stats -->
                @if($statistics->count() > 0)
                <div class="grid grid-cols-{{ min($statistics->count(), 3) }} gap-6 mt-12">
                    @foreach($statistics as $stat)
                    <div class="text-center">
                        <div class="text-3xl font-bold text-{{ $stat->color }}-600">{{ $stat->value }}{{ $stat->suffix }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ $stat->label }}</div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="grid grid-cols-3 gap-6 mt-12">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-600">1000+</div>
                        <div class="text-sm text-gray-600 mt-1">Judul Buku</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-600">500+</div>
                        <div class="text-sm text-gray-600 mt-1">Penulis</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-600">50K+</div>
                        <div class="text-sm text-gray-600 mt-1">Pembaca</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="relative hidden lg:block">
                <div class="relative z-10">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800&h=1000&fit=crop" 
                         alt="Koleksi Buku" 
                         class="rounded-2xl shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-300">
                </div>
                <div class="absolute top-10 -right-10 w-72 h-72 bg-primary-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        </div>
    </div>
    @endif
</section>

<!-- Featured Books Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">{{ \App\Models\Setting::get('home_books_title', 'Buku Pilihan') }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ \App\Models\Setting::get('home_books_subtitle', 'Koleksi buku terbaik dan terpopuler yang wajib Anda baca') }}</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredBooks as $book)
            <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                <a href="{{ route('books.show', $book) }}" class="block">
                    <div class="relative overflow-hidden aspect-[3/4]">
                        @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        @endif
                        @if($loop->first)
                        <div class="absolute top-4 right-4 bg-primary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Baru
                        </div>
                        @endif
                    </div>
                </a>
                
                <div class="p-6">
                    <a href="{{ route('books.show', $book) }}" class="block mb-4">
                        <h3 class="font-display font-bold text-xl text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200">
                            {{ $book->title }}
                        </h3>
                        <p class="text-gray-600 text-sm">{{ $book->author }}</p>
                        @if($book->category)
                        <p class="text-xs text-primary-600 font-medium mt-2">{{ $book->category->name }}</p>
                        @endif
                    </a>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-2xl font-bold text-primary-600">Rp {{ number_format($book->price ?? 25000, 0, ',', '.') }}</span>
                        </div>
                        @if($book->whatsapp_link)
                        <a href="https://wa.me/+{{ $book->whatsapp_link }}" target="_blank" 
                           class="flex items-center justify-center w-12 h-12 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                        @else
                        <button class="flex items-center justify-center w-12 h-12 bg-primary-50 hover:bg-primary-500 hover:text-white text-primary-600 rounded-lg transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada buku tersedia</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="/books" class="inline-flex items-center px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                Lihat Semua Buku
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">{{ \App\Models\Setting::get('home_categories_title', 'Kategori Buku') }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ \App\Models\Setting::get('home_categories_subtitle', 'Temukan buku sesuai dengan minat dan kebutuhan Anda') }}</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $categories = [
                ['name' => 'Fiksi', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'from-blue-500 to-blue-600'],
                ['name' => 'Non-Fiksi', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'from-green-500 to-green-600'],
                ['name' => 'Pendidikan', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z', 'color' => 'from-purple-500 to-purple-600'],
                ['name' => 'Biografi', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'from-pink-500 to-pink-600'],
                ['name' => 'Teknologi', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'from-indigo-500 to-indigo-600'],
                ['name' => 'Anak-Anak', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'from-yellow-500 to-yellow-600'],
            ];
            @endphp

            @foreach($categories as $category)
            <a href="/books?category={{ strtolower($category['name']) }}" 
               class="group bg-white rounded-xl p-8 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br {{ $category['color'] }} p-4 rounded-xl text-white group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $category['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors duration-200">
                            {{ $category['name'] }}
                        </h3>
                        <p class="text-gray-500 text-sm">Lihat koleksi</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Academic Journals Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">{{ \App\Models\Setting::get('home_journals_title', 'Jurnal Ilmiah') }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ \App\Models\Setting::get('home_journals_subtitle', 'Akses publikasi akademik dan penelitian terkini dari berbagai bidang ilmu') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($featuredJournals as $journal)
            <article class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
                <a href="{{ route('journals.show', $journal->slug) }}" class="block">
                    <div class="relative overflow-hidden aspect-[3/4] bg-gradient-to-br from-blue-50 to-indigo-100">
                        @if($journal->cover_image)
                        <img src="{{ asset('storage/' . $journal->cover_image) }}" 
                             alt="{{ $journal->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            JOURNAL
                        </div>
                    </div>
                </a>
                
                <div class="p-6">
                    <div class="flex items-center text-xs text-gray-500 mb-3">
                        @if($journal->category)
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded font-medium">
                            {{ $journal->category->name }}
                        </span>
                        @endif
                        @if($journal->year)
                        <span class="ml-2">• {{ $journal->year }}</span>
                        @endif
                    </div>
                    
                    <a href="{{ route('journals.show', $journal->slug) }}" class="block mb-3">
                        <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors duration-200">
                            {{ $journal->title }}
                        </h3>
                    </a>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                        {{ Str::limit($journal->authors, 80) }}
                    </p>

                    @if($journal->doi)
                    <p class="text-xs text-gray-500 font-mono mb-3 truncate">
                        DOI: {{ $journal->doi }}
                    </p>
                    @endif

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($journal->views) }}
                        </div>
                        <a href="{{ route('journals.show', $journal->slug) }}" 
                           class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold text-sm group">
                            Baca
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada jurnal tersedia</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('journals.index') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                Lihat Semua Jurnal
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Latest News Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">{{ \App\Models\Setting::get('home_news_title', 'Berita Terkini') }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ \App\Models\Setting::get('home_news_subtitle', 'Update terbaru seputar dunia literasi dan buku') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($latestNews as $news)
            <article class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[16/9]">
                    @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    @endif
                    
                    @if($news->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            FEATURED
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
                        @if($news->category)
                        <span class="mx-2">•</span>
                        <span class="text-primary-600 font-medium">{{ $news->category->name }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200">
                        {{ $news->title }}
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ $news->summary ?? Str::limit(strip_tags($news->content), 120) }}
                    </p>
                    <a href="{{ route('news.show', $news->slug) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold group">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="/news" class="inline-flex items-center px-8 py-4 border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 rounded-xl font-semibold transition-all duration-200">
                Berita Lainnya
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials/Reviews Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">TESTIMONI</span>
            <h2 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">{{ \App\Models\Setting::get('home_testimonials_title', 'Apa Kata Pembaca Kami') }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                {{ \App\Models\Setting::get('home_testimonials_subtitle', 'Kepuasan pembaca adalah prioritas kami. Lihat apa kata mereka tentang buku-buku kami') }}
            </p>
        </div>

        @php
            $reviews = \App\Models\Review::with('book')
                ->approved()
                ->featured()
                ->latest()
                ->take(6)
                ->get();
        @endphp

        @if($reviews->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($reviews as $review)
            <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl border border-gray-200 hover:shadow-xl transition-all duration-300">
                <!-- Star Rating -->
                <div class="flex items-center space-x-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @else
                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @endif
                    @endfor
                </div>

                <!-- Review Text -->
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "{{ $review->review_text }}"
                </p>

                <!-- Reviewer Info -->
                <div class="flex items-center">
                    @if($review->reviewer_photo)
                    <img src="{{ asset('storage/' . $review->reviewer_photo) }}" alt="{{ $review->reviewer_name }}" class="w-12 h-12 rounded-full mr-4 object-cover">
                    @else
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg mr-4">
                        {{ substr($review->reviewer_name, 0, 1) }}
                    </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-900">{{ $review->reviewer_name }}</div>
                        @if($review->book)
                        <div class="text-sm text-gray-500">Review: {{ $review->book->title }}</div>
                        @else
                        <div class="text-sm text-primary-600">Pembaca Setia</div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Default Reviews -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "Buku-bukunya sangat berkualitas dengan harga yang terjangkau. Pengiriman cepat dan packaging rapi. Sangat puas!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg mr-4">A</div>
                    <div>
                        <div class="font-semibold text-gray-900">Ahmad Fauzi</div>
                        <div class="text-sm text-primary-600">Pembaca Setia</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "Koleksi bukunya sangat lengkap, dari fiksi sampai non-fiksi. Customer service responsif dan membantu. Highly recommended!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg mr-4">S</div>
                    <div>
                        <div class="font-semibold text-gray-900">Siti Nurhaliza</div>
                        <div class="text-sm text-primary-600">Mahasiswa</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "Website mudah digunakan, proses checkout lancar. Buku selalu dalam kondisi sempurna saat diterima. Terima kasih!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-lg mr-4">B</div>
                    <div>
                        <div class="font-semibold text-gray-900">Budi Santoso</div>
                        <div class="text-sm text-primary-600">Guru</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="text-center mt-12">
            <p class="text-gray-600 mb-4">Ingin berbagi pengalaman Anda?</p>
            <a href="/contact" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Kirim Review Anda
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-primary-600 to-primary-800 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl lg:text-5xl font-display font-bold mb-6">Bergabunglah dengan Komunitas Pembaca</h2>
        <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto">
            Dapatkan update terbaru tentang rilis buku baru, diskon spesial, dan konten eksklusif langsung ke email Anda
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            <input type="email" placeholder="Masukkan email Anda" 
                   class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition-all duration-200">
            <button type="submit" class="px-8 py-4 bg-white hover:bg-gray-100 text-primary-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                Subscribe
            </button>
        </form>
        <p class="text-sm text-primary-200 mt-4">Kami menghargai privasi Anda. Unsubscribe kapan saja.</p>
    </div>
</section>

<!-- Gallery Section -->
@php
    $galleryAlbums = \App\Models\GalleryAlbum::active()->ordered()
        ->withCount(['galleries' => function($q) {
            $q->where('is_active', true);
        }])
        ->having('galleries_count', '>', 0)
        ->take(8)
        ->get();
    $recentGalleries = \App\Models\Gallery::with('album')->active()->ordered()->take(6)->get();
@endphp

@if($recentGalleries->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">GALERI</span>
            <h2 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">Galeri Foto & Video</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Dokumentasi kegiatan, acara, dan momen berharga kami</p>
        </div>

        <!-- Albums Row -->
        @if($galleryAlbums->count() > 0)
        <div class="mb-12">
            <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Album
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($galleryAlbums as $album)
                <a href="{{ route('gallery', ['album' => $album->id]) }}" 
                   class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500">
                    <div class="aspect-[4/3] overflow-hidden">
                        @if($album->cover_url)
                            <img src="{{ $album->cover_url }}" alt="{{ $album->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-200 to-primary-400 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-sm sm:text-base group-hover:text-primary-300 transition-colors">{{ $album->name }}</h4>
                            <span class="text-xs text-gray-300">{{ $album->galleries_count }} item</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Gallery Items -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6"
             x-data="{
                lightbox: false, lightboxImg: '', lightboxTitle: '', lightboxVideo: '', lightboxType: 'photo',
                openLb(type, src, title) {
                    this.lightboxType = type;
                    if (type === 'photo') { this.lightboxImg = src; this.lightboxVideo = ''; }
                    else { this.lightboxVideo = src; this.lightboxImg = ''; }
                    this.lightboxTitle = title;
                    this.lightbox = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLb() { this.lightbox = false; this.lightboxVideo = ''; document.body.style.overflow = ''; }
             }">
            @foreach($recentGalleries as $gallery)
            <div class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer"
                 @click="openLb('{{ $gallery->type }}', '{{ $gallery->type === 'photo' ? asset('storage/' . $gallery->file_path) : $gallery->youtube_embed_url }}', '{{ addslashes($gallery->title) }}')">
                <div class="aspect-square overflow-hidden">
                    @if($gallery->type === 'photo' && $gallery->file_path)
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                    @elseif($gallery->display_thumbnail)
                        <img src="{{ $gallery->display_thumbnail }}" alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Overlay on Hover -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-500 flex items-center justify-center">
                        @if($gallery->type === 'video')
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-7 h-7 text-red-600 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                        @else
                        <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Type Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-bold rounded-full backdrop-blur-sm {{ $gallery->type === 'photo' ? 'bg-blue-500/80 text-white' : 'bg-red-500/80 text-white' }}">
                            {{ $gallery->type === 'photo' ? '📷' : '🎬' }}
                        </span>
                    </div>

                    <!-- Album Badge -->
                    @if($gallery->album)
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-black/40 text-white backdrop-blur-sm">{{ $gallery->album->name }}</span>
                    </div>
                    @endif
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                    <h4 class="font-bold text-white text-sm truncate">{{ $gallery->title }}</h4>
                </div>
            </div>
            @endforeach

            <!-- Lightbox -->
            <div x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 @click="closeLb()" @keydown.escape.window="closeLb()"
                 class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
                <button @click="closeLb()" class="absolute top-4 right-4 z-50 p-2 bg-white/10 hover:bg-white/20 rounded-full text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div @click.stop class="max-w-5xl w-full max-h-[90vh] flex flex-col items-center">
                    <template x-if="lightboxType === 'photo'">
                        <img :src="lightboxImg" :alt="lightboxTitle" class="max-h-[80vh] max-w-full object-contain rounded-lg shadow-2xl">
                    </template>
                    <template x-if="lightboxType === 'video'">
                        <div class="w-full aspect-video rounded-lg overflow-hidden shadow-2xl bg-black">
                            <iframe :src="lightboxVideo + '?autoplay=1'" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </template>
                    <h3 class="mt-4 text-xl font-bold text-white" x-text="lightboxTitle" x-show="lightboxTitle"></h3>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('gallery') }}" class="inline-flex items-center px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                Lihat Semua Galeri
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Social Media Section -->
<section class="py-16 bg-gradient-to-r from-orange-500 to-orange-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">Ikuti Kami</h2>
            <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
                Dapatkan update terbaru, promo spesial, dan konten eksklusif di media sosial kami
            </p>
            
            @php
                $facebookUrl = \App\Models\Setting::get('facebook_url', '');
                $twitterUrl = \App\Models\Setting::get('twitter_url', '');
                $instagramUrl = \App\Models\Setting::get('instagram_url', '');
                $youtubeUrl = \App\Models\Setting::get('youtube_url', '');
                $linkedinUrl = \App\Models\Setting::get('linkedin_url', '');
            @endphp
            
            <div class="flex justify-center items-center gap-4 flex-wrap">
                @if($facebookUrl)
                <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" 
                   class="w-16 h-16 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-110 hover:-translate-y-1">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                @endif
                
                @if($twitterUrl)
                <a href="{{ $twitterUrl }}" target="_blank" rel="noopener" 
                   class="w-16 h-16 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-110 hover:-translate-y-1">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
                @endif
                
                @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" 
                   class="w-16 h-16 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-110 hover:-translate-y-1">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                @endif
                
                @if($youtubeUrl)
                <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener" 
                   class="w-16 h-16 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-110 hover:-translate-y-1">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
                @endif
                
                @if($linkedinUrl)
                <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener" 
                   class="w-16 h-16 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-110 hover:-translate-y-1">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                @endif
                
                @if(!$facebookUrl && !$twitterUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
                <p class="text-white/80 text-sm">Silakan atur link media sosial di halaman pengaturan admin</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection