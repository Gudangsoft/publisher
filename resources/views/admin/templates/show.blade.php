@extends('layouts.admin')

@section('title', 'Detail Template')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <nav class="text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.templates.index') }}" class="hover:text-primary-600">Template Buku</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $template->name }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">{{ $template->name }}</h1>
            <div class="flex items-center mt-2 space-x-3">
                <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                    {{ $template->book_type_label }}
                </span>
                @if($template->is_active)
                    <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                @else
                    <span class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-600 rounded-full">Nonaktif</span>
                @endif
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.templates.edit', $template) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.templates.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Preview & Description -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @if($template->preview_image)
            <div class="aspect-video bg-gray-100">
                <img src="{{ asset('storage/' . $template->preview_image) }}" 
                     alt="{{ $template->name }}" 
                     class="w-full h-full object-contain">
            </div>
            @endif
            
            @if($template->description)
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                <p class="text-gray-600">{{ $template->description }}</p>
            </div>
            @endif
        </div>

        <!-- Specifications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Spesifikasi Halaman</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 mb-1">Ukuran</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $template->page_size }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 mb-1">Orientasi</p>
                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($template->orientation) }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 mb-1">Font</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $template->font_family ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 mb-1">Ukuran Font</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $template->font_size ? $template->font_size . 'pt' : '-' }}</p>
                </div>
            </div>

            @if($template->margins)
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Margin (cm)</h4>
                <div class="grid grid-cols-4 gap-3">
                    <div class="text-center">
                        <span class="text-xs text-gray-500">Atas</span>
                        <p class="font-medium">{{ $template->margins['top'] ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-500">Bawah</span>
                        <p class="font-medium">{{ $template->margins['bottom'] ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-500">Kiri</span>
                        <p class="font-medium">{{ $template->margins['left'] ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-500">Kanan</span>
                        <p class="font-medium">{{ $template->margins['right'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($template->line_spacing)
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Spasi Baris</h4>
                <p class="text-gray-900">{{ $template->line_spacing }}</p>
            </div>
            @endif
        </div>

        <!-- Additional Specifications -->
        @if($template->specifications && count($template->specifications) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Spesifikasi Tambahan</h3>
            <div class="space-y-3">
                @foreach($template->specifications as $key => $value)
                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                    <span class="text-gray-600">{{ $key }}</span>
                    <span class="font-medium text-gray-900">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
            <div class="space-y-3">
                @if($template->template_file)
                <a href="{{ route('admin.templates.download', $template) }}" 
                   class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Template
                </a>
                @endif

                <form action="{{ route('admin.templates.toggle', $template) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-3 {{ $template->is_active ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-green-600 text-white hover:bg-green-700' }} rounded-lg transition-colors duration-200">
                        @if($template->is_active)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Nonaktifkan
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Aktifkan
                        @endif
                    </button>
                </form>

                <form action="{{ route('admin.templates.destroy', $template) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-3 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Template
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Pengajuan Menggunakan</span>
                    <span class="text-2xl font-bold text-primary-600">{{ $template->submissions->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Urutan Tampil</span>
                    <span class="font-medium">{{ $template->display_order }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Dibuat</span>
                    <span class="text-sm text-gray-500">{{ $template->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Terakhir Update</span>
                    <span class="text-sm text-gray-500">{{ $template->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        @if($template->submissions->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengajuan Terbaru</h3>
            <div class="space-y-3">
                @foreach($template->submissions->take(5) as $submission)
                <a href="{{ route('admin.submissions.show', $submission) }}" 
                   class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $submission->title }}</p>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-gray-500">{{ $submission->submission_number }}</span>
                        <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $submission->status_color }}-100 text-{{ $submission->status_color }}-800">
                            {{ $submission->status_label }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
