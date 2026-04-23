@extends('layouts.app')

@section('title', 'Menu - Navigasi Website')
@section('meta_description', 'Jelajahi menu navigasi website kami untuk menemukan berbagai konten dan halaman.')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-primary-50 via-white to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
                Menu <span class="text-gradient">Website</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Jelajahi navigasi lengkap untuk menemukan semua konten dan halaman di website kami
            </p>
        </div>
    </div>
</section>

<!-- Menu Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($menus->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($menus as $menu)
            <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-primary-500 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start space-x-4">
                    @if($menu->icon)
                    <div class="flex-shrink-0 text-4xl group-hover:scale-110 transition-transform duration-300">
                        {{ $menu->icon }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            @if($menu->url)
                            <a href="{{ $menu->url }}" 
                               @if($menu->target === '_blank') target="_blank" rel="noopener noreferrer" @endif
                               class="hover:underline">
                                {{ $menu->name }}
                            </a>
                            @else
                            {{ $menu->name }}
                            @endif
                        </h3>
                        
                        @if($menu->description)
                        <p class="text-gray-600 text-sm mb-4">{{ $menu->description }}</p>
                        @endif

                        <!-- Sub Menu Items -->
                        @if($menu->children->count() > 0)
                        <ul class="space-y-2 mt-4 border-t pt-4">
                            @foreach($menu->children as $child)
                            <li>
                                <a href="{{ $child->url }}" 
                                   @if($child->target === '_blank') target="_blank" rel="noopener noreferrer" @endif
                                   class="flex items-center text-gray-700 hover:text-primary-600 transition-colors group/child">
                                    @if($child->icon)
                                    <span class="mr-2">{{ $child->icon }}</span>
                                    @else
                                    <svg class="w-4 h-4 mr-2 text-gray-400 group-hover/child:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    @endif
                                    <span class="group-hover/child:underline">{{ $child->name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        @if($menu->url)
                        <div class="mt-4">
                            <a href="{{ $menu->url }}" 
                               @if($menu->target === '_blank') target="_blank" rel="noopener noreferrer" @endif
                               class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm group-hover:gap-2 transition-all">
                                Kunjungi
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Location Badge -->
                @if($menu->location)
                <div class="mt-4 pt-4 border-t">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        {{ $menu->location === 'header' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $menu->location === 'footer' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $menu->location === 'both' ? 'bg-purple-100 text-purple-800' : '' }}">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        {{ ucfirst($menu->location) }}
                    </span>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Menu</h3>
            <p class="text-gray-600">Menu belum tersedia saat ini.</p>
        </div>
        @endif
    </div>
</section>

<!-- Quick Links Section -->
<section class="py-16 bg-gradient-to-br from-primary-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Link Cepat</h2>
            <p class="text-gray-600">Akses cepat ke halaman-halaman utama</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="/books" class="bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📚</div>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600">Buku</h3>
            </a>
            
            <a href="/news" class="bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📰</div>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600">Berita</h3>
            </a>
            
            <a href="/journals" class="bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📖</div>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600">Jurnal</h3>
            </a>
            
            <a href="/about" class="bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">ℹ️</div>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600">Tentang</h3>
            </a>
        </div>
    </div>
</section>
@endsection
