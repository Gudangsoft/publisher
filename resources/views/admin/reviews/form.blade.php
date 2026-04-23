@extends('layouts.admin')

@section('title', $review->exists ? 'Edit Ulasan' : 'Tambah Ulasan')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
    <h1 class="text-3xl font-bold text-gray-900">{{ $review->exists ? 'Edit Ulasan' : 'Tambah Ulasan' }}</h1>
    <p class="text-gray-600 mt-1">{{ $review->exists ? 'Perbarui informasi ulasan' : 'Tambahkan ulasan baru' }}</p>
</div>

@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ $review->exists ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    @csrf
    @if($review->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Reviewer Name -->
        <div class="md:col-span-2">
            <label for="reviewer_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Reviewer *</label>
            <input type="text" id="reviewer_name" name="reviewer_name" value="{{ old('reviewer_name', $review->reviewer_name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
        </div>

        <!-- Reviewer Email -->
        <div>
            <label for="reviewer_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Reviewer</label>
            <input type="email" id="reviewer_email" name="reviewer_email" value="{{ old('reviewer_email', $review->reviewer_email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
        </div>

        <!-- Rating -->
        <div>
            <label for="rating" class="block text-sm font-semibold text-gray-700 mb-2">Rating *</label>
            <select id="rating" name="rating" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option value="">Pilih Rating</option>
                @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                    {{ $i }} Bintang
                </option>
                @endfor
            </select>
        </div>

        <!-- Type -->
        <div>
            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Tipe *</label>
            <select id="type" name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option value="">Pilih Tipe</option>
                <option value="book" {{ old('type', $review->type) == 'book' ? 'selected' : '' }}>Review Buku</option>
                <option value="publisher" {{ old('type', $review->type) == 'publisher' ? 'selected' : '' }}>Testimoni Publisher</option>
            </select>
        </div>

        <!-- Book Selection -->
        <div>
            <label for="book_id" class="block text-sm font-semibold text-gray-700 mb-2">Buku (Opsional untuk testimoni)</label>
            <select id="book_id" name="book_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option value="">Tidak ada (Testimoni umum)</option>
                @foreach($books as $book)
                <option value="{{ $book->id }}" {{ old('book_id', $review->book_id) == $book->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Reviewer Photo -->
        <div class="md:col-span-2">
            <label for="reviewer_photo" class="block text-sm font-semibold text-gray-700 mb-2">Foto Reviewer</label>
            @if($review->reviewer_photo)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $review->reviewer_photo) }}" alt="Current photo" class="w-24 h-24 rounded-full object-cover">
            </div>
            @endif
            <input type="file" id="reviewer_photo" name="reviewer_photo" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB.</p>
        </div>

        <!-- Review Text -->
        <div class="md:col-span-2">
            <label for="review_text" class="block text-sm font-semibold text-gray-700 mb-2">Teks Ulasan *</label>
            <textarea id="review_text" name="review_text" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">{{ old('review_text', $review->review_text) }}</textarea>
        </div>

        <!-- Checkboxes -->
        <div class="md:col-span-2 space-y-4">
            <div class="flex items-center">
                <input type="checkbox" id="is_approved" name="is_approved" value="1" {{ old('is_approved', $review->is_approved) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <label for="is_approved" class="ml-3 text-sm font-medium text-gray-700">Disetujui</label>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $review->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">Tampilkan di Homepage (Featured)</label>
            </div>
        </div>
    </div>

    <div class="mt-8 flex items-center justify-end space-x-4">
        <a href="{{ route('admin.reviews.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200">
            Batal
        </a>
        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            {{ $review->exists ? 'Update Ulasan' : 'Simpan Ulasan' }}
        </button>
    </div>
</form>
@endsection
