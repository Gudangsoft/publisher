<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    @php
        $siteFavicon = \App\Models\Setting::get('site_favicon', '');
        $siteLogo = \App\Models\Setting::get('site_logo', '');
        $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    @endphp

    @if($siteFavicon)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteFavicon) }}">
    @elseif($siteLogo)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteLogo) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#fef6ee', 100: '#fdebd8', 200: '#fad4b0',
                            300: '#f6b67d', 400: '#f18d49', 500: '#ee6d26',
                            600: '#df521c', 700: '#b93d19', 800: '#93321d', 900: '#762b19',
                        }
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Sidebar Toggle Desktop -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="hidden lg:inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"/>
                        </svg>
                    </button>
                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"/>
                        </svg>
                    </button>
                    <!-- Logo -->
                    <a href="{{ route('user.dashboard') }}" class="flex ml-2 items-center gap-3">
                        @if($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="h-8 w-auto object-contain">
                        @else
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        @endif
                        <span class="self-center text-lg font-bold whitespace-nowrap text-gray-900">{{ $siteName }}</span>
                    </a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-2">
                    <!-- Back to site -->
                    <a href="/" class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Ke Website
                    </a>

                    <!-- User Menu -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="flex items-center text-sm bg-gray-100 rounded-lg p-2 hover:bg-gray-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-2">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block font-medium text-gray-900">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 ml-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-500">Masuk sebagai</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="/" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Lihat Website
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
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
             x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 lg:hidden"></div>

        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-1 font-medium pt-2">

                <li>
                    <a href="{{ route('user.dashboard') }}"
                       class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('user.dashboard') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.dashboard') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.submissions') }}"
                       class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('user.submissions*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.submissions*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Submisi Saya</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.orders') }}"
                       class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-primary-50 group {{ request()->routeIs('user.orders*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.orders*') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'">Pesanan Saya</span>
                    </a>
                </li>

                <li class="pt-4 mt-2 border-t border-gray-100">
                    <a href="{{ route('submissions.create') }}"
                       class="flex items-center p-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span :class="sidebarOpen ? 'ml-3' : 'lg:hidden ml-3'" class="font-semibold text-sm">Ajukan Naskah</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="transition-all duration-300 p-4 pt-24">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
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
