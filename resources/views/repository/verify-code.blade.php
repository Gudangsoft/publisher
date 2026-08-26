@extends('layouts.app')

@section('title', 'Verifikasi Bukti Submit - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<section class="py-16 bg-gray-50 min-h-[70vh]">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">

                @if($submission)
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Bukti Submit Valid</h1>
                <p class="text-gray-500 mb-6">Kode <span class="font-mono font-semibold">{{ $code }}</span> terdaftar di sistem Repository Skripsi.</p>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left text-sm border-t border-gray-100 pt-6">
                    <div>
                        <dt class="text-gray-500">Nama</dt>
                        <dd class="font-medium text-gray-900">{{ $submission->taruna->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Nomor Akademik</dt>
                        <dd class="font-medium text-gray-900">{{ $submission->taruna->academic_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Korps</dt>
                        <dd class="font-medium text-gray-900">{{ $submission->taruna->korps }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Waktu Submit Terakhir</dt>
                        <dd class="font-medium text-gray-900">{{ $submission->updated_at->format('d M Y, H:i') }} WIB</dd>
                    </div>
                </dl>

                <div class="mt-6 pt-6 border-t border-gray-100 text-left">
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Kelengkapan Berkas</p>
                    <ul class="space-y-1 text-sm">
                        @foreach(\App\Models\ThesisSubmission::FILE_FIELDS as $field => $label)
                        <li class="flex items-center">
                            @if($submission->hasDocument($field))
                            <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4 text-gray-300 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            @endif
                            <span class="text-gray-700">{{ $label }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Kode Tidak Ditemukan</h1>
                <p class="text-gray-500">Kode <span class="font-mono font-semibold">{{ $code }}</span> tidak terdaftar di sistem. Dokumen ini mungkin tidak valid.</p>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection
