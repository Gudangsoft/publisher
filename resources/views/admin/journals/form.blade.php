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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <!-- Informasi Dasar -->
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
                            Abstrak <span class="text-red-500">*</span>
                        </label>
                        <textarea name="abstract" rows="6" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('abstract') border-red-500 @enderror"
                            placeholder="Tulis abstrak jurnal..." required>{{ old('abstract', $journal->abstract ?? '') }}</textarea>
                        @error('abstract')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kata Kunci</label>
                        <input type="text" name="keywords" value="{{ old('keywords', $journal->keywords ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('keywords') border-red-500 @enderror"
                            placeholder="pisahkan setiap kata kunci dengan koma">
                        <p class="mt-1 text-sm text-gray-500">Pisahkan setiap kata kunci dengan koma</p>
                        @error('keywords')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Penulis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Penulis</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Penulis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="authors" value="{{ old('authors', $journal->authors ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('authors') border-red-500 @enderror"
                            placeholder="Nama penulis, pisahkan dengan koma" required>
                        @error('authors')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Afiliasi</label>
                        <input type="text" name="affiliation" value="{{ old('affiliation', $journal->affiliation ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('affiliation') border-red-500 @enderror"
                            placeholder="Universitas Islam Negeri Jakarta">
                        @error('affiliation')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Publikasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Publikasi</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Volume</label>
                            <input type="text" name="volume" value="{{ old('volume', $journal->volume ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="15">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor/Issue</label>
                            <input type="text" name="issue" value="{{ old('issue', $journal->issue ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Halaman</label>
                            <input type="text" name="pages" value="{{ old('pages', $journal->pages ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="125-145">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                            <input type="date" name="publication_date" 
                                value="{{ old('publication_date', isset($journal) && $journal->publication_date ? $journal->publication_date->format('Y-m-d') : '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <input type="number" name="year" value="{{ old('year', $journal->year ?? date('Y')) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                min="1900" max="{{ date('Y') + 1 }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">DOI</label>
                            <input type="text" name="doi" value="{{ old('doi', $journal->doi ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="10.1234/jurnal.2024.001">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ISSN</label>
                            <input type="text" name="issn" value="{{ old('issn', $journal->issn ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="2345-6789">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format Sitasi</label>
                        <textarea name="citation_format" rows="3" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Format APA, MLA, atau lainnya">{{ old('citation_format', $journal->citation_format ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Jurnal</label>
                        <input type="url" name="journal_link" value="{{ old('journal_link', $journal->journal_link ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('journal_link') border-red-500 @enderror"
                            placeholder="https://example.com/journal">
                        <p class="mt-1 text-sm text-gray-500">Link eksternal ke jurnal online (opsional)</p>
                        @error('journal_link')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">File & Cover</h2>
                
                <div class="space-y-6">
                    <!-- PDF Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">File PDF Jurnal</label>
                        @if(isset($journal) && $journal->file_pdf)
                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-700">File PDF saat ini</span>
                            </div>
                            <a href="{{ asset('storage/' . $journal->file_pdf) }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                Lihat PDF
                            </a>
                        </div>
                        @endif
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                        <span>Upload file PDF</span>
                                        <input type="file" name="file_pdf" class="sr-only" accept=".pdf">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF hingga 10MB</p>
                            </div>
                        </div>
                        @error('file_pdf')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cover Jurnal</label>
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
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
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

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Status & Kategori -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Status & Kategori</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <select name="category_id" id="category_id"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('category_id') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $journal->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openAddCategoryModal()"
                                class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center whitespace-nowrap" title="Tambah Kategori Baru">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Baru
                            </button>
                        </div>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                        <select name="language" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="id" {{ old('language', $journal->language ?? 'id') == 'id' ? 'selected' : '' }}>Indonesia</option>
                            <option value="en" {{ old('language', $journal->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ old('language', $journal->language ?? '') == 'ar' ? 'selected' : '' }}>العربية (Arabic)</option>
                        </select>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" 
                                {{ old('is_published', $journal->is_published ?? false) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-3 block text-sm font-medium text-gray-700">
                                Publikasikan Jurnal
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 ml-8">Jurnal yang dipublikasikan akan tampil di website</p>
                    </div>
                </div>
            </div>

        <!-- Tips -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="font-bold text-gray-900 mb-4">Tips Menambahkan Jurnal</h3>
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
                            <span class="font-semibold">Judul yang jelas</span> membantu pembaca menemukan jurnal dengan mudah.
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
                            <span class="font-semibold">Abstrak informatif</span> memberikan gambaran singkat isi jurnal.
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
                            <span class="font-semibold">DOI yang valid</span> memudahkan sitasi dan referensi.
                        </p>
                    </div>
                </div>
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

function openAddCategoryModal() {
    document.getElementById('addCategoryModal').classList.remove('hidden');
    document.getElementById('newCategoryName').value = '';
    document.getElementById('newCategoryDescription').value = '';
    document.getElementById('categoryModalAlert').classList.add('hidden');
    setTimeout(() => document.getElementById('newCategoryName').focus(), 100);
}

function closeAddCategoryModal() {
    document.getElementById('addCategoryModal').classList.add('hidden');
}

function submitNewCategory() {
    const name = document.getElementById('newCategoryName').value.trim();
    const description = document.getElementById('newCategoryDescription').value.trim();
    const type = document.getElementById('newCategoryType').value;
    const alertEl = document.getElementById('categoryModalAlert');
    const spinner = document.getElementById('categorySpinner');
    const btn = document.getElementById('btnSaveCategory');

    if (!name) {
        alertEl.className = 'mb-4 px-4 py-3 rounded-lg text-sm bg-red-100 text-red-700 border border-red-300';
        alertEl.textContent = 'Nama kategori wajib diisi.';
        alertEl.classList.remove('hidden');
        return;
    }

    btn.disabled = true;
    spinner.classList.remove('hidden');

    fetch('{{ route("admin.categories.quick-store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ name, description, type })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('category_id');
            const option = new Option(data.category.name, data.category.id, true, true);
            select.appendChild(option);
            closeAddCategoryModal();
        } else {
            alertEl.className = 'mb-4 px-4 py-3 rounded-lg text-sm bg-red-100 text-red-700 border border-red-300';
            alertEl.textContent = data.message || 'Gagal menambahkan kategori.';
            alertEl.classList.remove('hidden');
        }
    })
    .catch(err => {
        alertEl.className = 'mb-4 px-4 py-3 rounded-lg text-sm bg-red-100 text-red-700 border border-red-300';
        alertEl.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        alertEl.classList.remove('hidden');
    })
    .finally(() => {
        btn.disabled = false;
        spinner.classList.add('hidden');
    });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAddCategoryModal();
});
</script>

<!-- Modal Tambah Kategori Baru -->
<div id="addCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeAddCategoryModal()"></div>
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full relative z-10 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeAddCategoryModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="categoryModalAlert" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" id="newCategoryName" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Nama kategori baru">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="newCategoryDescription" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Deskripsi singkat (opsional)"></textarea>
                </div>
                <input type="hidden" id="newCategoryType" value="journal">
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAddCategoryModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</button>
                <button type="button" onclick="submitNewCategory()" id="btnSaveCategory" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 hidden animate-spin" id="categorySpinner" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Simpan Kategori
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
