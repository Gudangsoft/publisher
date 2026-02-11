@extends('layouts.admin')

@section('title', isset($category) && $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.categories.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($category) && $category->exists ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($category) && $category->exists ? 'Perbarui informasi kategori' : 'Buat kategori baru untuk mengelompokkan buku dan berita' }}</p>
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form method="POST" action="{{ isset($category) && $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if(isset($category) && $category->exists) @method('PUT') @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Kategori</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror"
                            placeholder="Contoh: Fiksi, Non-Fiksi, Berita Terbaru" required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ old('type', $category->type ?? '') === 'book' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-gray-400' }}">
                                <input type="radio" name="type" value="book" {{ old('type', $category->type ?? '') === 'book' ? 'checked' : '' }} class="mr-3" required>
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Buku</p>
                                        <p class="text-xs text-gray-500">Kategori untuk buku</p>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ old('type', $category->type ?? '') === 'news' ? 'border-purple-500 bg-purple-50' : 'border-gray-300 hover:border-gray-400' }}">
                                <input type="radio" name="type" value="news" {{ old('type', $category->type ?? '') === 'news' ? 'checked' : '' }} class="mr-3" required>
                                <div class="flex items-center">
                                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Berita</p>
                                        <p class="text-xs text-gray-500">Kategori untuk berita</p>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ old('type', $category->type ?? '') === 'journal' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-gray-400' }}">
                                <input type="radio" name="type" value="journal" {{ old('type', $category->type ?? '') === 'journal' ? 'checked' : '' }} class="mr-3" required>
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Journal</p>
                                        <p class="text-xs text-gray-500">Kategori untuk journal</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Deskripsi singkat tentang kategori ini (opsional)">{{ old('description', $category->description ?? '') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Jelaskan kategori ini untuk memudahkan pengelolaan</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($category) && $category->exists ? 'Update Kategori' : 'Simpan Kategori' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="font-bold text-gray-900 mb-4">Informasi</h3>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Slug otomatis</span> akan dibuat dari nama kategori.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Tipe kategori</span> menentukan apakah untuk buku atau berita.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 text-purple-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            Kategori membantu <span class="font-semibold">mengorganisir konten</span> dengan lebih baik.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-semibold text-gray-900 mb-2">Contoh Kategori</h4>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600"><strong>Buku:</strong> Fiksi, Non-Fiksi, Anak-anak, Bisnis</p>
                    <p class="text-sm text-gray-600"><strong>Berita:</strong> Peluncuran, Promo, Event, Tips</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
