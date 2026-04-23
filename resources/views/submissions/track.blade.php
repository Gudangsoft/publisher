@extends('layouts.app')

@section('title', 'Lacak Pengajuan - ' . \App\Models\Setting::get('site_name', 'Publisher'))

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
                Lacak Status Pengajuan
            </h1>
            <p class="text-xl text-primary-100">
                Masukkan nomor pengajuan untuk melihat status terkini naskah Anda
            </p>
        </div>
    </div>
</section>

<!-- Track Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Search Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <form action="{{ route('submissions.track') }}" method="GET" class="space-y-6">
                    <div>
                        <label for="number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Pengajuan
                        </label>
                        <div class="flex gap-4">
                            <input type="text" name="number" id="number" 
                                   value="{{ request('number') }}"
                                   placeholder="Contoh: SUB202603040001"
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-lg"
                                   required>
                            <button type="submit" 
                                    class="bg-primary-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-primary-700 transition-colors flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(request('number'))
                @if($submission)
                <!-- Submission Result -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Status Pengajuan</h2>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                'reviewing' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'revision' => 'bg-orange-100 text-orange-800 border-orange-300',
                                'approved' => 'bg-green-100 text-green-800 border-green-300',
                                'rejected' => 'bg-red-100 text-red-800 border-red-300',
                                'in_progress' => 'bg-purple-100 text-purple-800 border-purple-300',
                                'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold border {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
                            {{ $submission->status_label }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <label class="text-sm text-gray-500">Nomor Pengajuan</label>
                                <p class="font-mono font-bold text-primary-600">{{ $submission->submission_number }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <label class="text-sm text-gray-500">Jenis</label>
                                <p class="font-medium">{{ $submission->type_label }}</p>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="text-sm text-gray-500">Judul</label>
                            <p class="font-semibold text-lg text-gray-900">{{ $submission->title }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <label class="text-sm text-gray-500">Tanggal Pengajuan</label>
                                <p class="font-medium">{{ $submission->created_at->format('d F Y') }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <label class="text-sm text-gray-500">Terakhir Diperbarui</label>
                                <p class="font-medium">{{ $submission->updated_at->format('d F Y') }}</p>
                            </div>
                        </div>

                        @if($submission->category)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="text-sm text-gray-500">Kategori</label>
                            <p class="font-medium">{{ $submission->category->name }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Status Timeline -->
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Progress Pengajuan</h3>
                        <div class="relative">
                            @php
                                $statuses = ['pending', 'reviewing', 'approved', 'in_progress', 'completed'];
                                $statusLabels = [
                                    'pending' => 'Menunggu Review',
                                    'reviewing' => 'Sedang Direview', 
                                    'approved' => 'Disetujui',
                                    'in_progress' => 'Proses Cetak',
                                    'completed' => 'Selesai'
                                ];
                                $currentIndex = array_search($submission->status, $statuses);
                                if ($submission->status == 'revision') $currentIndex = 1;
                                if ($submission->status == 'rejected') $currentIndex = 1;
                            @endphp
                            
                            <div class="flex justify-between items-center">
                                @foreach($statuses as $index => $status)
                                <div class="flex flex-col items-center flex-1">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $index <= $currentIndex ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                        @if($index < $currentIndex)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <span class="text-xs mt-2 text-center {{ $index <= $currentIndex ? 'text-primary-600 font-medium' : 'text-gray-500' }}">
                                        {{ $statusLabels[$status] }}
                                    </span>
                                </div>
                                @if(!$loop->last)
                                <div class="flex-1 h-1 {{ $index < $currentIndex ? 'bg-primary-600' : 'bg-gray-200' }} -mx-2"></div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Revision/Rejection Notes -->
                    @if($submission->status == 'revision' && $submission->revision_notes)
                    <div class="mt-8 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-orange-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-orange-800">Catatan Revisi</p>
                                <p class="text-sm text-orange-700 mt-1 whitespace-pre-line">{{ $submission->revision_notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($submission->status == 'rejected' && $submission->revision_notes)
                    <div class="mt-8 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-red-800">Alasan Penolakan</p>
                                <p class="text-sm text-red-700 mt-1 whitespace-pre-line">{{ $submission->revision_notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($submission->status == 'approved' && ($submission->estimated_cost || $submission->print_quantity))
                    <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <p class="font-medium text-green-800">Pengajuan Disetujui!</p>
                                <div class="grid grid-cols-2 gap-4 mt-3">
                                    @if($submission->print_quantity)
                                    <div>
                                        <span class="text-sm text-green-600">Jumlah Cetak</span>
                                        <p class="font-bold text-green-800">{{ number_format($submission->print_quantity) }} eksemplar</p>
                                    </div>
                                    @endif
                                    @if($submission->estimated_cost)
                                    <div>
                                        <span class="text-sm text-green-600">Estimasi Biaya</span>
                                        <p class="font-bold text-green-800">Rp {{ number_format($submission->estimated_cost, 0, ',', '.') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <p class="text-gray-600">
                            Ada pertanyaan? Hubungi kami melalui 
                            <a href="{{ route('contact') }}" class="text-primary-600 hover:underline font-medium">halaman kontak</a>
                        </p>
                    </div>
                </div>
                @else
                <!-- Not Found -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengajuan Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6">
                        Nomor pengajuan <strong class="font-mono">{{ request('number') }}</strong> tidak ditemukan dalam sistem kami.
                    </p>
                    <p class="text-sm text-gray-500">
                        Pastikan Anda memasukkan nomor pengajuan dengan benar. Jika masih bermasalah, silakan hubungi kami.
                    </p>
                </div>
                @endif
            @endif

            <!-- Submit New CTA -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Belum mengajukan naskah? 
                    <a href="{{ route('submissions.create') }}" class="text-primary-600 hover:underline font-medium">
                        Ajukan naskah sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
