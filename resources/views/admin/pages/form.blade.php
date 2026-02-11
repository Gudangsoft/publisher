@extends('layouts.admin')

@section('title', isset($page->id) ? 'Edit Halaman' : 'Tambah Halaman')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ isset($page->id) ? 'Edit Halaman' : 'Tambah Halaman' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($page->id) ? 'Perbarui informasi halaman' : 'Buat halaman baru' }}</p>
        </div>
    </div>
</div>

<form action="{{ isset($page->id) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if(isset($page->id))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Title -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror" 
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug URL</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                           placeholder="Otomatis dari judul jika kosong">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">URL: {{ url('/pages') }}/<span id="slug-preview">{{ $page->slug ?? 'slug-halaman' }}</span></p>
                </div>

                <div class="mb-4">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                    <textarea name="excerpt" id="excerpt" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                              placeholder="Ringkasan singkat halaman...">{{ old('excerpt', $page->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten *</label>
                    <textarea name="content" id="content" rows="15" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror"
                              required>{{ old('content', $page->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- SEO Meta -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    SEO Meta Tags
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Judul untuk mesin pencari">
                    </div>

                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Deskripsi untuk mesin pencari (150-160 karakter)">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>

                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="keyword1, keyword2, keyword3">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Publish Settings -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Publikasi</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" 
                                   {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Publikasikan halaman</span>
                        </label>
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                        <input type="datetime-local" name="published_at" id="published_at" 
                               value="{{ old('published_at', $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan</label>
                        <input type="number" name="display_order" id="display_order" 
                               value="{{ old('display_order', $page->display_order ?? 0) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               min="0">
                        <p class="mt-1 text-xs text-gray-500">Angka lebih kecil tampil lebih dulu</p>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Gambar Unggulan</h2>
                
                @if($page->featured_image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" alt="Featured Image" class="w-full rounded-lg">
                </div>
                @endif

                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('featured_image') border-red-500 @enderror">
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, GIF (Max: 2MB)</p>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors mb-3">
                    {{ isset($page->id) ? 'Perbarui Halaman' : 'Simpan Halaman' }}
                </button>
                <a href="{{ route('admin.pages.index') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    
    const slugInput = document.getElementById('slug');
    if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
        slugInput.value = slug;
        slugInput.dataset.autoGenerated = 'true';
        document.getElementById('slug-preview').textContent = slug || 'slug-halaman';
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.autoGenerated = 'false';
    document.getElementById('slug-preview').textContent = this.value || 'slug-halaman';
});
</script>
@endsection
