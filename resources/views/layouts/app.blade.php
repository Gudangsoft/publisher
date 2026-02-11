<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @php
        $siteName = \App\Models\Setting::get('site_name', 'Publisher');
        $siteTagline = \App\Models\Setting::get('site_tagline', 'Penerbit Buku Berkualitas');
        $siteLogo = \App\Models\Setting::get('site_logo', '');
        $siteFavicon = \App\Models\Setting::get('site_favicon', '');
        $metaDescription = \App\Models\Setting::get('meta_description', 'Publisher buku terpercaya dengan koleksi buku berkualitas untuk semua kalangan');
        $metaKeywords = \App\Models\Setting::get('meta_keywords', '');
        $googleAnalytics = \App\Models\Setting::get('google_analytics', '');
    @endphp
    
    <title>@yield('title', $siteName . ' - ' . $siteTagline)</title>
    <meta name="description" content="@yield('meta_description', $metaDescription)">
    @if($metaKeywords)
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    
    <!-- Favicon -->
    @if($siteFavicon)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteFavicon) }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteFavicon) }}?v={{ time() }}">
    @elseif($siteLogo)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteLogo) }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteLogo) }}?v={{ time() }}">
    @else
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ee6d26'%3E%3Cpath d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'/%3E%3C/svg%3E">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fef6ee',
                            100: '#fdebd8',
                            200: '#fad4b0',
                            300: '#f6b67d',
                            400: '#f18d49',
                            500: '#ee6d26',
                            600: '#df521c',
                            700: '#b93d19',
                            800: '#93321d',
                            900: '#762b19',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @if($googleAnalytics)
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytics }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleAnalytics }}');
    </script>
    @endif
    
    <!-- Custom Styles -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    
    <!-- Header/Navigation -->
    <header class="fixed w-full top-0 z-50 bg-white shadow-sm border-b border-gray-100 transition-all duration-300">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        @if($siteLogo)
                        <div class="h-16 rounded-lg overflow-hidden shadow-lg group-hover:scale-105 transition-transform duration-200">
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-full w-auto object-contain">
                        </div>
                        @else
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-2.5 rounded-lg shadow-lg group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <span class="text-2xl font-display font-bold text-gray-900">{{ $siteName }}</span>
                            <p class="text-xs text-gray-500 -mt-1">{{ $siteTagline }}</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="/" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Beranda
                    </a>
                    <a href="/books" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Katalog Buku
                    </a>
                    
                    <!-- Kategori Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium flex items-center space-x-1">
                            <span>Kategori</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Buku</div>
                            @foreach(\App\Models\Category::where('type', 'book')->orderBy('name')->get() as $category)
                            <a href="/books?category={{ $category->id }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-150">
                                {{ $category->name }}
                            </a>
                            @endforeach
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Berita</div>
                            @foreach(\App\Models\Category::where('type', 'news')->orderBy('name')->get() as $category)
                            <a href="/news?category={{ $category->id }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-150">
                                {{ $category->name }}
                            </a>
                            @endforeach
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Journal</div>
                            @foreach(\App\Models\Category::where('type', 'journal')->orderBy('name')->get() as $category)
                            <a href="/journals?category={{ $category->id }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-150">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <a href="/news" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Berita
                    </a>
                    <a href="/journals" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Jurnal
                    </a>
                    <a href="/authors" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Penulis
                    </a>
                    <a href="/about" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Tentang Kami
                    </a>
                    <a href="/contact" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                        Kontak
                    </a>
                </div>

                <!-- Right Side Menu -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- Search Button -->
                    <button @click="searchOpen = !searchOpen" class="p-2 rounded-lg text-gray-600 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    @auth
                        <a href="/admin" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors duration-200">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="lg:hidden pb-4 border-t border-gray-100 mt-2">
                <div class="space-y-1 pt-2">
                    <a href="/" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Beranda</a>
                    <a href="/books" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Katalog Buku</a>
                    
                    <!-- Kategori Mobile Menu -->
                    <div x-data="{ categoryOpen: false }">
                        <button @click="categoryOpen = !categoryOpen" class="w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium flex items-center justify-between">
                            <span>Kategori</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': categoryOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="categoryOpen" x-transition class="pl-4 space-y-1 mt-1">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Buku</div>
                            @foreach(\App\Models\Category::where('type', 'book')->orderBy('name')->get() as $category)
                            <a href="/books?category={{ $category->id }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg">
                                {{ $category->name }}
                            </a>
                            @endforeach
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-2">Kategori Berita</div>
                            @foreach(\App\Models\Category::where('type', 'news')->orderBy('name')->get() as $category)
                            <a href="/news?category={{ $category->id }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg">
                                {{ $category->name }}
                            </a>
                            @endforeach
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-2">Kategori Journal</div>
                            @foreach(\App\Models\Category::where('type', 'journal')->orderBy('name')->get() as $category)
                            <a href="/journals?category={{ $category->id }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <a href="/news" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Berita</a>
                    <a href="/journals" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Jurnal</a>
                    <a href="/authors" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Penulis</a>
                    <a href="/about" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Tentang Kami</a>
                    <a href="/contact" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Kontak</a>
                    @auth
                        <a href="/admin" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block mx-4 mt-2 px-4 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg font-medium text-center">Login</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Search Modal -->
        <div x-show="searchOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click.away="searchOpen = false"
             class="absolute top-full left-0 right-0 bg-white border-t border-gray-200 shadow-lg">
            <div class="max-w-3xl mx-auto p-6">
                <form action="/books" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari judul buku, penulis, atau ISBN..." 
                           class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200" 
                           autofocus>
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-20">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-sm animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-sm animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        @if($siteLogo)
                        <div class="h-14 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-full w-auto object-contain">
                        </div>
                        @else
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-2.5 rounded-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        @endif
                        <span class="text-2xl font-display font-bold text-white">{{ $siteName }}</span>
                    </div>
                    <p class="text-white mb-6 max-w-md leading-relaxed">
                        {{ \App\Models\Setting::get('site_description', 'Penerbit buku terpercaya yang berkomitmen menyediakan bacaan berkualitas untuk mencerdaskan bangsa.') }}
                    </p>
                    @php
                        $facebookUrl = \App\Models\Setting::get('facebook_url', '');
                        $twitterUrl = \App\Models\Setting::get('twitter_url', '');
                        $instagramUrl = \App\Models\Setting::get('instagram_url', '');
                        $youtubeUrl = \App\Models\Setting::get('youtube_url', '');
                        $linkedinUrl = \App\Models\Setting::get('linkedin_url', '');
                    @endphp
                    <div class="flex space-x-4">
                        @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-800 hover:bg-blue-600 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if($twitterUrl)
                        <a href="{{ $twitterUrl }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-800 hover:bg-sky-500 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        @endif
                        @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-800 hover:bg-pink-600 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                        @endif
                        @if($youtubeUrl)
                        <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-800 hover:bg-red-600 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        @endif
                        @if($linkedinUrl)
                        <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-800 hover:bg-blue-700 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold text-lg mb-6">Menu Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Beranda</a></li>
                        <li><a href="/books" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Katalog Buku</a></li>
                        <li><a href="/news" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Berita</a></li>
                        <li><a href="/journals" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Jurnal</a></li>
                        <li><a href="/authors" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Penulis</a></li>
                        <li><a href="/about" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Tentang Kami</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-white font-semibold text-lg mb-6">Kontak Kami</h3>
                    <ul class="space-y-3 text-white">
                        @php
                            $contactEmail = \App\Models\Setting::get('contact_email', 'info@publisher.com');
                            $contactPhone = \App\Models\Setting::get('contact_phone', '+62 21 1234 5678');
                            $contactAddress = \App\Models\Setting::get('contact_address', 'Jl. Contoh No. 123, Jakarta, Indonesia');
                        @endphp
                        @if($contactAddress)
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{!! nl2br(e($contactAddress)) !!}</span>
                        </li>
                        @endif
                        @endphp
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $contactEmail }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $contactPhone }}</span>
                        </li>
                        @if($contactAddress)
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $contactAddress }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Publisher') }}. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="{{ route('pages.show', 'privacy-policy') }}" class="hover:text-primary-400 transition-colors duration-200">Privacy Policy</a>
                        <a href="{{ route('pages.show', 'terms-of-service') }}" class="hover:text-primary-400 transition-colors duration-200">Terms of Service</a>
                        <a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors duration-200">About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button x-data="{ show: false }" 
            @scroll.window="show = window.pageYOffset > 300"
            x-show="show"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed bottom-8 right-8 bg-primary-500 hover:bg-primary-600 text-white p-3 rounded-full shadow-lg transition-all duration-200 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
</body>
</html>
