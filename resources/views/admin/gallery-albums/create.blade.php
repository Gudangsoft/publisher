@extends('layouts.admin')

@section('title', 'Tambah Album Galeri')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.gallery-albums.index') }}" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Album Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Buat album dan upload beberapa foto sekaligus</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.gallery-albums.store') }}" method="POST" enctype="multipart/form-data" 
          x-data="albumForm()"
          class="space-y-6">
        @csrf

        <!-- Album Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-primary-50 to-orange-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Informasi Album
                </h2>
            </div>
            <div class="p-6 space-y-5">
                <!-- Album Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Album <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Contoh: Kegiatan Seminar 2026">
                    @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                              placeholder="Deskripsi singkat album...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Album <span class="text-xs font-normal text-gray-400">(Opsional)</span></label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors"
                         x-data="{ fileName: '', preview: null }">
                        <input type="file" name="cover_image" accept="image/*" class="hidden" id="cover-file"
                               @change="
                                   fileName = $event.target.files[0]?.name || '';
                                   if ($event.target.files[0]) {
                                       const reader = new FileReader();
                                       reader.onload = (e) => preview = e.target.result;
                                       reader.readAsDataURL($event.target.files[0]);
                                   }
                               ">
                        <label for="cover-file" class="cursor-pointer">
                            <template x-if="preview">
                                <img :src="preview" class="max-h-48 mx-auto rounded-lg mb-3 object-cover">
                            </template>
                            <template x-if="!preview">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </template>
                            <p class="text-sm text-gray-600 font-medium" x-text="fileName || 'Klik untuk memilih gambar cover'"></p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF, WebP. Maks 5MB. Jika kosong, akan menggunakan foto pertama.</p>
                        </label>
                    </div>
                    @error('cover_image')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Order & Active -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" id="display_order" name="display_order" value="{{ old('display_order', 0) }}" min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <span class="text-sm font-semibold text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photos Upload Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Upload Foto
                    <span class="text-xs font-normal text-gray-500 ml-1">(bisa beberapa foto sekaligus)</span>
                </h2>
            </div>
            <div class="p-6">
                <!-- Drop Zone -->
                <div class="border-2 border-dashed rounded-xl p-8 text-center transition-all duration-300"
                     :class="isDragging ? 'border-primary-500 bg-primary-50' : 'border-gray-300 hover:border-primary-400'"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="handleDrop($event)">
                    <input type="file" name="photos[]" accept="image/*" multiple class="hidden" id="photos-input"
                           @change="handleFiles($event.target.files)">
                    <label for="photos-input" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p class="text-base font-semibold text-gray-700">Klik atau seret foto ke sini</p>
                            <p class="text-sm text-gray-500 mt-1">Pilih beberapa foto sekaligus (JPG, PNG, GIF, WebP. Maks 5MB/foto)</p>
                        </div>
                    </label>
                </div>

                <!-- Preview Grid -->
                <div x-show="previews.length > 0" class="mt-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-semibold text-gray-700">
                            <span x-text="previews.length"></span> foto dipilih
                        </p>
                        <button type="button" @click="clearAll()" class="text-sm text-red-500 hover:text-red-700 font-medium">
                            Hapus Semua
                        </button>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                <img :src="preview.url" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="removeFile(index)" 
                                            class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                    <p class="text-xs text-white truncate" x-text="preview.name"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                @error('photos')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
                @error('photos.*')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.gallery-albums.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition font-medium">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Album
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function albumForm() {
    return {
        previews: [],
        isDragging: false,
        handleFiles(fileList) {
            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                if (!file.type.startsWith('image/')) continue;
                const url = URL.createObjectURL(file);
                this.previews.push({ url, name: file.name, file });
            }
        },
        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            // Update the file input
            const input = document.getElementById('photos-input');
            const dt = new DataTransfer();
            // Add existing files
            if (input.files) {
                for (let i = 0; i < input.files.length; i++) {
                    dt.items.add(input.files[i]);
                }
            }
            // Add new files
            for (let i = 0; i < files.length; i++) {
                if (files[i].type.startsWith('image/')) {
                    dt.items.add(files[i]);
                    const url = URL.createObjectURL(files[i]);
                    this.previews.push({ url, name: files[i].name, file: files[i] });
                }
            }
            input.files = dt.files;
        },
        removeFile(index) {
            URL.revokeObjectURL(this.previews[index].url);
            this.previews.splice(index, 1);
            this.rebuildFileInput();
        },
        clearAll() {
            this.previews.forEach(p => URL.revokeObjectURL(p.url));
            this.previews = [];
            document.getElementById('photos-input').value = '';
        },
        rebuildFileInput() {
            const input = document.getElementById('photos-input');
            const dt = new DataTransfer();
            this.previews.forEach(p => {
                if (p.file) dt.items.add(p.file);
            });
            input.files = dt.files;
        }
    }
}
</script>
@endpush
@endsection
