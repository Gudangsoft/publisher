@extends('layouts.app')

@section('title', 'Tentang Kami - Publisher')
@section('meta_description', 'Kenali lebih dekat Publisher, penerbit buku terpercaya yang berkomitmen mencerdaskan bangsa melalui bacaan berkualitas.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-50 via-white to-purple-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-5xl lg:text-6xl font-display font-bold text-gray-900 mb-6 leading-tight">
                Tentang <span class="text-gradient">Publisher</span>
            </h1>
            <p class="text-xl text-gray-600 leading-relaxed">
                Lebih dari sekadar penerbit, kami adalah mitra Anda dalam perjalanan literasi dan pencerahan melalui buku berkualitas
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800&h=600&fit=crop&q=80" 
                     alt="Our Team" 
                     class="rounded-2xl shadow-2xl">
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-3xl font-display font-bold text-gray-900 mb-6">Visi & Misi Kami</h2>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-primary-100 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Visi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Menjadi penerbit terdepan yang menginspirasi dan mencerdaskan bangsa melalui karya-karya berkualitas tinggi yang menyentuh hati dan pikiran pembaca.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="bg-primary-100 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Misi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Menyediakan platform bagi penulis berbakat, menerbitkan buku berkualitas, dan membangun komunitas pembaca yang cerdas dan kritis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Perjalanan Kami</h2>
            <p class="text-xl text-gray-600">Dari mimpi kecil hingga menjadi penerbit terpercaya</p>
        </div>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-gray-700 leading-relaxed mb-6">
                Didirikan pada tahun 2010, Publisher berawal dari sebuah visi sederhana: membuat buku berkualitas dapat diakses oleh semua kalangan. Kami percaya bahwa setiap orang berhak mendapatkan akses ke pengetahuan dan cerita yang menginspirasi.
            </p>
            <p class="text-gray-700 leading-relaxed mb-6">
                Dalam perjalanan lebih dari satu dekade, kami telah menerbitkan lebih dari 1.000 judul buku dari berbagai genre, bekerja sama dengan 500+ penulis berbakat, dan menjangkau jutaan pembaca di seluruh Indonesia.
            </p>
            <p class="text-gray-700 leading-relaxed">
                Hari ini, kami bangga menjadi salah satu penerbit terkemuka yang terus berinovasi dalam industri penerbitan, sambil tetap mempertahankan nilai-nilai inti kami: kualitas, integritas, dan dedikasi terhadap dunia literasi.
            </p>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            @php
            $stats = [
                ['number' => '1000+', 'label' => 'Judul Buku', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['number' => '500+', 'label' => 'Penulis', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['number' => '50K+', 'label' => 'Pembaca', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['number' => '14+', 'label' => 'Tahun Pengalaman', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
            ];
            @endphp
            
            @foreach($stats as $stat)
            <div class="text-center">
                <div class="mb-4 flex justify-center">
                    <div class="bg-primary-500/20 p-4 rounded-xl">
                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <div class="text-5xl font-bold text-white mb-2">{{ $stat['number'] }}</div>
                <div class="text-gray-400 text-lg">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Nilai-Nilai Kami</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Prinsip yang memandu setiap langkah kami</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $values = [
                ['title' => 'Kualitas', 'desc' => 'Kami berkomitmen pada standar tertinggi dalam setiap buku yang kami terbitkan, dari konten hingga produksi.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'from-blue-500 to-blue-600'],
                ['title' => 'Integritas', 'desc' => 'Kejujuran dan transparansi dalam setiap hubungan dengan penulis, partner, dan pembaca adalah prioritas kami.', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'color' => 'from-green-500 to-green-600'],
                ['title' => 'Inovasi', 'desc' => 'Kami terus berinovasi dalam cara menyajikan konten dan menjangkau pembaca di era digital.', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'color' => 'from-purple-500 to-purple-600'],
                ['title' => 'Inklusivitas', 'desc' => 'Kami percaya buku untuk semua orang, dari berbagai latar belakang dan usia.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'from-pink-500 to-pink-600'],
                ['title' => 'Kolaborasi', 'desc' => 'Kami membangun kemitraan yang kuat dengan penulis, desainer, dan profesional lainnya.', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'from-yellow-500 to-yellow-600'],
                ['title' => 'Keberlanjutan', 'desc' => 'Kami peduli pada lingkungan dan menggunakan bahan ramah lingkungan dalam produksi buku.', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'from-green-500 to-emerald-600'],
            ];
            @endphp

            @foreach($values as $value)
            <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-br {{ $value['color'] }} w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $value['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-gradient-to-br from-primary-600 to-primary-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-display font-bold mb-6">Mari Bergabung dengan Kami</h2>
        <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto">
            Apakah Anda seorang penulis berbakat atau pembaca yang antusias? Kami ingin mendengar dari Anda!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/contact" class="px-8 py-4 bg-white hover:bg-gray-100 text-primary-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                Hubungi Kami
            </a>
            <a href="/books" class="px-8 py-4 border-2 border-white hover:bg-white hover:text-primary-600 text-white rounded-xl font-bold transition-all duration-200">
                Jelajahi Buku
            </a>
        </div>
    </div>
</section>
@endsection
