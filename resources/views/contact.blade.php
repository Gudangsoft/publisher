@extends('layouts.app')

@section('title', 'Kontak Kami - Publisher')
@section('meta_description', 'Hubungi kami untuk pertanyaan, kerja sama, atau informasi lebih lanjut tentang Publisher.')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-primary-50 to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-display font-bold text-gray-900 mb-4">Hubungi Kami</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui form atau informasi kontak di bawah ini
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                <h2 class="text-3xl font-display font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                <form action="/contact" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200"
                                   placeholder="Nama Anda">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200"
                                   placeholder="email@example.com">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200"
                                   placeholder="+62 812 3456 7890">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subjek *</label>
                            <select id="subject" name="subject" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200 bg-white">
                                <option value="">Pilih Subjek</option>
                                <option value="general">Pertanyaan Umum</option>
                                <option value="order">Pesanan Buku</option>
                                <option value="author">Kerja Sama Penulis</option>
                                <option value="distributor">Kerja Sama Distributor</option>
                                <option value="feedback">Kritik & Saran</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Pesan *</label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none transition-colors duration-200 resize-none"
                                  placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="privacy" name="privacy" required
                               class="mt-1 mr-3 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <label for="privacy" class="text-sm text-gray-600">
                            Saya setuju dengan <a href="#" class="text-primary-600 hover:text-primary-700 font-semibold">kebijakan privasi</a> dan penggunaan data saya untuk keperluan komunikasi.
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-display font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Kami senang mendengar dari Anda! Tim kami akan merespons pertanyaan Anda dalam 1-2 hari kerja.
                    </p>
                </div>

                <!-- Contact Cards -->
                <div class="space-y-4">
                    <!-- Address -->
                    <div class="flex items-start space-x-4 bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-colors duration-200">
                        <div class="bg-primary-100 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Alamat Kantor</h3>
                            <p class="text-gray-600">
                                Jl. Contoh No. 123<br>
                                Jakarta Pusat, DKI Jakarta 10110<br>
                                Indonesia
                            </p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start space-x-4 bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-colors duration-200">
                        <div class="bg-primary-100 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">
                                <a href="mailto:info@publisher.com" class="text-primary-600 hover:text-primary-700">info@publisher.com</a><br>
                                <a href="mailto:support@publisher.com" class="text-primary-600 hover:text-primary-700">support@publisher.com</a>
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start space-x-4 bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-colors duration-200">
                        <div class="bg-primary-100 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600">
                                <a href="tel:+622112345678" class="text-primary-600 hover:text-primary-700">+62 21 1234 5678</a> (Kantor)<br>
                                <a href="tel:+6281234567890" class="text-primary-600 hover:text-primary-700">+62 812 3456 7890</a> (WhatsApp)
                            </p>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="flex items-start space-x-4 bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-colors duration-200">
                        <div class="bg-primary-100 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Jam Operasional</h3>
                            <p class="text-gray-600">
                                Senin - Jumat: 09:00 - 17:00 WIB<br>
                                Sabtu: 09:00 - 13:00 WIB<br>
                                Minggu & Libur: Tutup
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Ikuti Kami</h3>
                    <p class="text-primary-100 mb-6">
                        Dapatkan update terbaru, promo spesial, dan konten eksklusif di media sosial kami
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
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($twitterUrl)
                        <a href="{{ $twitterUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($youtubeUrl)
                        <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($linkedinUrl)
                        <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-bold text-gray-900 mb-8 text-center">Lokasi Kami</h2>
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="aspect-[21/9] bg-gray-200">
                <!-- Replace with actual Google Maps embed -->
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666667!2d106.816666!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDknMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-full">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-display font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
            <p class="text-xl text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
        </div>

        <div x-data="{ activeAccordion: null }" class="space-y-4">
            @php
            $faqs = [
                ['q' => 'Bagaimana cara memesan buku?', 'a' => 'Anda dapat memesan buku melalui website kami dengan menambahkan buku ke keranjang dan melakukan checkout. Kami juga menerima pesanan melalui WhatsApp dan email.'],
                ['q' => 'Berapa lama waktu pengiriman?', 'a' => 'Untuk wilayah Jakarta dan sekitarnya, pengiriman memakan waktu 1-2 hari kerja. Untuk luar Jakarta, estimasi pengiriman adalah 3-5 hari kerja tergantung lokasi.'],
                ['q' => 'Apakah tersedia layanan COD?', 'a' => 'Ya, kami menyediakan layanan Cash on Delivery (COD) untuk wilayah tertentu. Silakan hubungi customer service kami untuk informasi lebih lanjut.'],
                ['q' => 'Bagaimana cara menjadi penulis di Publisher?', 'a' => 'Kami selalu terbuka untuk penulis baru! Silakan kirim proposal naskah Anda beserta sinopsis ke email submission@publisher.com. Tim kami akan meninjau dan menghubungi Anda dalam 2-4 minggu.'],
                ['q' => 'Apakah buku bisa diretur?', 'a' => 'Buku dapat diretur dalam kondisi tertentu seperti kerusakan fisik atau kesalahan pengiriman. Harap laporkan dalam 3 hari setelah penerimaan barang untuk proses retur.'],
            ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="bg-gray-50 rounded-xl overflow-hidden">
                <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                        class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-100 transition-colors duration-200">
                    <span class="font-bold text-gray-900 text-lg pr-4">{{ $faq['q'] }}</span>
                    <svg x-show="activeAccordion !== {{ $index }}" class="w-6 h-6 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <svg x-show="activeAccordion === {{ $index }}" class="w-6 h-6 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>
                <div x-show="activeAccordion === {{ $index }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="px-6 pb-6">
                    <p class="text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4">Tidak menemukan jawaban yang Anda cari?</p>
            <a href="#contact-form" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                Hubungi Kami Sekarang
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
