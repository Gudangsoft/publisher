@extends('layouts.admin')

@section('title', isset($journal) ? 'Edit Jurnal' : 'Tambah Jurnal')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.journals.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($journal) ? 'Edit Jurnal' : 'Tambah Jurnal Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($journal) ? 'Perbarui informasi jurnal' : 'Tambahkan jurnal ilmiah baru' }}</p>
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

<form method="POST" action="{{ isset($journal) ? route('admin.journals.update', $journal->id) : route('admin.journals.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($journal)) @method('PUT') @endif

    <div class="grid grid-cols-1 gap-6">
        <!-- Main Form -->
        <div class="">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Dasar</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Jurnal <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $journal->title ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror"
                            placeholder="Masukkan judul jurnal" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Jurnal
                        </label>
                        <textarea name="abstract" rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('abstract') border-red-500 @enderror"
                            placeholder="Tulis deskripsi jurnal...">{{ old('abstract', $journal->abstract ?? '') }}</textarea>
                        @error('abstract')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Jurnal <span class="text-red-500">*</span></label>
                        <input type="url" name="journal_link" value="{{ old('journal_link', $journal->journal_link ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('journal_link') border-red-500 @enderror"
                            placeholder="https://example.com/journal" required>
                        <p class="mt-1 text-sm text-gray-500">Link eksternal ke jurnal online</p>
                        @error('journal_link')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Cover Jurnal</h2>
                
                <div class="space-y-6">
                    <!-- Cover Upload -->
                    <div>
                        @if(isset($journal) && $journal->cover_image)
                        <div class="mb-4" id="currentImage">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cover Saat Ini</label>
                            <img src="{{ asset('storage/' . $journal->cover_image) }}" alt="Cover" class="w-32 h-auto rounded-lg border border-gray-300">
                        </div>
                        @endif
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                        <span>Upload cover</span>
                                        <input type="file" name="cover_image" class="sr-only" accept="image/*" id="cover_image" onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 50MB</p>
                            </div>
                        </div>
                        <div id="imagePreview" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview Cover Baru</label>
                            <img src="" alt="Preview" class="w-32 h-auto rounded-lg border border-gray-300">
                        </div>
                        @error('cover_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.journals.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($journal) ? 'Update Jurnal' : 'Simpan Jurnal' }}
                </button>
            </div>
        </div>
    </div>
</form>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    const currentImage = document.getElementById('currentImage');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            if (currentImage) {
                currentImage.style.opacity = '0.5';
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
