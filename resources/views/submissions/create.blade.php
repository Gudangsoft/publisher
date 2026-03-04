@extends('layouts.app')

@section('title', 'Ajukan Naskah - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<!-- Hero Section -->
<section class="relative py-16 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-display">
                Ajukan Naskah Anda
            </h1>
            <p class="text-xl text-primary-100">
                Wujudkan karya Anda menjadi buku yang diterbitkan. Kirimkan naskah Anda dan tim kami akan mereviewnya.
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">1</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Isi Formulir</h3>
                    <p class="text-gray-600 text-sm">Lengkapi data diri dan informasi naskah Anda</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">2</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Unggah Naskah</h3>
                    <p class="text-gray-600 text-sm">Upload file naskah dalam format PDF atau Word</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">3</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Tunggu Review</h3>
                    <p class="text-gray-600 text-sm">Tim kami akan mereview dan menghubungi Anda</p>
                </div>
            </div>

            <!-- Submission Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Terdapat kesalahan pada form:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Section: Informasi Pengaju -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informasi Pengaju
                            @auth
                            <span class="text-sm font-normal text-green-600 ml-2">(Data terisi dari akun Anda)</span>
                            @endauth
                        </h2>
                        
                        @guest
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-blue-800">
                                        <a href="{{ route('register') }}" class="font-semibold hover:underline">Daftar akun</a> atau 
                                        <a href="{{ route('login') }}" class="font-semibold hover:underline">login</a> untuk mempermudah pengajuan dan melacak status naskah Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endguest
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="submitter_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="submitter_name" id="submitter_name" 
                                       value="{{ old('submitter_name', auth()->user()->name ?? '') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('submitter_name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap Anda">
                                @error('submitter_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="submitter_email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="submitter_email" id="submitter_email" 
                                       value="{{ old('submitter_email', auth()->user()->email ?? '') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('submitter_email') border-red-500 @enderror"
                                       placeholder="email@example.com">
                                @error('submitter_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="submitter_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nomor Telepon/WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="submitter_phone" id="submitter_phone" 
                                       value="{{ old('submitter_phone', auth()->user()->phone ?? '') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('submitter_phone') border-red-500 @enderror"
                                       placeholder="08xxxxxxxxxx">
                                @error('submitter_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="submitter_institution" class="block text-sm font-medium text-gray-700 mb-1">
                                    Institusi/Organisasi
                                </label>
                                <input type="text" name="submitter_institution" id="submitter_institution" 
                                       value="{{ old('submitter_institution', auth()->user()->institution ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Universitas/Perusahaan/dll">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="submitter_address" class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat Lengkap
                            </label>
                            <textarea name="submitter_address" id="submitter_address" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                      placeholder="Masukkan alamat lengkap Anda">{{ old('submitter_address', auth()->user()->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Section: Informasi Naskah -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Informasi Naskah
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Judul Naskah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" 
                                       value="{{ old('title') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                       placeholder="Masukkan judul naskah">
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Pengajuan <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('type') border-red-500 @enderror">
                                    <option value="">Pilih jenis</option>
                                    <option value="book" {{ old('type') == 'book' ? 'selected' : '' }}>Buku</option>
                                    <option value="journal" {{ old('type') == 'journal' ? 'selected' : '' }}>Jurnal</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Kategori
                                </label>
                                <select name="category_id" id="category_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="">Pilih kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="estimated_pages" class="block text-sm font-medium text-gray-700 mb-1">
                                    Estimasi Jumlah Halaman
                                </label>
                                <input type="number" name="estimated_pages" id="estimated_pages" 
                                       value="{{ old('estimated_pages') }}" min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Contoh: 200">
                            </div>
                            
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-1">
                                    Bahasa <span class="text-red-500">*</span>
                                </label>
                                <select name="language" id="language" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="Indonesia" {{ old('language', 'Indonesia') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Indonesia-English" {{ old('language') == 'Indonesia-English' ? 'selected' : '' }}>Indonesia & English</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-1">
                                    Target Pembaca
                                </label>
                                <input type="text" name="target_audience" id="target_audience" 
                                       value="{{ old('target_audience') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Contoh: Mahasiswa, Profesional, Umum">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Deskripsi Singkat Naskah <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="4" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                      placeholder="Jelaskan secara singkat tentang naskah Anda, apa yang dibahas, dan mengapa penting untuk diterbitkan">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-6">
                            <label for="synopsis" class="block text-sm font-medium text-gray-700 mb-1">
                                Sinopsis (Opsional)
                            </label>
                            <textarea name="synopsis" id="synopsis" rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                      placeholder="Tuliskan sinopsis lengkap naskah Anda jika ada">{{ old('synopsis') }}</textarea>
                        </div>
                    </div>

                    <!-- Section: Upload File -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-6 h-6 inline mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload File
                        </h2>
                        
                        <div class="space-y-6">
                            <!-- Manuscript File -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    File Naskah <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-500 transition-colors">
                                    <input type="file" name="manuscript_file" id="manuscript_file" required accept=".pdf,.doc,.docx"
                                           class="hidden" onchange="updateFileName(this, 'manuscript_label')">
                                    <label for="manuscript_file" class="cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span id="manuscript_label" class="text-gray-600">Klik untuk memilih file atau drag & drop</span>
                                        <p class="text-sm text-gray-500 mt-1">Format: PDF, DOC, DOCX (Maks. 20MB)</p>
                                    </label>
                                </div>
                                @error('manuscript_file')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Cover Proposal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Desain Cover (Opsional)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-500 transition-colors">
                                    <input type="file" name="cover_proposal" id="cover_proposal" accept=".jpg,.jpeg,.png"
                                           class="hidden" onchange="updateFileName(this, 'cover_label')">
                                    <label for="cover_proposal" class="cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span id="cover_label" class="text-gray-600">Upload desain cover jika sudah ada</span>
                                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 5MB)</p>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Additional Files -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    File Tambahan (Opsional)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-500 transition-colors">
                                    <input type="file" name="additional_files[]" id="additional_files" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           class="hidden" onchange="updateFileName(this, 'additional_label', true)">
                                    <label for="additional_files" class="cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                        </svg>
                                        <span id="additional_label" class="text-gray-600">Upload file pendukung lainnya</span>
                                        <p class="text-sm text-gray-500 mt-1">CV, surat pengantar, dll (Maks. 10MB per file)</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex items-center mb-6">
                            <input type="checkbox" id="agreement" required
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label for="agreement" class="ml-2 text-sm text-gray-600">
                                Saya menyatakan bahwa naskah ini adalah karya asli saya dan saya setuju dengan 
                                <a href="#" class="text-primary-600 hover:underline">syarat dan ketentuan</a> yang berlaku.
                            </label>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-primary-600 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:bg-primary-700 transition-colors focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Track Submission CTA -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Sudah pernah mengajukan? 
                    <a href="{{ route('submissions.track') }}" class="text-primary-600 hover:underline font-medium">
                        Lacak status pengajuan Anda
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function updateFileName(input, labelId, multiple = false) {
    const label = document.getElementById(labelId);
    if (input.files.length > 0) {
        if (multiple) {
            label.textContent = input.files.length + ' file dipilih';
        } else {
            label.textContent = input.files[0].name;
        }
        label.classList.add('text-primary-600', 'font-medium');
    }
}
</script>
@endpush
@endsection
