@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<!-- Success Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-emerald-100 min-h-[70vh] flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-display">
                Pengajuan Berhasil!
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Terima kasih telah mengajukan naskah Anda. Tim kami akan segera mereview pengajuan Anda.
            </p>
            
            <!-- Submission Details Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 text-left">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 text-center">Detail Pengajuan</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Nomor Pengajuan</span>
                        <span class="font-mono text-lg font-bold text-primary-600">{{ $submission->submission_number }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Judul</span>
                        <span class="font-medium text-gray-900">{{ Str::limit($submission->title, 40) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Jenis</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $submission->type == 'book' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $submission->type_label }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            {{ $submission->status_label }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Tanggal Pengajuan</span>
                        <span class="font-medium text-gray-900">{{ $submission->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-primary-50 rounded-lg border border-primary-200">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-primary-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-medium text-primary-800">Simpan Nomor Pengajuan Anda!</p>
                            <p class="text-sm text-primary-700 mt-1">
                                Gunakan nomor <strong>{{ $submission->submission_number }}</strong> untuk melacak status pengajuan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Langkah Selanjutnya</h2>
                
                <div class="space-y-4 text-left">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-primary-600 font-bold">1</span>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Konfirmasi Email</p>
                            <p class="text-sm text-gray-600">Kami akan mengirimkan email konfirmasi ke {{ $submission->submitter_email }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-primary-600 font-bold">2</span>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Review Naskah</p>
                            <p class="text-sm text-gray-600">Tim editorial kami akan mereview naskah Anda dalam 3-7 hari kerja</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-primary-600 font-bold">3</span>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Hasil Review</p>
                            <p class="text-sm text-gray-600">Kami akan menghubungi Anda melalui email/telepon untuk hasil review</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('submissions.track') }}?number={{ $submission->submission_number }}" 
                   class="bg-primary-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-primary-700 transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lacak Pengajuan
                </a>
                <a href="{{ route('home') }}" 
                   class="bg-gray-200 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-300 transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
