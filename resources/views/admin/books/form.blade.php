@extends('layouts.admin')

@section('title', $book->exists ? 'Edit Buku' : 'Tambah Buku')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.books.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $book->exists ? 'Edit Buku' : 'Tambah Buku Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ $book->exists ? 'Perbarui informasi buku' : 'Tambahkan buku baru ke katalog' }}</p>
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
        <form method="POST" action="{{ $book->exists ? route('admin.books.update', $book) : route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf
            @if($book->exists) @method('PUT') @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Buku</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Category::where('type', 'book')->get() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
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
                            Judul Buku <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $book->title) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror"
                            placeholder="Masukkan judul buku" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Penulis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('author') border-red-500 @enderror"
                            placeholder="Nama penulis" required>
                        @error('author')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Profil Penulis
                        </label>
                        <select name="author_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">-- Pilih Penulis (Opsional) --</option>
                            @foreach(\App\Models\Author::ordered()->get() as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Hubungkan dengan profil penulis untuk menampilkan informasi lengkap</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Penerbit
                        </label>
                        <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Nama penerbit">
                        @error('publisher')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="978-xxx-xxx-xxx-x">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Edisi</label>
                            <input type="text" name="edition" value="{{ old('edition', $book->edition) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="Pertama, Kedua, Revisi, dll">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Halaman</label>
                            <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="0" min="0">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                            <select name="language" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="Indonesia" {{ old('language', $book->language) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                <option value="Inggris" {{ old('language', $book->language) == 'Inggris' ? 'selected' : '' }}>Inggris</option>
                                <option value="Arab" {{ old('language', $book->language) == 'Arab' ? 'selected' : '' }}>Arab</option>
                                <option value="Lainnya" {{ old('language', $book->language) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Terbit</label>
                            <input type="date" name="published_at" value="{{ old('published_at', $book->published_at ? (is_string($book->published_at) ? $book->published_at : $book->published_at->format('Y-m-d')) : '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Jilid</label>
                            <select name="binding_type" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="Softcover" {{ old('binding_type', $book->binding_type) == 'Softcover' ? 'selected' : '' }}>Softcover</option>
                                <option value="Hardcover" {{ old('binding_type', $book->binding_type) == 'Hardcover' ? 'selected' : '' }}>Hardcover</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kertas</label>
                            <select name="paper_type" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="HVS" {{ old('paper_type', $book->paper_type) == 'HVS' ? 'selected' : '' }}>HVS</option>
                                <option value="Bookpaper" {{ old('paper_type', $book->paper_type) == 'Bookpaper' ? 'selected' : '' }}>Bookpaper</option>
                                <option value="Art Paper" {{ old('paper_type', $book->paper_type) == 'Art Paper' ? 'selected' : '' }}>Art Paper</option>
                                <option value="Lainnya" {{ old('paper_type', $book->paper_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dimensi Buku (cm)</label>
                            <input type="text" name="dimensions" value="{{ old('dimensions', $book->dimensions) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="14 x 20 atau 14 x 20 x 1.5">
                            <p class="mt-1 text-xs text-gray-500">Format: Lebar x Tinggi atau Lebar x Tinggi x Tebal</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berat (gram)</label>
                            <input type="number" name="weight" value="{{ old('weight', $book->weight) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="0" min="0" step="0.01">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $book->price) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="0" min="0" step="0.01">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $book->stock ?? 0) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="0" min="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="6" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Tulis deskripsi lengkap tentang buku ini...">{{ old('description', $book->description) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Deskripsi akan membantu pembeli memahami isi buku</p>
                    </div>
                </div>
            </div>

            <!-- Purchase Links Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Link Pembelian</h2>
                
                <div class="space-y-6">
                    <!-- Versi Cetak -->
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="has_print_version" id="has_print_version" value="1" 
                                {{ old('has_print_version', $book->has_print_version ?? false) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="has_print_version" class="ml-3 block text-sm font-medium text-gray-700">
                                Versi Cetak
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Versi Cetak</label>
                            <input type="url" name="print_version_link" value="{{ old('print_version_link', $book->print_version_link) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="https://">
                        </div>
                    </div>

                    <!-- Versi Digital -->
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="has_digital_version" id="has_digital_version" value="1" 
                                {{ old('has_digital_version', $book->has_digital_version ?? false) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="has_digital_version" class="ml-3 block text-sm font-medium text-gray-700">
                                Versi Digital
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Versi Digital</label>
                            <input type="url" name="digital_version_link" value="{{ old('digital_version_link', $book->digital_version_link) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="https://">
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link WhatsApp</label>
                        <div class="flex gap-2">
                            <span class="inline-flex items-center px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-700">
                                https://wa.me/+
                            </span>
                            <input type="text" name="whatsapp_link" value="{{ old('whatsapp_link', $book->whatsapp_link) }}" 
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="62821234567">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Masukkan nomor WhatsApp tanpa tanda + atau 0 di awal (contoh: 62821234567)</p>
                    </div>

                    <!-- Shopee -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Shopee</label>
                        <input type="url" name="shopee_link" value="{{ old('shopee_link', $book->shopee_link) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="https://">
                    </div>

                    <!-- Tokopedia -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Tokopedia</label>
                        <input type="url" name="tokopedia_link" value="{{ old('tokopedia_link', $book->tokopedia_link) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="https://">
                    </div>

                    <!-- Lazada -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Lazada</label>
                        <input type="url" name="lazada_link" value="{{ old('lazada_link', $book->lazada_link) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="https://">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Gambar Sampul</h2>
                
                @if($book->cover)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cover Saat Ini</label>
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="w-32 h-auto rounded-lg border border-gray-300">
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Cover {{ $book->cover ? 'Baru' : '' }}</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Upload file</span>
                                    <input type="file" name="cover" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Multi Images Gallery -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-2">Galeri Katalog</h2>
                <p class="text-sm text-gray-600 mb-6">Upload beberapa gambar untuk katalog buku (maksimal 5 gambar)</p>
                
                @if($book->images && count($book->images) > 0)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Katalog Saat Ini</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($book->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery" class="w-full h-24 object-cover rounded-lg border border-gray-300">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-xs">Akan diganti</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Upload gambar baru akan menggantikan semua gambar yang ada</p>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Katalog</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Upload multiple files</span>
                                    <input type="file" name="images[]" class="sr-only" accept="image/*" multiple id="gallery-images">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB per file</p>
                            <p class="text-xs text-gray-500 font-medium">Bisa pilih beberapa gambar sekaligus</p>
                        </div>
                    </div>
                    <div id="image-preview" class="mt-4 grid grid-cols-3 gap-3"></div>
                </div>
            </div>

            <script>
                document.getElementById('gallery-images').addEventListener('change', function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.innerHTML = '';
                    
                    const files = Array.from(e.target.files).slice(0, 5); // Max 5 images
                    
                    files.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-300">
                                <div class="absolute top-1 right-1 bg-primary-500 text-white text-xs px-2 py-1 rounded">${index + 1}</div>
                            `;
                            preview.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                    
                    if (files.length > 0) {
                        const info = document.createElement('p');
                        info.className = 'col-span-3 text-sm text-gray-600 text-center mt-2';
                        info.textContent = `${files.length} gambar dipilih`;
                        preview.appendChild(info);
                    }
                });
            </script>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.books.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $book->exists ? 'Update Buku' : 'Simpan Buku' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="font-bold text-gray-900 mb-4">Tips Menambahkan Buku</h3>
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
                            <span class="font-semibold">Judul yang jelas</span> membantu pembeli menemukan buku dengan mudah.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Gambar berkualitas</span> akan meningkatkan daya tarik produk.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Deskripsi lengkap</span> memberikan informasi detail yang dibutuhkan pembeli.
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 text-purple-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">ISBN yang valid</span> memudahkan identifikasi dan pencarian buku.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
