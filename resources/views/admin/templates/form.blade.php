@extends('layouts.admin')

@section('title', isset($template) ? 'Edit Template' : 'Tambah Template')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <nav class="text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.templates.index') }}" class="hover:text-primary-600">Template Buku</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ isset($template) ? 'Edit' : 'Tambah' }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($template) ? 'Edit Template' : 'Tambah Template Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($template) ? 'Perbarui informasi template buku' : 'Buat template baru untuk jenis buku tertentu' }}</p>
        </div>
        <a href="{{ route('admin.templates.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

@if($errors->any())
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
    <div class="flex items-center mb-2">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <strong>Terjadi kesalahan:</strong>
    </div>
    <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ isset($template) ? route('admin.templates.update', $template) : route('admin.templates.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="space-y-8">
    @csrf
    @if(isset($template))
        @method('PUT')
    @endif

    <!-- Section: Informasi Dasar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informasi Dasar
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Template <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $template->name ?? '') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                       placeholder="Contoh: Template Buku Ajar A5">
            </div>

            <div>
                <label for="book_type" class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Buku <span class="text-red-500">*</span>
                </label>
                <select name="book_type" id="book_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Pilih Jenis Buku</option>
                    @foreach($bookTypes as $value => $label)
                        <option value="{{ $value }}" {{ old('book_type', $template->book_type ?? '') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi Template
                </label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                          placeholder="Jelaskan kegunaan dan karakteristik template ini">{{ old('description', $template->description ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Section: Spesifikasi Halaman -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Spesifikasi Halaman
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="page_size" class="block text-sm font-medium text-gray-700 mb-1">
                    Ukuran Halaman <span class="text-red-500">*</span>
                </label>
                <select name="page_size" id="page_size" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @foreach($pageSizes as $value => $label)
                        <option value="{{ $value }}" {{ old('page_size', $template->page_size ?? '') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="orientation" class="block text-sm font-medium text-gray-700 mb-1">
                    Orientasi <span class="text-red-500">*</span>
                </label>
                <select name="orientation" id="orientation" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="portrait" {{ old('orientation', $template->orientation ?? 'portrait') == 'portrait' ? 'selected' : '' }}>Portrait (Tegak)</option>
                    <option value="landscape" {{ old('orientation', $template->orientation ?? '') == 'landscape' ? 'selected' : '' }}>Landscape (Mendatar)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil</label>
                <input type="number" name="display_order" 
                       value="{{ old('display_order', $template->display_order ?? 0) }}" min="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                       placeholder="0">
            </div>
        </div>

        <!-- Margins -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Margin (cm)</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label for="margin_top" class="block text-xs text-gray-500 mb-1">Atas</label>
                    <input type="number" name="margin_top" id="margin_top" step="0.1" min="0" max="10"
                           value="{{ old('margin_top', $template->margins['top'] ?? 2.5) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label for="margin_bottom" class="block text-xs text-gray-500 mb-1">Bawah</label>
                    <input type="number" name="margin_bottom" id="margin_bottom" step="0.1" min="0" max="10"
                           value="{{ old('margin_bottom', $template->margins['bottom'] ?? 2.5) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label for="margin_left" class="block text-xs text-gray-500 mb-1">Kiri</label>
                    <input type="number" name="margin_left" id="margin_left" step="0.1" min="0" max="10"
                           value="{{ old('margin_left', $template->margins['left'] ?? 3) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label for="margin_right" class="block text-xs text-gray-500 mb-1">Kanan</label>
                    <input type="number" name="margin_right" id="margin_right" step="0.1" min="0" max="10"
                           value="{{ old('margin_right', $template->margins['right'] ?? 2.5) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Typography -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Typography
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="font_family" class="block text-sm font-medium text-gray-700 mb-1">
                    Font Family
                </label>
                <select name="font_family" id="font_family"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Pilih Font</option>
                    <option value="Times New Roman" {{ old('font_family', $template->font_family ?? '') == 'Times New Roman' ? 'selected' : '' }}>Times New Roman</option>
                    <option value="Arial" {{ old('font_family', $template->font_family ?? '') == 'Arial' ? 'selected' : '' }}>Arial</option>
                    <option value="Calibri" {{ old('font_family', $template->font_family ?? '') == 'Calibri' ? 'selected' : '' }}>Calibri</option>
                    <option value="Georgia" {{ old('font_family', $template->font_family ?? '') == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                    <option value="Garamond" {{ old('font_family', $template->font_family ?? '') == 'Garamond' ? 'selected' : '' }}>Garamond</option>
                    <option value="Cambria" {{ old('font_family', $template->font_family ?? '') == 'Cambria' ? 'selected' : '' }}>Cambria</option>
                    <option value="Book Antiqua" {{ old('font_family', $template->font_family ?? '') == 'Book Antiqua' ? 'selected' : '' }}>Book Antiqua</option>
                </select>
            </div>

            <div>
                <label for="font_size" class="block text-sm font-medium text-gray-700 mb-1">
                    Ukuran Font (pt)
                </label>
                <input type="number" name="font_size" id="font_size" min="8" max="24"
                       value="{{ old('font_size', $template->font_size ?? 12) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div>
                <label for="line_spacing" class="block text-sm font-medium text-gray-700 mb-1">
                    Spasi Baris
                </label>
                <select name="line_spacing" id="line_spacing"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="1" {{ old('line_spacing', $template->line_spacing ?? '') == '1' ? 'selected' : '' }}>1.0 (Single)</option>
                    <option value="1.15" {{ old('line_spacing', $template->line_spacing ?? '') == '1.15' ? 'selected' : '' }}>1.15</option>
                    <option value="1.5" {{ old('line_spacing', $template->line_spacing ?? '1.5') == '1.5' ? 'selected' : '' }}>1.5</option>
                    <option value="2" {{ old('line_spacing', $template->line_spacing ?? '') == '2' ? 'selected' : '' }}>2.0 (Double)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Section: File Upload -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            File
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="preview_image" class="block text-sm font-medium text-gray-700 mb-1">
                    Gambar Preview
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        @if(isset($template) && $template->preview_image)
                            <img src="{{ asset('storage/' . $template->preview_image) }}" 
                                 alt="Preview" class="mx-auto h-32 w-auto mb-3 rounded">
                        @else
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="preview_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                <span>Upload gambar</span>
                                <input id="preview_image" name="preview_image" type="file" accept="image/*" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, WEBP max 2MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label for="template_file" class="block text-sm font-medium text-gray-700 mb-1">
                    File Template
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        @if(isset($template) && $template->template_file)
                            <div class="flex items-center justify-center mb-3">
                                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">File sudah diupload</p>
                        @else
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        @endif
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="template_file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                <span>Upload file</span>
                                <input id="template_file" name="template_file" type="file" accept=".doc,.docx,.pdf" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">DOC, DOCX, PDF max 10MB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Spesifikasi Tambahan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Spesifikasi Tambahan
        </h2>
        
        <div>
            <label for="specifications" class="block text-sm font-medium text-gray-700 mb-1">
                Spesifikasi (format: kunci: nilai)
            </label>
            <textarea name="specifications" id="specifications" rows="5"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                      placeholder="Contoh:
Jumlah Halaman Minimal: 100
Jenis Kertas: HVS 70gsm
Header: Judul Buku
Footer: Nomor Halaman">@if(isset($template) && $template->specifications)@foreach($template->specifications as $key => $value){{ $key }}: {{ $value }}
@endforeach @else{{ old('specifications') }}@endif</textarea>
            <p class="text-xs text-gray-500 mt-1">Tulis satu spesifikasi per baris dengan format "Nama: Nilai"</p>
        </div>

        <div class="mt-6">
            <label class="flex items-center">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" 
                       {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }}
                       class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <span class="ml-3 text-sm font-medium text-gray-700">Template Aktif</span>
            </label>
            <p class="text-xs text-gray-500 mt-1 ml-8">Template yang aktif akan ditampilkan di form pengajuan</p>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.templates.index') }}" 
           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            Batal
        </a>
        <button type="submit" 
                class="px-8 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ isset($template) ? 'Simpan Perubahan' : 'Simpan Template' }}
        </button>
    </div>
</form>
@endsection
