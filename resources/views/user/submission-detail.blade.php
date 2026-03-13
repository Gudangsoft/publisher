@extends('layouts.app')

@section('title', $submission->title . ' - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-primary-600">Dashboard</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('user.submissions') }}" class="text-gray-500 hover:text-primary-600">Submisi</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium truncate max-w-xs">{{ $submission->title }}</li>
            </ol>
        </nav>

        <!-- Status Banner -->
        @php
        $statusKey = $submission->status;
        if ($statusKey === 'in_review') {
            $statusKey = 'reviewing';
        } elseif ($statusKey === 'revision_required') {
            $statusKey = 'revision';
        }

        $statusConfig = [
            'pending' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'clock', 'label' => 'Menunggu Review', 'description' => 'Naskah Anda sedang menunggu untuk direview oleh tim editor kami.'],
            'reviewing' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800', 'icon' => 'eye', 'label' => 'Sedang Direview', 'description' => 'Naskah Anda sedang dalam proses review oleh tim editor.'],
            'revision' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-800', 'icon' => 'edit', 'label' => 'Perlu Revisi', 'description' => 'Naskah Anda memerlukan beberapa revisi. Silakan lihat catatan dari editor di bawah.'],
            'approved' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-800', 'icon' => 'check', 'label' => 'Disetujui', 'description' => 'Selamat! Naskah Anda telah disetujui dan akan segera diproses untuk penerbitan.'],
            'rejected' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800', 'icon' => 'x', 'label' => 'Ditolak', 'description' => 'Mohon maaf, naskah Anda tidak dapat dilanjutkan. Silakan lihat alasan penolakan di bawah.'],
            'in_progress' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-800', 'icon' => 'printer', 'label' => 'Dalam Produksi', 'description' => 'Naskah Anda sedang dalam tahap produksi/pencetakan.'],
            'completed' => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-800', 'icon' => 'check-circle', 'label' => 'Selesai', 'description' => 'Proses penerbitan naskah Anda telah selesai.'],
        ];
        $config = $statusConfig[$statusKey] ?? $statusConfig['pending'];
        @endphp
        <div class="{{ $config['bg'] }} {{ $config['border'] }} border rounded-xl p-6 mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if($config['icon'] == 'clock')
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @elseif($config['icon'] == 'eye')
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    @elseif($config['icon'] == 'edit')
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    @elseif($config['icon'] == 'check')
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    @elseif($config['icon'] == 'x')
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    @elseif($config['icon'] == 'printer')
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    @else
                    <svg class="w-6 h-6 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @endif
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold {{ $config['text'] }}">{{ $config['label'] }}</h3>
                    <p class="text-sm mt-1 {{ $config['text'] }} opacity-80">{{ $config['description'] }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $submission->title }}</h1>
                        <p class="text-gray-500 mt-1">{{ $submission->submission_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="p-6 space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Jenis Naskah</h4>
                        <p class="text-gray-900">{{ $submission->type_label ?? ucfirst($submission->type) }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Kategori</h4>
                        <p class="text-gray-900">{{ $submission->category->name ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Estimasi Halaman</h4>
                        <p class="text-gray-900">{{ $submission->estimated_pages ?? '-' }} halaman</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Bahasa</h4>
                        <p class="text-gray-900">{{ $submission->language ?? 'Indonesia' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Target Pembaca</h4>
                        <p class="text-gray-900">{{ $submission->target_audience ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Tanggal Pengajuan</h4>
                        <p class="text-gray-900">{{ $submission->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>

                @if($submission->synopsis)
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Sinopsis</h4>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700 text-sm">
                        {!! nl2br(e($submission->synopsis)) !!}
                    </div>
                </div>
                @endif

                @if($submission->description)
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Deskripsi</h4>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700 text-sm">
                        {!! nl2br(e($submission->description)) !!}
                    </div>
                </div>
                @endif

                <!-- Files -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">File Terlampir</h4>
                    <div class="space-y-2">
                        @if($submission->manuscript_file)
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-700">Naskah</span>
                            </div>
                            <a href="{{ asset('storage/' . $submission->manuscript_file) }}" target="_blank" class="text-sm text-primary-600 hover:underline">Download</a>
                        </div>
                        @endif
                        @if($submission->cover_proposal)
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-700">Proposal Cover</span>
                            </div>
                            <a href="{{ asset('storage/' . $submission->cover_proposal) }}" target="_blank" class="text-sm text-primary-600 hover:underline">Download</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Revision Notes (if any) -->
                @if($submission->revision_notes)
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <h4 class="font-semibold text-orange-800 mb-2">Catatan dari Editor</h4>
                    <div class="text-sm text-orange-700">
                        {!! nl2br(e($submission->revision_notes)) !!}
                    </div>
                </div>
                @endif

                <!-- Admin Notes (if any) -->
                @if($submission->admin_notes && $submission->status == 'approved')
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="font-semibold text-green-800 mb-2">Catatan</h4>
                    <div class="text-sm text-green-700">
                        {!! nl2br(e($submission->admin_notes)) !!}
                    </div>
                </div>
                @endif

                <!-- Estimated Cost (if approved) -->
                @if($submission->status == 'approved' && $submission->estimated_cost)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-800 mb-2">Estimasi Biaya</h4>
                    <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($submission->estimated_cost, 0, ',', '.') }}</p>
                    @if($submission->print_quantity)
                    <p class="text-sm text-blue-700 mt-1">Untuk cetak {{ $submission->print_quantity }} eksemplar</p>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('user.submissions') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Submisi
            </a>
        </div>
    </div>
</div>
@endsection
