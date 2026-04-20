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
        $metaDescription = \App\Models\Setting::get('meta_description', 'Penerbit Primeintellecta - Publisher buku terpercaya dengan koleksi buku berkualitas untuk semua kalangan');
        $metaKeywords = \App\Models\Setting::get('meta_keywords', 'penerbit primeintellecta, primeintellecta publisher, penerbit buku, buku berkualitas, toko buku online');
        $googleAnalytics = \App\Models\Setting::get('google_analytics', '');
        $themeConfig = \App\Http\Controllers\Admin\ThemeController::getThemeConfig();
        
        // Fetch dynamic menus from database
        $headerMenus = \App\Models\Menu::whereNull('parent_id')
            ->where('is_active', true)
            ->whereIn('location', ['header', 'both'])
            ->orderBy('display_order')
            ->with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('display_order');
            }])
            ->get();
        
        // Check if logo file exists
        $logoExists = $siteLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($siteLogo);
    @endphp
    
    <title>@yield('title', $siteName . ' - ' . $siteTagline)</title>
    <meta name="description" content="@yield('meta_description', $metaDescription)">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="author" content="{{ $siteName }}">
    
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
    <link href="https://fonts.googleapis.com/css2?family={{ $themeConfig['font']['url'] }}@if($themeConfig['displayFont']['url'])&family={{ $themeConfig['displayFont']['url'] }}@endif&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['{{ $themeConfig['font']['family'] }}', 'sans-serif'],
                        display: ['{{ $themeConfig['displayFont']['family'] ?: $themeConfig['font']['family'] }}', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '{{ $themeConfig['color']['shades'][50] }}',
                            100: '{{ $themeConfig['color']['shades'][100] }}',
                            200: '{{ $themeConfig['color']['shades'][200] }}',
                            300: '{{ $themeConfig['color']['shades'][300] }}',
                            400: '{{ $themeConfig['color']['shades'][400] }}',
                            500: '{{ $themeConfig['color']['shades'][500] }}',
                            600: '{{ $themeConfig['color']['shades'][600] }}',
                            700: '{{ $themeConfig['color']['shades'][700] }}',
                            800: '{{ $themeConfig['color']['shades'][800] }}',
                            900: '{{ $themeConfig['color']['shades'][900] }}',
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
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($googleAnalytics) }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ e($googleAnalytics) }}');
    </script>
    @endif
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
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
        
        /* Modern Navigation Styles */
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--tw-gradient-from), var(--tw-gradient-to));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::before {
            width: 80%;
        }
        .nav-link.active::before {
            width: 80%;
        }
        
        /* Glassmorphism effect */
        .glass-nav {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.85);
        }
        .glass-nav.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Mega Menu Animation */
        .mega-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mega-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Pulse animation for CTA */
        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(238, 109, 38, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(238, 109, 38, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(238, 109, 38, 0); }
        }
        .cta-pulse {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        
        /* Icon hover effect */
        .icon-hover {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .icon-hover:hover {
            transform: scale(1.1) rotate(5deg);
        }
        
        /* Category card hover */
        .category-card {
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>

    @if($themeConfig['customCss'])
    <style>
        {!! $themeConfig['customCss'] !!}
    </style>
    @endif
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false, megaMenuOpen: false }">
    
    <!-- Header/Navigation -->
    <header class="fixed w-full top-0 z-50 glass-nav border-b border-gray-100/50 transition-all duration-500" 
            x-data="{ scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 50)"
            :class="{ 'scrolled': scrolled }">
        
        <!-- Top Bar (optional promotional bar) -->
        <div class="bg-gradient-to-r from-primary-600 via-primary-500 to-primary-600 text-white text-center py-2 text-sm font-medium">
            <span class="inline-flex items-center gap-2">
                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Selamat datang di {{ $siteName }} — Penerbit Buku Terpercaya
                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </span>
        </div>
        
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        @if($logoExists)
                        <div class="h-12 w-auto flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('storage/' . $siteLogo) }}?v={{ time() }}" alt="{{ $siteName }}" class="h-full w-auto object-contain">
                        </div>
                        @else
                        <div class="relative flex-shrink-0">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl blur-lg opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative bg-gradient-to-br from-primary-500 to-primary-700 p-2.5 rounded-xl shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-base sm:text-lg font-bold text-gray-800 leading-tight tracking-tight group-hover:text-primary-600 transition-colors duration-300">{{ $siteName }}</span>
                            @if($siteTagline)
                            <span class="text-[10px] sm:text-xs text-gray-500 font-medium tracking-wider uppercase">{{ $siteTagline }}</span>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation - Dynamic Menus -->
                <div class="hidden lg:flex items-center space-x-1">
                    @foreach($headerMenus as $menu)
                        @if($menu->children->count() > 0)
                        <!-- Menu with Submenu -->
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="nav-link px-4 py-2 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-gradient-to-r hover:from-primary-50 hover:to-transparent transition-all duration-300 font-medium flex items-center gap-2 group">
                                @if($menu->icon)
                                <span class="text-sm">{{ $menu->icon }}</span>
                                @endif
                                <span>{{ $menu->label }}</span>
                                <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                @foreach($menu->children as $child)
                                <a href="{{ $child->url }}" target="{{ $child->target ?? '_self' }}" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    @if($child->icon)
                                    <span>{{ $child->icon }}</span>
                                    @else
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    @endif
                                    {{ $child->label }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <!-- Single Menu Item -->
                        <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" class="nav-link px-4 py-2 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-gradient-to-r hover:from-primary-50 hover:to-transparent transition-all duration-300 font-medium flex items-center gap-2 group {{ request()->is(ltrim($menu->url, '/') . '*') ? 'text-primary-600 bg-primary-50' : '' }}">
                            @if($menu->icon)
                            <span class="text-sm">{{ $menu->icon }}</span>
                            @endif
                            {{ $menu->label }}
                        </a>
                        @endif
                    @endforeach
                    
                    <!-- Ajukan Naskah Menu -->
                    <a href="/submissions/create" class="nav-link px-4 py-2 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-gradient-to-r hover:from-primary-50 hover:to-transparent transition-all duration-300 font-medium flex items-center gap-2 group {{ request()->is('submissions*') ? 'text-primary-600 bg-primary-50' : '' }}">
                        <span class="text-sm">✍️</span>
                        Ajukan Naskah
                    </a>
                </div>

                <!-- Right Side Menu -->
                <div class="hidden lg:flex items-center space-x-3">
                    <!-- Search Button -->
                    <button @click="searchOpen = !searchOpen" class="p-3 rounded-xl text-gray-600 hover:text-primary-600 hover:bg-primary-50 transition-all duration-300 icon-hover">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    @auth
                        @if(auth()->user()->is_admin)
                        <a href="/admin" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 hover:from-primary-100 hover:to-primary-50 hover:text-primary-700 transition-all duration-300 font-medium shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                            Dashboard
                        </a>
                        @else
                        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 hover:from-primary-100 hover:to-primary-50 hover:text-primary-700 transition-all duration-300 font-medium shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Dashboard Saya
                        </a>
                        @endif
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="/submissions/create" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Ajukan Naskah Baru
                                </a>
                                <a href="/submissions/track" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Lacak Pengajuan
                                </a>
                                <hr class="my-2 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-all duration-300 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gray-900 to-gray-700 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2.5 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
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
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="lg:hidden pb-6 border-t border-gray-100 mt-2 bg-white/95 backdrop-blur-lg">
                <div class="space-y-1 pt-4 px-2">
                    <!-- Dynamic Mobile Menu -->
                    @foreach($headerMenus as $menu)
                        @if($menu->children->count() > 0)
                        <!-- Menu with Submenu -->
                        <div x-data="{ subOpen: false }">
                            <button @click="subOpen = !subOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium transition-all">
                                <div class="flex items-center gap-3">
                                    @if($menu->icon)
                                    <span class="text-lg">{{ $menu->icon }}</span>
                                    @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    @endif
                                    <span>{{ $menu->label }}</span>
                                </div>
                                <svg class="w-5 h-5 transition-transform duration-300" :class="{'rotate-180': subOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="subOpen" x-transition class="mt-2 ml-4 space-y-1 border-l-2 border-primary-200 pl-4">
                                @foreach($menu->children as $child)
                                <a href="{{ $child->url }}" target="{{ $child->target ?? '_self' }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors">
                                    @if($child->icon)<span class="mr-2">{{ $child->icon }}</span>@endif
                                    {{ $child->label }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <!-- Single Menu Item -->
                        <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium transition-all {{ request()->is(ltrim($menu->url, '/') . '*') ? 'bg-primary-50 text-primary-600' : '' }}">
                            @if($menu->icon)
                            <span class="text-lg">{{ $menu->icon }}</span>
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            @endif
                            {{ $menu->label }}
                        </a>
                        @endif
                    @endforeach
                    
                    <!-- Ajukan Naskah Mobile -->
                    <a href="/submissions/create" class="flex items-center gap-3 mx-2 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium transition-all {{ request()->is('submissions*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <span>✍️</span>
                        Ajukan Naskah
                    </a>
                    
                    @auth
                        <div class="mt-6 pt-4 border-t border-gray-200 mx-2">
                            <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            @if(auth()->user()->is_admin)
                            <a href="/admin" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                </svg>
                                Dashboard Admin
                            </a>
                            @else
                            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Dashboard Saya
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 font-medium transition-all mt-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-6 pt-4 border-t border-gray-200 mx-2 space-y-2">
                            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-gray-200 text-gray-700 hover:border-primary-500 hover:text-primary-600 rounded-xl font-semibold transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-xl font-semibold shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Daftar Akun
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Search Modal - Modern Design -->
        <div x-show="searchOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click.away="searchOpen = false"
             @keydown.escape.window="searchOpen = false"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-start justify-center pt-20 lg:pt-32">
            <div x-show="searchOpen"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 @click.stop
                 class="w-full max-w-2xl mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden">
                <form action="/books" method="GET">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari judul buku, penulis, atau ISBN..." 
                               class="w-full pl-14 pr-32 py-5 text-lg border-0 focus:ring-0 focus:outline-none" 
                               x-ref="searchInput"
                               x-init="$watch('searchOpen', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 100) })"
                               autofocus>
                        <div class="absolute inset-y-0 right-0 flex items-center gap-2 pr-3">
                            <button type="button" @click="searchOpen = false" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                <kbd class="px-2 py-1 text-xs bg-gray-100 rounded-md">ESC</kbd>
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
                <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-3">Pencarian Populer:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="/books?search=novel" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-sm text-gray-600 hover:border-primary-400 hover:text-primary-600 transition-colors">Novel</a>
                        <a href="/books?search=pendidikan" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-sm text-gray-600 hover:border-primary-400 hover:text-primary-600 transition-colors">Pendidikan</a>
                        <a href="/books?search=bisnis" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-sm text-gray-600 hover:border-primary-400 hover:text-primary-600 transition-colors">Bisnis</a>
                        <a href="/books?search=teknologi" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-sm text-gray-600 hover:border-primary-400 hover:text-primary-600 transition-colors">Teknologi</a>
                        <a href="/books?search=sejarah" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-sm text-gray-600 hover:border-primary-400 hover:text-primary-600 transition-colors">Sejarah</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-32 lg:pt-28">
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

        @if(session('admin_user_id'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Anda sedang login sebagai <strong>{{ auth()->user()->name }}</strong></span>
                        </div>
                        <form method="POST" action="{{ route('admin.users.switch-back') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200 text-sm font-medium">
                                Kembali ke Admin
                            </button>
                        </form>
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
                        <div class="h-12 flex-shrink-0 bg-white rounded-lg p-1.5">
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-full w-auto object-contain">
                        </div>
                        @else
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-2.5 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-white leading-tight">{{ $siteName }}</span>
                            @if($siteTagline)
                            <span class="text-xs text-gray-400 tracking-wider uppercase">{{ $siteTagline }}</span>
                            @endif
                        </div>
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
                        <li><a href="/gallery" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Galeri</a></li>
                        <li><a href="/authors" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Penulis</a></li>
                        <li><a href="/submissions/create" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Ajukan Naskah</a></li>
                        <li><a href="/submissions/track" class="text-gray-400 hover:text-primary-400 transition-colors duration-200">Lacak Pengajuan</a></li>
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
