@extends('layouts.app')

@section('title', 'Daftar Akun - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<!-- Hero Section -->
<section class="relative py-12 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 font-display">
                Daftar Akun Penulis
            </h1>
            <p class="text-lg text-primary-100">
                Buat akun untuk mengajukan naskah dan melacak status pengajuan Anda
            </p>
        </div>
    </div>
</section>

<!-- Register Form Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <!-- Benefits -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-600">Ajukan Naskah</p>
                </div>
                <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-600">Lacak Status</p>
                </div>
                <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-600">Komunikasi Mudah</p>
                </div>
            </div>

            <!-- Register Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                    <p class="text-gray-600 mt-1">Isi data diri Anda untuk mendaftar</p>
                </div>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name') }}" required autofocus
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="email@contoh.com">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor Telepon
                            </label>
                            <input type="tel" name="phone" id="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">
                                Institusi
                            </label>
                            <input type="text" name="institution" id="institution" 
                                   value="{{ old('institution') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   placeholder="Universitas/Perusahaan">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               placeholder="Ulangi password Anda">
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mt-1">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            Saya menyetujui <a href="#" class="text-primary-600 hover:underline">Syarat & Ketentuan</a> 
                            dan <a href="#" class="text-primary-600 hover:underline">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-primary-600 text-white py-3 px-6 rounded-xl font-semibold hover:bg-primary-700 transition-colors focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-primary-600 hover:underline font-medium">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Alternative -->
            <div class="mt-6 text-center">
                <p class="text-gray-500 text-sm">
                    Atau ajukan naskah tanpa membuat akun? 
                    <a href="{{ route('submissions.create') }}" class="text-primary-600 hover:underline">
                        Klik di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
