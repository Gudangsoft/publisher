@extends('layouts.admin')

@section('title', 'Edit Item Galeri')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.galleries.index') }}" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Item Galeri</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi galeri</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" 
          x-data="{ type: '{{ old('type', $gallery->type) }}' }"
          class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6">
            <!-- Type Selection -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Media</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="photo" x-model="type" class="sr-only peer">
                        <div class="flex items-center gap-3 p-4 border-2 rounded-xl transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 border-gray-200 hover:border-gray-300">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">📷 Foto</p>
                                <p class="text-xs text-gray-500">Upload gambar</p>
                            </div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="video" x-model="type" class="sr-only peer">
                        <div class="flex items-center gap-3 p-4 border-2 rounded-xl transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 border-gray-200 hover:border-gray-300">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">🎬 Video</p>
                                <p class="text-xs text-gray-500">Link YouTube</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Current Preview -->
            @if($gallery->type === 'photo' && $gallery->file_path)
            <div x-show="type === 'photo'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
                <div class="relative inline-block">
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" 
                         class="max-h-48 rounded-xl border border-gray-200 shadow-sm">
                </div>
            </div>
            @endif

            @if($gallery->type === 'video' && $gallery->video_url)
            <div x-show="type === 'video'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Video Saat Ini</label>
                <div class="aspect-video max-w-md rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                    <iframe src="{{ $gallery->youtube_embed_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            @endif

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                       placeholder="Masukkan judul...">
                @error('title')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                          placeholder="Deskripsi singkat...">{{ old('description', $gallery->description) }}</textarea>
                @error('description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload (shown when type=photo) -->
            <div x-show="type === 'photo'" x-transition>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Foto</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors"
                     x-data="{ fileName: '' }">
                    <input type="file" name="file" accept="image/*" class="hidden" id="photo-file"
                           @change="fileName = $event.target.files[0]?.name || ''">
                    <label for="photo-file" class="cursor-pointer">
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-600 font-medium" x-text="fileName || 'Klik untuk mengganti foto'"></p>
                        <p class="text-xs text-gray-400 mt-1">Biarkan kosong untuk tetap menggunakan foto saat ini</p>
                    </label>
                </div>
                @error('file')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video URL (shown when type=video) -->
            <div x-show="type === 'video'" x-transition>
                <div class="space-y-4">
                    <div>
                        <label for="video_url" class="block text-sm font-semibold text-gray-700 mb-2">URL Video <span class="text-red-500">*</span></label>
                        <input type="url" id="video_url" name="video_url" value="{{ old('video_url', $gallery->video_url) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               placeholder="https://www.youtube.com/watch?v=...">
                        @error('video_url')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Thumbnail (Opsional)</label>
                        @if($gallery->thumbnail)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="Thumbnail" class="h-20 rounded-lg border">
                        </div>
                        @endif
                        <input type="file" name="thumbnail_file" accept="image/*" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs text-gray-400 mt-1">Biarkan kosong untuk menggunakan thumbnail saat ini</p>
                        @error('thumbnail_file')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Kategori / Album</label>
                <div class="flex gap-3">
                    <select id="category" name="category" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 text-sm">
                        <option value="">-- Tanpa Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $gallery->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="category_new" value="{{ old('category_new') }}" 
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 text-sm"
                           placeholder="Atau buat kategori baru...">
                </div>
            </div>

            <!-- Display Order & Active -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">Urutan Tampil</label>
                    <input type="number" id="display_order" name="display_order" value="{{ old('display_order', $gallery->display_order) }}" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm font-semibold text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition font-medium">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200">
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
