@extends('layouts.admin')

@section('title', 'Ulasan')

@section('content')
<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Ulasan</h1>
        <p class="text-gray-600 mt-1">Kelola ulasan dan rating dari pelanggan</p>
    </div>
    <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Ulasan
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
    {{ session('success') }}
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Ulasan</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reviews->total() }}</p>
            </div>
            <div class="bg-primary-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Rating Rata-rata</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reviews->count() > 0 ? number_format($reviews->avg('rating'), 1) : '0.0' }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Disetujui</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reviews->where('is_approved', true)->count() }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reviews->where('is_approved', false)->count() }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>


<!-- Reviews Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="divide-y divide-gray-200">
        @forelse($reviews as $review)
        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-start space-x-4">
                    @if($review->reviewer_photo)
                    <img src="{{ asset('storage/' . $review->reviewer_photo) }}" alt="{{ $review->reviewer_name }}" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                    @else
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                        {{ strtoupper(substr($review->reviewer_name, 0, 2)) }}
                    </div>
                    @endif
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h3 class="font-semibold text-gray-900 mr-3">{{ $review->reviewer_name }}</h3>
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 {{ $i < $review->rating ? 'fill-current' : 'fill-gray-300' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500 ml-3">{{ $review->created_at->format('d M Y') }}</span>
                        </div>
                        @if($review->book)
                        <p class="text-sm text-gray-600 mb-2">Untuk buku: <span class="font-semibold text-gray-900">{{ $review->book->title }}</span></p>
                        @else
                        <p class="text-sm text-gray-600 mb-2"><span class="font-semibold text-gray-900">Testimoni Publisher</span></p>
                        @endif
                        <p class="text-gray-700">{{ $review->review_text }}</p>
                        
                        @if($review->is_featured)
                        <span class="inline-flex items-center px-2 py-1 mt-2 rounded text-xs font-medium bg-purple-100 text-purple-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Featured
                        </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2 ml-4">
                    @if($review->is_approved)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Disetujui
                    </span>
                    @else
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_approved" value="1">
                        <input type="hidden" name="book_id" value="{{ $review->book_id }}">
                        <input type="hidden" name="reviewer_name" value="{{ $review->reviewer_name }}">
                        <input type="hidden" name="reviewer_email" value="{{ $review->reviewer_email }}">
                        <input type="hidden" name="review_text" value="{{ $review->review_text }}">
                        <input type="hidden" name="rating" value="{{ $review->rating }}">
                        <input type="hidden" name="type" value="{{ $review->type }}">
                        <input type="hidden" name="is_featured" value="{{ $review->is_featured ? 1 : 0 }}">
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs font-medium rounded-full hover:bg-green-700 transition-colors duration-200">
                            Setujui
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('admin.reviews.edit', $review) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada ulasan</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan ulasan pertama.</p>
            <div class="mt-6">
                <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Ulasan
                </a>
            </div>
        </div>
        @endforelse
    </div>
    
    @if($reviews->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
