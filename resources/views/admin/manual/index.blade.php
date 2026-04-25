@extends('layouts.admin')

@section('title', 'Panduan Penggunaan Admin')

@section('content')
<div class="max-w-6xl mx-auto" x-data="{ activeSection: 'intro' }">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manual E-Book Admin</h1>
            <p class="text-gray-500 mt-1">Panduan lengkap mengelola sistem website Publisher.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Panduan
            </button>
            <div class="p-1.5 bg-primary-100 rounded-full">
                <div class="bg-primary-500 text-white p-2 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 sticky top-24 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Daftar Isi</h3>
                </div>
                <nav class="p-2 space-y-1">
                    <button @click="activeSection = 'intro'" :class="activeSection === 'intro' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Pendahuluan
                    </button>
                    <button @click="activeSection = 'dashboard'" :class="activeSection === 'dashboard' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </span>
                        Dashboard & Statistik
                    </button>
                    <button @click="activeSection = 'books'" :class="activeSection === 'books' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </span>
                        Manajemen Buku
                    </button>
                    <button @click="activeSection = 'orders'" :class="activeSection === 'orders' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </span>
                        Pesanan & Invoice
                    </button>
                    <button @click="activeSection = 'submissions'" :class="activeSection === 'submissions' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        Pengajuan Naskah
                    </button>
                    <button @click="activeSection = 'settings'" :class="activeSection === 'settings' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        </span>
                        Pengaturan Site
                    </button>
                    <button @click="activeSection = 'news'" :class="activeSection === 'news' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </span>
                        Manajemen Berita
                    </button>
                    <button @click="activeSection = 'users'" :class="activeSection === 'users' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        Manajemen Pengguna
                    </button>
                    <button @click="activeSection = 'gallery'" :class="activeSection === 'gallery' ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-3 py-2.5 text-sm rounded-xl transition-all">
                        <span class="w-6 flex justify-center mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        Galeri & Media
                    </button>
                </nav>
            </div>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Section: Introduction -->
                <div x-show="activeSection === 'intro'" class="p-8 md:p-12 animate-fade-in">
                    <div class="inline-flex items-center px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        👋 Selamat Datang
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Pendahuluan</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Manual ini dirancang untuk membantu Anda mengelola website Publisher dengan efisien. Melalui panel admin ini, Anda dapat mengontrol seluruh aspek konten, mulai dari buku, berita, hingga transaksi pelanggan.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Akses Cepat</h4>
                            <p class="text-gray-500 text-sm">Gunakan sidebar di sebelah kiri untuk berpindah antar modul dengan satu klik.</p>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Keamanan</h4>
                            <p class="text-gray-500 text-sm">Pastikan untuk selalu logout setelah selesai mengelola dashboard demi keamanan data.</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Dashboard -->
                <div x-show="activeSection === 'dashboard'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        📊 Ringkasan Data
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Dashboard & Statistik</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Dashboard adalah halaman utama yang memberikan ringkasan performa website Anda secara real-time.
                    </p>

                    <div class="space-y-6">
                        <div class="bg-white border-l-4 border-blue-500 p-6 rounded-r-2xl shadow-sm border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">Widget Statistik</h4>
                            <p class="text-gray-600 text-sm">Menampilkan jumlah total buku, pesanan baru, pengajuan naskah, dan pengguna terdaftar.</p>
                        </div>
                        <div class="bg-white border-l-4 border-primary-500 p-6 rounded-r-2xl shadow-sm border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">Grafik Penjualan</h4>
                            <p class="text-gray-600 text-sm">Visualisasi tren pendapatan dan jumlah pesanan dalam rentang waktu tertentu.</p>
                        </div>
                        <div class="bg-white border-l-4 border-green-500 p-6 rounded-r-2xl shadow-sm border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">Aktivitas Terbaru</h4>
                            <p class="text-gray-600 text-sm">Daftar transaksi atau interaksi terbaru yang memerlukan perhatian Anda.</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Books -->
                <div x-show="activeSection === 'books'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        📚 Katalog Produk
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Manajemen Buku</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Gunakan modul ini untuk mengelola katalog buku yang ditampilkan di website.
                    </p>

                    <div class="bg-gray-50 rounded-3xl p-8 mb-8 border border-gray-100">
                        <h4 class="text-xl font-bold text-gray-900 mb-6">Langkah Menambah Buku Baru:</h4>
                        <ol class="space-y-4">
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 shadow-md shadow-primary-200">1</span>
                                <div>
                                    <p class="font-bold text-gray-900">Klik "Tambah Buku"</p>
                                    <p class="text-gray-500 text-sm">Terletak di pojok kanan atas halaman daftar buku.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 shadow-md shadow-primary-200">2</span>
                                <div>
                                    <p class="font-bold text-gray-900">Isi Form Informasi</p>
                                    <p class="text-gray-500 text-sm">Lengkapi Judul, Penulis, ISBN, Deskripsi, dan Harga.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 shadow-md shadow-primary-200">3</span>
                                <div>
                                    <p class="font-bold text-gray-900">Upload Cover</p>
                                    <p class="text-gray-500 text-sm">Gunakan gambar dengan format JPG/PNG berkualitas tinggi untuk hasil terbaik.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 shadow-md shadow-primary-200">4</span>
                                <div>
                                    <p class="font-bold text-gray-900">Simpan</p>
                                    <p class="text-gray-500 text-sm">Klik tombol simpan dan buku akan otomatis muncul di website.</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Section: Orders -->
                <div x-show="activeSection === 'orders'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        💰 Transaksi
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Pesanan & Invoice</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Kelola pesanan pelanggan dan pantau status pembayaran di sini.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 border border-gray-100 rounded-2xl bg-white shadow-sm">
                            <h4 class="font-bold text-gray-900 mb-2">Verifikasi Pembayaran</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Cek bukti transfer yang dikirim pelanggan dan ubah status pesanan menjadi "Paid" atau "Selesai".</p>
                        </div>
                        <div class="p-6 border border-gray-100 rounded-2xl bg-white shadow-sm">
                            <h4 class="font-bold text-gray-900 mb-2">Cetak Invoice</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Anda dapat mendownload invoice berformat PDF untuk setiap transaksi yang berhasil.</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Submissions -->
                <div x-show="activeSection === 'submissions'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        ✍️ Redaksi
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Pengajuan Naskah</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Modul ini digunakan untuk mereview naskah-naskah yang dikirimkan oleh penulis melalui website.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 bg-yellow-500 text-white rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Review Naskah</h5>
                                <p class="text-gray-500 text-xs">Klik ikon mata untuk melihat detail naskah dan mendownload file lampiran.</p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 bg-green-500 text-white rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Update Status</h5>
                                <p class="text-gray-500 text-xs">Ubah status menjadi "Diterima", "Direvisi", atau "Ditolak" untuk memberitahu penulis.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Settings -->
                <div x-show="activeSection === 'settings'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        ⚙️ Konfigurasi
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Pengaturan Site</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Kendalikan identitas website Anda melalui menu pengaturan.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-1 text-sm">Informasi Umum</h4>
                            <p class="text-gray-500 text-xs">Ganti Nama Website, Email Kontak, No. Telp, dan Alamat Kantor.</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-1 text-sm">Logo & Favicon</h4>
                            <p class="text-gray-500 text-xs">Upload logo utama dan icon browser (favicon) di sini.</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-1 text-sm">Media Sosial</h4>
                            <p class="text-gray-500 text-xs">Tautkan link Facebook, Instagram, Twitter, dan YouTube Anda.</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-1 text-sm">SEO & Metadata</h4>
                            <p class="text-gray-500 text-xs">Atur deskripsi dan keyword website untuk optimasi mesin pencari (Google).</p>
                        </div>
                    </div>
                </div>

                <!-- Section: News -->
                <div x-show="activeSection === 'news'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        📰 Informasi
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Manajemen Berita</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Kelola konten berita, pengumuman, atau artikel blog untuk menginformasikan aktivitas terbaru kepada pengunjung.
                    </p>

                    <div class="space-y-4">
                        <div class="p-4 bg-white border border-gray-100 rounded-xl shadow-sm">
                            <h5 class="font-bold text-gray-900">Kategori Berita</h5>
                            <p class="text-gray-500 text-sm">Kelompokkan berita berdasarkan topik seperti "Kegiatan", "Pengumuman", atau "Tips Penulisan".</p>
                        </div>
                        <div class="p-4 bg-white border border-gray-100 rounded-xl shadow-sm">
                            <h5 class="font-bold text-gray-900">Publikasi Terjadwal</h5>
                            <p class="text-gray-500 text-sm">Anda dapat mengatur tanggal publikasi naskah agar otomatis muncul di website pada waktu yang ditentukan.</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Users -->
                <div x-show="activeSection === 'users'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        👥 Keanggotaan
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Manajemen Pengguna</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Kelola akun pengguna yang terdaftar di sistem, termasuk Admin, Penulis, dan Pelanggan.
                    </p>

                    <div class="bg-indigo-900 text-white p-6 rounded-2xl">
                        <h4 class="font-bold mb-4">Fitur Utama Pengguna:</h4>
                        <ul class="space-y-2 text-sm text-indigo-100">
                            <li>• <strong>Tambah Pengguna:</strong> Membuat akun baru secara manual.</li>
                            <li>• <strong>Login As:</strong> Masuk sebagai pengguna tertentu untuk membantu troubleshooting (Hanya untuk Admin Utama).</li>
                            <li>• <strong>Reset Password:</strong> Membantu pengguna yang lupa kata sandi.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section: Gallery -->
                <div x-show="activeSection === 'gallery'" class="p-8 md:p-12 animate-fade-in" x-cloak>
                    <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                        🖼️ Multimedia
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Galeri & Media</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Kelola dokumentasi foto dan video kegiatan di modul Galeri.
                    </p>

                    <div class="bg-primary-600 rounded-3xl p-8 text-white relative overflow-hidden">
                        <svg class="absolute right-[-20px] bottom-[-20px] w-48 h-48 text-primary-500 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                        <h4 class="text-xl font-bold mb-4 relative z-10">Tips Galeri:</h4>
                        <ul class="space-y-3 relative z-10">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Gunakan Album untuk mengelompokkan foto.
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Kompres gambar sebelum upload agar loading website cepat.
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Untuk video, Anda cukup memasukkan link YouTube/Vimeo.
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            
            <!-- Footer Content -->
            <div class="mt-8 text-center text-gray-400 text-sm">
                &copy; {{ date('Y') }} Admin Publisher System. Semua hak cipta dilindungi.
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out forwards;
    }
    
    @media print {
        .fixed, .sticky, nav, button {
            display: none !important;
        }
        .lg\:col-span-3 {
            width: 100% !important;
        }
        body {
            background: white !important;
        }
        [x-cloak] {
            display: block !important;
        }
    }
</style>
@endsection
