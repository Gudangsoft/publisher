@extends('layouts.admin')

@section('title', isset($news) && $news->exists ? 'Edit Berita' : 'Tambah Berita')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.news.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($news) && $news->exists ? 'Edit Berita' : 'Tambah Berita Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($news) && $news->exists ? 'Perbarui informasi berita' : 'Tambahkan berita atau artikel baru' }}</p>
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
        <form method="POST" action="{{ isset($news) && $news->exists ? route('admin.news.update', $news) : route('admin.news.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($news) && $news->exists) @method('PUT') @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Berita</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Category::where('type', 'news')->get() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $news->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $news->title ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror"
                            placeholder="Masukkan judul berita yang menarik" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ringkasan
                        </label>
                        <textarea name="summary" rows="3" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Ringkasan singkat untuk preview (maks 500 karakter)">{{ old('summary', $news->summary ?? '') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Ringkasan akan muncul di halaman daftar berita</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konten Berita <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" rows="12" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('content') border-red-500 @enderror"
                            placeholder="Tulis konten berita lengkap di sini..." required>{{ old('content', $news->content ?? '') }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                        <input type="datetime-local" name="published_at" 
                            value="{{ old('published_at', isset($news->published_at) ? (is_string($news->published_at) ? date('Y-m-d\\TH:i', strtotime($news->published_at)) : $news->published_at->format('Y-m-d\\TH:i')) : '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="mt-1 text-sm text-gray-500">Kosongkan untuk menyimpan sebagai draft</p>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                {{ old('is_featured', $news->is_featured ?? false) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-3 block text-sm font-medium text-gray-700">
                                Tampilkan sebagai Featured
                            </label>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 ml-8">Berita akan ditampilkan sebagai konten unggulan</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Gambar Cover</h2>
                
                @if(isset($news->image) && $news->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <img src="{{ asset('storage/' . $news->image) }}" alt="Cover" class="w-full max-w-md h-auto rounded-lg border border-gray-300">
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Baru</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Upload file</span>
                                    <input type="file" name="image" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.news.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($news) && $news->exists ? 'Update Berita' : 'Simpan Berita' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="font-bold text-gray-900 mb-4">Tips Menulis Berita</h3>
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
                            <span class="font-semibold">Judul menarik</span> adalah kunci untuk menarik perhatian pembaca.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Ringkasan singkat</span> membantu pembaca memahami isi berita dengan cepat.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Gambar berkualitas</span> membuat berita lebih menarik secara visual.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 text-purple-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Jadwalkan publikasi</span> untuk posting otomatis di waktu yang tepat.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-semibold text-gray-900 mb-2">Status</h4>
                <p class="text-sm text-gray-600">
                    Berita akan disimpan sebagai <span class="font-semibold text-yellow-600">Draft</span> jika tanggal publikasi tidak diisi, atau <span class="font-semibold text-green-600">Dipublikasi</span> jika sudah dijadwalkan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
