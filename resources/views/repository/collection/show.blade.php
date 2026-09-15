@extends('layouts.app')

@section('title', $submission->title . ' - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<section class="relative py-16 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto">
            <a href="{{ route('repository.collection') }}" class="text-primary-100 hover:text-white text-sm mb-4 inline-block">&larr; Kembali ke koleksi</a>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3 font-display">
                {{ $submission->title }}
            </h1>
            <p class="text-lg text-primary-100">
                {{ $submission->taruna->name }} &middot; {{ $submission->taruna->korps }} &middot; Angkatan {{ $submission->taruna->angkatan }}
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <p class="text-xs text-gray-400 mb-6">Dipublikasikan {{ $submission->published_at?->format('d M Y') }} &middot; Kode: <span class="font-mono">{{ $submission->submission_code }}</span></p>

                <h2 class="text-lg font-semibold text-gray-900 mb-4">Berkas Publik</h2>
                <ul class="divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden mb-6">
                    @foreach(\App\Models\ThesisSubmission::PUBLIC_FIELDS as $field)
                    <li class="flex items-center justify-between px-4 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ \App\Models\ThesisSubmission::FILE_FIELDS[$field] }}</p>
                            <p class="text-xs text-gray-500">{{ $submission->documentLabel($field) }}</p>
                        </div>
                        <a href="{{ $submission->documentUrl($field) }}" target="_blank" class="text-primary-600 hover:underline text-sm font-medium">Buka</a>
                    </li>
                    @endforeach
                </ul>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                    Bab IV dan Bab V tidak dipublikasikan untuk umum. Hubungi admin/perpustakaan untuk akses lebih lanjut.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
