@extends('layouts.admin')

@section('title', isset($heroSlider) ? 'Edit Hero Slider' : 'Tambah Hero Slider')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.hero-sliders.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($heroSlider) ? 'Edit Hero Slider' : 'Tambah Hero Slider Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($heroSlider) ? 'Perbarui informasi slider' : 'Tambahkan banner slider baru' }}</p>
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

<form method="POST" action="{{ isset($heroSlider) ? route('admin.hero-sliders.update', $heroSlider->id) : route('admin.hero-sliders.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($heroSlider)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <!-- Informasi Slider -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Slider</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $heroSlider->title ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror"
                            placeholder="Jendela Ilmu Untuk Semua" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $heroSlider->subtitle ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Untuk Semua">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Temukan koleksi buku terlengkap dan berkualitas...">{{ old('description', $heroSlider->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teks Tombol</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $heroSlider->button_text ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="Jelajahi Katalog">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Tombol</label>
                            <input type="text" name="button_link" value="{{ old('button_link', $heroSlider->button_link ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="/books">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Gambar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Gambar Slider</h2>
                
                @if(isset($heroSlider) && $heroSlider->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <img src="{{ asset('storage/' . $heroSlider->image) }}" alt="Preview" class="w-full max-w-md rounded-lg border border-gray-300">
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Gambar {{ isset($heroSlider) ? 'Baru' : '' }} <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Upload gambar</span>
                                    <input type="file" name="image" class="sr-only" accept="image/*" {{ isset($heroSlider) ? '' : 'required' }}>
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            <p class="text-xs text-primary-600 font-medium">Rekomendasi ukuran: 800x1000px (rasio 4:5)</p>
                        </div>
                    </div>
                    @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
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
                        <input type="number" name="display_order" value="{{ old('display_order', $heroSlider->display_order ?? 0) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            min="0">
                        <p class="mt-1 text-sm text-gray-500">Urutan tampil slider (lebih kecil = lebih awal)</p>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                {{ old('is_active', $heroSlider->is_active ?? true) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                                Aktifkan Slider
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 ml-8">Slider aktif akan ditampilkan di homepage</p>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                <h3 class="font-bold text-gray-900 mb-4">Tips Slider</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-semibold">Gambar berkualitas tinggi</span> dengan rasio 4:5 (seperti 800x1000px)
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-semibold">Judul singkat</span> dan menarik untuk menarik perhatian pengunjung
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">
                                <span class="font-semibold">Urutan slider</span> menentukan posisi tampil dari kiri ke kanan
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex flex-col gap-3">
                <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($heroSlider) ? 'Update Slider' : 'Simpan Slider' }}
                </button>
                <a href="{{ route('admin.hero-sliders.index') }}" class="w-full px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
