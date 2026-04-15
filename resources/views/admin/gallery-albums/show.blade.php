@extends('layouts.admin')

@section('title', 'Album: ' . $album->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.gallery-albums.index') }}" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $album->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $album->galleries->count() }} foto · 
                    Dibuat {{ $album->created_at->format('d M Y') }}
                    @if(!$album->is_active)
                    <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Nonaktif</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.gallery-albums.edit', $album) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Album
            </a>
        </div>
    </div>

    @if($album->description)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-gray-600 text-sm">{{ $album->description }}</p>
    </div>
    @endif

    <!-- Add Photos Section -->
    <div x-data="addPhotosForm()" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex items-center justify-between cursor-pointer"
             @click="showUpload = !showUpload">
            <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Foto Baru
            </h2>
            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="showUpload ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="showUpload" x-collapse>
            <form action="{{ route('admin.gallery-albums.add-photos', $album) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <!-- Drop Zone -->
                <div class="border-2 border-dashed rounded-xl p-6 text-center transition-all duration-300"
                     :class="isDragging ? 'border-primary-500 bg-primary-50' : 'border-gray-300 hover:border-primary-400'"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="handleDrop($event)">
                    <input type="file" name="photos[]" accept="image/*" multiple class="hidden" id="add-photos-input"
                           @change="handleFiles($event.target.files)">
                    <label for="add-photos-input" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm font-semibold text-gray-700">Klik atau seret foto ke sini</p>
                            <p class="text-xs text-gray-500 mt-1">Pilih beberapa foto sekaligus</p>
                        </div>
                    </label>
                </div>

                <!-- Preview -->
                <div x-show="previews.length > 0" class="mt-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-semibold text-gray-700"><span x-text="previews.length"></span> foto dipilih</p>
                        <button type="button" @click="clearAll()" class="text-sm text-red-500 hover:text-red-700 font-medium">Hapus Semua</button>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-2">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="relative group aspect-square rounded-lg overflow-hidden border border-gray-200">
                                <img :src="preview.url" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="removeFile(index)" class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload <span x-text="previews.length"></span> Foto
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @error('photos')
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ $message }}</div>
    @enderror
    @error('photos.*')
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ $message }}</div>
    @enderror

    <!-- Photos Grid -->
    @if($album->galleries->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($album->galleries as $gallery)
        <div class="relative group rounded-xl overflow-hidden border border-gray-200 bg-white shadow-sm hover:shadow-lg transition-all duration-300">
            <!-- Image -->
            <div class="aspect-square bg-gray-100 overflow-hidden">
                @if($gallery->file_path)
                <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
            </div>

            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                <p class="text-white text-sm font-medium truncate mb-2">{{ $gallery->title }}</p>
                <div class="flex gap-2">
                    <form action="{{ route('admin.gallery-albums.delete-photo', [$album, $gallery]) }}" method="POST" 
                          onsubmit="return confirm('Hapus foto ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-500/90 text-white rounded-lg text-xs font-medium hover:bg-red-600 transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <!-- Status -->
            @if(!$gallery->is_active)
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-800/60 text-white">
                    Nonaktif
                </span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 py-16 text-center">
        <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-500 text-lg mb-1">Album ini masih kosong</p>
        <p class="text-gray-400 text-sm">Gunakan form di atas untuk menambahkan foto</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
function addPhotosForm() {
    return {
        previews: [],
        isDragging: false,
        showUpload: false,
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
            const input = document.getElementById('add-photos-input');
            const dt = new DataTransfer();
            if (input.files) {
                for (let i = 0; i < input.files.length; i++) {
                    dt.items.add(input.files[i]);
                }
            }
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
            document.getElementById('add-photos-input').value = '';
        },
        rebuildFileInput() {
            const input = document.getElementById('add-photos-input');
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
