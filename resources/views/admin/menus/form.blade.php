@extends('layouts.admin')

@section('title', isset($menu) ? 'Edit Menu' : 'Tambah Menu')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.menus.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($menu) ? 'Perbarui informasi menu' : 'Tambahkan menu navigasi baru' }}</p>
        </div>
    </div>
</div>

@if($errors->any())
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="font-semibold">Terdapat beberapa kesalahan:</p>
            <ul class="list-disc list-inside mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form method="POST" action="{{ isset($menu) ? route('admin.menus.update', $menu->id) : route('admin.menus.store') }}">
    @csrf
    @if(isset($menu)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <!-- Informasi Menu -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Menu</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Label Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="label" value="{{ old('label', $menu->label ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('label') border-red-500 @enderror"
                            placeholder="Beranda" required>
                        @error('label')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            URL / Link <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="url" value="{{ old('url', $menu->url ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('url') border-red-500 @enderror"
                            placeholder="/" required>
                        @error('url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Contoh: /, /books, /about, https://example.com</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                            <input type="text" name="icon" value="{{ old('icon', $menu->icon ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="🏠">
                            <p class="mt-1 text-sm text-gray-500">Opsional</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Link</label>
                            <select name="target" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="_self" {{ old('target', $menu->target ?? '_self') == '_self' ? 'selected' : '' }}>Tab yang sama</option>
                                <option value="_blank" {{ old('target', $menu->target ?? '') == '_blank' ? 'selected' : '' }}>Tab baru</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Menu Induk (Parent)</label>
                        <select name="parent_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">-- Menu Utama (Tidak ada parent) --</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Kosongkan jika ini adalah menu utama</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Tampil <span class="text-red-500">*</span>
                        </label>
                        <select name="location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                            <option value="header" {{ old('location', $menu->location ?? 'header') == 'header' ? 'selected' : '' }}>Header (Navigasi atas)</option>
                            <option value="footer" {{ old('location', $menu->location ?? '') == 'footer' ? 'selected' : '' }}>Footer (Navigasi bawah)</option>
                            <option value="both" {{ old('location', $menu->location ?? '') == 'both' ? 'selected' : '' }}>Keduanya</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Pengaturan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Pengaturan</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="display_order" value="{{ old('display_order', $menu->display_order ?? 0) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            min="0">
                        <p class="mt-1 text-sm text-gray-500">Urutan tampil menu (lebih kecil = lebih awal)</p>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                {{ old('is_active', $menu->is_active ?? true) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                                Aktifkan Menu
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 ml-8">Menu aktif akan ditampilkan di website</p>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Tips Menu</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-semibold">Menu Parent</span> akan memiliki dropdown jika memiliki submenu
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-semibold">Link eksternal</span> gunakan URL lengkap dengan https://
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-semibold">Urutan menu</span> menentukan posisi dari kiri ke kanan
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($menu) ? 'Update Menu' : 'Simpan Menu' }}
                </button>
                <a href="{{ route('admin.menus.index') }}" class="w-full px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
