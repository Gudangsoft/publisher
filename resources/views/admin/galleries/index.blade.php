@extends('layouts.admin')

@section('title', 'Galeri Foto & Video')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Galeri Foto & Video</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola koleksi foto dan video</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Item
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form action="{{ route('admin.galleries.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, deskripsi..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
            </div>
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 text-sm">
                <option value="">Semua Tipe</option>
                <option value="photo" {{ request('type') == 'photo' ? 'selected' : '' }}>📷 Foto</option>
                <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>🎬 Video</option>
            </select>
            <select name="album" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 text-sm">
                <option value="">Semua Album</option>
                @foreach($albums as $alb)
                <option value="{{ $alb->id }}" {{ request('album') == $alb->id ? 'selected' : '' }}>{{ $alb->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-sm font-medium">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'type', 'album']))
                <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Gallery::photos()->count() }}</p>
                <p class="text-sm text-gray-500">Total Foto</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Gallery::videos()->count() }}</p>
                <p class="text-sm text-gray-500">Total Video</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Gallery::active()->count() }}</p>
                <p class="text-sm text-gray-500">Aktif</p>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    @if($galleries->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($galleries as $gallery)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group hover:shadow-lg transition-all duration-300">
            <!-- Thumbnail -->
            <div class="relative aspect-video bg-gray-100 overflow-hidden">
                @if($gallery->type === 'photo' && $gallery->file_path)
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @elseif($gallery->type === 'video' && $gallery->display_thumbnail)
                    <img src="{{ $gallery->display_thumbnail }}" alt="{{ $gallery->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-red-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        @if($gallery->type === 'video')
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        @else
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        @endif
                    </div>
                @endif

                <!-- Type Badge -->
                <div class="absolute top-2 left-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full {{ $gallery->type === 'photo' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                        @if($gallery->type === 'photo')
                        📷 Foto
                        @else
                        🎬 Video
                        @endif
                    </span>
                </div>

                <!-- Status Badge -->
                <div class="absolute top-2 right-2">
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $gallery->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <!-- Info -->
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 truncate">{{ $gallery->title }}</h3>
                @if($gallery->album)
                <p class="text-xs text-primary-600 font-medium mt-1">{{ $gallery->album->name }}</p>
                @endif
                @if($gallery->description)
                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $gallery->description }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-2">Urutan: {{ $gallery->display_order }} · {{ $gallery->created_at->format('d M Y') }}</p>
            </div>

            <!-- Actions -->
            <div class="px-4 pb-4 flex gap-2">
                <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                   class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('admin.galleries.toggle', $gallery) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-2 rounded-lg transition text-sm font-medium {{ $gallery->is_active ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}" title="{{ $gallery->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                        @if($gallery->is_active)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                        @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        @endif
                    </button>
                </form>
                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" 
                      onsubmit="return confirm('Hapus item galeri ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $galleries->withQueryString()->links() }}
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 py-16 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-500 text-lg mb-2">Belum ada item galeri</p>
        <p class="text-gray-400 text-sm mb-6">Mulai dengan menambahkan foto atau video pertama Anda</p>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Item Pertama
        </a>
    </div>
    @endif
</div>
@endsection
