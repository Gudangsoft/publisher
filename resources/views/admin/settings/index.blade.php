@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Pengaturan Sistem</h1>
    <p class="text-gray-600 mt-1">Kelola konfigurasi website dan sistem</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Settings Navigation -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ active: 'general' }">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">Menu Pengaturan</h3>
            </div>
            <nav class="p-2">
                <button @click="active = 'general'" :class="active === 'general' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors duration-200 mb-1">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="font-medium">Umum</span>
                </button>
                <button @click="active = 'email'" :class="active === 'email' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors duration-200 mb-1">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">Email</span>
                </button>
                <button @click="active = 'payment'" :class="active === 'payment' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors duration-200 mb-1">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span class="font-medium">Pembayaran</span>
                </button>
                <button @click="active = 'shipping'" :class="active === 'shipping' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors duration-200 mb-1">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                    <span class="font-medium">Pengiriman</span>
                </button>
                <button @click="active = 'seo'" :class="active === 'seo' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="font-medium">SEO</span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="{ active: 'general' }">
            <!-- General Settings -->
            <div x-show="active === 'general'">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Umum</h2>
                
                @if(session('success'))
                <div class="mb-4 p-4 text-green-800 bg-green-50 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('POST')
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Website</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Publisher Bookstore' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Your Ultimate Book Destination' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                        <textarea name="site_description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $settings['site_description'] ?? 'Toko buku online terlengkap dengan koleksi buku dari berbagai genre.' }}</textarea>
                    </div>
                    
                    <!-- Logo Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Logo & Branding</h3>
                        
                        <div class="space-y-6">
                            <!-- Logo Website -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>
                                <p class="text-xs text-gray-500 mb-3">Upload logo utama website (Rekomendasi: PNG/SVG dengan background transparan, maksimal 2MB)</p>
                                <input type="file" name="site_logo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @if(!empty($settings['site_logo']))
                                <div class="mt-4 p-6 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-xs font-medium text-gray-700 mb-3">Preview Logo:</p>
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="h-40 w-auto object-contain">
                                </div>
                                @endif
                            </div>
                            
                            <!-- Favicon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                                <p class="text-xs text-gray-500 mb-3">Upload favicon untuk browser tab (Rekomendasi: 32x32px atau 64x64px, format ICO/PNG)</p>
                                <input type="file" name="site_favicon" accept="image/*,.ico" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @if(!empty($settings['site_favicon']))
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-xs font-medium text-gray-700 mb-2">Preview Favicon:</p>
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" class="h-16 w-16 object-contain border border-gray-300 rounded">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'info@publisher.com' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+62 21 1234 5678' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="628xxxxxxxxxx" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="text-sm text-gray-500 mt-1">Format: 628xxxxxxxxxx (tanpa + atau 0)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="contact_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $settings['contact_address'] ?? 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10110' }}</textarea>
                    </div>
                    
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Media Sosial</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                                <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Twitter/X URL</label>
                                <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                                <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                                <input type="url" name="youtube_url" value="{{ $settings['youtube_url'] ?? '' }}" placeholder="https://youtube.com/channel/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}" placeholder="https://linkedin.com/company/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="toko buku, beli buku online, buku murah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea name="meta_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $settings['meta_description'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                                <input type="text" name="google_analytics" value="{{ $settings['google_analytics'] ?? '' }}" placeholder="G-XXXXXXXXXX atau UA-XXXXXXXXX-X" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-primary-600 text-white px-6 py-2.5 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Email Settings -->
            <div x-show="active === 'email'" x-cloak>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Email</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                        <input type="text" value="smtp.mailtrap.io" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                            <input type="text" value="587" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Enkripsi</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option>TLS</option>
                                <option>SSL</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-primary-600 text-white px-6 py-2.5 rounded-lg hover:bg-primary-700 transition-colors duration-200 mr-2">
                            Simpan Perubahan
                        </button>
                        <button type="button" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            Test Email
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Settings -->
            <div x-show="active === 'payment'" x-cloak>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Pembayaran</h2>
                <div class="space-y-6">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Bank Transfer</h3>
                                    <p class="text-sm text-gray-500">Transfer bank manual</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Cash on Delivery (COD)</h3>
                                    <p class="text-sm text-gray-500">Bayar saat barang diterima</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">E-Wallet</h3>
                                    <p class="text-sm text-gray-500">OVO, GoPay, Dana, dll</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Settings -->
            <div x-show="active === 'shipping'" x-cloak>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Pengiriman</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gratis Ongkir Minimal</label>
                        <input type="number" value="100000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="text-sm text-gray-500 mt-1">Minimal pembelian untuk gratis ongkir (Rp)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ongkir Default</label>
                        <input type="number" value="15000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="text-sm text-gray-500 mt-1">Biaya pengiriman standar (Rp)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Pengiriman</label>
                        <input type="text" value="2-4 hari kerja" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-primary-600 text-white px-6 py-2.5 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- SEO Settings -->
            <div x-show="active === 'seo'" x-cloak>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan SEO</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" value="Publisher Bookstore - Toko Buku Online Terlengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">Belanja buku online terlengkap dengan harga terbaik. Dapatkan berbagai pilihan buku dari genre fiksi, non-fiksi, pendidikan, dan lainnya.</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" value="toko buku, beli buku online, buku murah, buku bestseller" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                        <input type="text" placeholder="UA-XXXXX-Y" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-primary-600 text-white px-6 py-2.5 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
