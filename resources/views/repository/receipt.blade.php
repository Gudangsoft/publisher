@extends('layouts.app')

@section('title', 'Bukti Submit Skripsi - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<section class="relative py-16 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-display">
                Skripsi Berhasil Diunggah
            </h1>
            <p class="text-xl text-primary-100">
                Simpan atau unduh bukti submit di bawah ini sebagai tanda pengumpulan skripsi Anda.
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6 text-sm">
                {{ session('error') }}
            </div>
            @endif
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="text-center mb-6 pb-6 border-b border-gray-200">
                    <p class="text-sm text-gray-500">Kode Bukti Submit</p>
                    <p class="text-2xl font-bold text-primary-600 font-mono">{{ $submission->submission_code }}</p>
                    <p class="mt-3">
                        @if($submission->is_published)
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Sudah Dipublikasikan</span>
                        @else
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Menunggu Review Admin</span>
                        @endif
                    </p>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-sm">
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500">Judul Skripsi</dt>
                        <dd class="font-medium text-gray-900">{{ $submission->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Nama</dt>
                        <dd class="font-medium text-gray-900">{{ $taruna->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Nomor Akademik</dt>
                        <dd class="font-medium text-gray-900">{{ $taruna->academic_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Korps / Angkatan</dt>
                        <dd class="font-medium text-gray-900">{{ $taruna->korps }} / {{ $taruna->angkatan }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Waktu Submit Terakhir</dt>
                        <dd class="font-medium text-gray-900">{{ $submission->updated_at->format('d M Y, H:i') }} WIB</dd>
                    </div>
                </dl>

                <div class="border border-gray-200 rounded-lg overflow-hidden mb-8">
                    @foreach(\App\Models\ThesisSubmission::FILE_FIELDS as $field => $label)
                    <div class="flex items-center justify-between px-4 py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $label }}
                                    @if(!\App\Models\ThesisSubmission::isPublicField($field))
                                    <span class="text-xs text-gray-400 font-normal">(tidak publik)</span>
                                    @endif
                                </p>
                                @if($submission->isLink($field))
                                <a href="{{ $submission->documentUrl($field) }}" target="_blank" class="text-xs text-primary-600 hover:underline break-all">{{ $submission->documentLabel($field) }}</a>
                                @else
                                <p class="text-xs text-gray-500">{{ $submission->documentLabel($field) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if(!$submission->is_published)
                <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg px-4 py-3 mb-4 text-sm text-center">
                    Bukti submit (PDF) akan tersedia untuk diunduh setelah admin memvalidasi berkas Anda.
                </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3">
                    @if($submission->is_published)
                    <a href="{{ route('repository.receipt.download') }}" target="_blank" class="flex-1 text-center bg-primary-600 text-white py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors duration-200">
                        Lihat & Unduh Bukti Submit (PDF)
                    </a>
                    @else
                    <span class="flex-1 text-center bg-gray-200 text-gray-400 py-3 rounded-lg font-semibold cursor-not-allowed" title="Belum divalidasi admin">
                        Bukti Submit (PDF) &mdash; Menunggu Validasi
                    </span>
                    @endif
                    <a href="{{ route('repository.upload') }}" class="flex-1 text-center bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                        Ganti Berkas
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
