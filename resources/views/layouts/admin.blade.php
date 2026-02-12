<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Publisher</title>
    
    <!-- Favicon -->
    @php
        $siteFavicon = \App\Models\Setting::get('site_favicon', '');
        $siteLogo = \App\Models\Setting::get('site_logo', '');
    @endphp
    @if($siteFavicon)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteFavicon) }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteFavicon) }}?v={{ time() }}">
    @elseif($siteLogo)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteLogo) }}?v={{ time() }}">
    @else
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ee6d26'%3E%3Cpath d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'/%3E%3C/svg%3E">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
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
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        .sidebar-transition {
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <!-- Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="hidden lg:inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    
                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="lg:hidden inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    
                    <!-- Logo -->
                    <a href="/admin" class="flex ml-2 md:mr-24">
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="self-center text-xl font-bold whitespace-nowrap ml-3 text-gray-900">Admin Publisher</span>
                    </a>
                </div>
                
                <!-- Right Side Menu -->
                <div class="flex items-center">
                    <!-- Search -->
                    <div class="hidden md:block mr-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." 
                                   class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Notifications -->
                    <button class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 relative mr-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- User Menu -->
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center text-sm bg-gray-100 rounded-lg p-2 hover:bg-gray-200 focus:ring-2 focus:ring-primary-500">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-2">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block font-medium text-gray-900">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 ml-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown -->
                        <div x-show="userMenuOpen" 
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200">
                            <a href="/" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Lihat Website
                            </a>
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pengaturan
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'" 
           class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 lg:translate-x-0">
        
        <!-- Mobile Overlay -->
        <div x-show="mobileMenuOpen" 
             @click="mobileMenuOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 lg:hidden"></div>
        
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                <!-- Dashboard -->
                <li>
                    <a href="/admin" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Dashboard</span>
                    </a>
                </li>

                <!-- Books Management -->
                <li>
                    <a href="/admin/books" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/books*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/books*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Manajemen Buku</span>
                    </a>
                </li>

                <!-- News Management -->
                <li>
                    <a href="/admin/news" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/news*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/news*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Manajemen Berita</span>
                    </a>
                </li>

                <!-- Journal Management -->
                <li>
                    <a href="/admin/journals" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/journals*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/journals*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Manajemen Jurnal</span>
                    </a>
                </li>

                <!-- Hero Slider Management -->
                <li>
                    <a href="{{ route('admin.hero-sliders.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/hero-sliders*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/hero-sliders*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Hero Slider</span>
                    </a>
                </li>

                <!-- Statistics Management -->
                <li>
                    <a href="{{ route('admin.statistics.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/statistics*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/statistics*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Statistik</span>
                    </a>
                </li>

                <!-- Menu Management -->
                <li>
                    <a href="{{ route('admin.menus.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/menus*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/menus*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Menu Website</span>
                    </a>
                </li>

                <!-- Pages Management -->
                <li>
                    <a href="{{ route('admin.pages.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/pages*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/pages*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Halaman</span>
                    </a>
                </li>

                <!-- Categories -->
                <li>
                    <a href="/admin/categories" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/categories*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/categories*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Kategori</span>
                    </a>
                </li>

                <!-- Authors -->
                <li>
                    <a href="/admin/authors" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/authors*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/authors*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Penulis</span>
                    </a>
                </li>

                <!-- Reviews -->
                <li>
                    <a href="/admin/reviews" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->is('admin/reviews*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('admin/reviews*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Ulasan</span>
                    </a>
                </li>

                <!-- Orders -->
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('admin.orders.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-primary-600 {{ request()->routeIs('admin.orders.*') ? 'text-primary-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Pesanan</span>
                        <span class="inline-flex items-center justify-center w-5 h-5 ml-auto text-xs font-semibold text-white bg-red-500 rounded-full">5</span>
                    </a>
                </li>

                <!-- Users -->
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-primary-600 {{ request()->routeIs('admin.users.*') ? 'text-primary-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Pengguna</span>
                    </a>
                </li>

                <li class="pt-4 mt-4 space-y-2 border-t border-gray-200">
                    <p :class="sidebarOpen ? 'px-3 text-xs font-semibold text-gray-500 uppercase' : 'lg:hidden px-3 text-xs font-semibold text-gray-500 uppercase'">
                        Pengaturan
                    </p>
                </li>

                <!-- Settings -->
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 text-primary-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-primary-600 {{ request()->routeIs('admin.settings.*') ? 'text-primary-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Pengaturan</span>
                    </a>
                </li>

                <!-- Theme & Layout -->
                <li>
                    <a href="{{ route('admin.theme.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('admin.theme.*') ? 'bg-primary-50 text-primary-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-primary-600 {{ request()->routeIs('admin.theme.*') ? 'text-primary-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Tema & Layout</span>
                    </a>
                </li>

                <!-- Reports -->
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('admin.reports.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-primary-600 {{ request()->routeIs('admin.reports.*') ? 'text-primary-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="sidebar-transition p-4 pt-24">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm animate-fade-in-up">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm animate-fade-in-up">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
