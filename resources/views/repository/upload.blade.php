@extends('layouts.app')

@section('title', 'Unggah Skripsi - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<section class="relative py-16 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-display">
                Unggah Berkas Skripsi
            </h1>
            <p class="text-xl text-primary-100">
                {{ $taruna->name }} &middot; {{ $taruna->academic_number }} &middot; {{ $taruna->korps }}
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">

            @if($submission)
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-6 py-4 rounded-lg mb-6 text-sm">
                Anda sudah pernah mengunggah berkas pada <strong>{{ $submission->updated_at->format('d M Y, H:i') }}</strong> (kode: {{ $submission->submission_code }}).
                Mengunggah ulang di bawah ini akan <strong>menimpa</strong> berkas yang lama.
                <a href="{{ route('repository.receipt') }}" class="underline font-medium">Lihat bukti submit saat ini</a>.
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @php
                $docs = [
                    'cover' => ['label' => 'Cover', 'max' => '5MB'],
                    'pengesahan' => ['label' => 'Halaman Pengesahan', 'max' => '5MB'],
                    'abstrak' => ['label' => 'Abstrak', 'max' => '5MB'],
                    'naskah' => ['label' => 'Naskah Skripsi Lengkap', 'max' => '20MB'],
                ];
            @endphp
            <div class="bg-white rounded-2xl shadow-lg p-8"
                x-data="{
                    mode: {
                        @foreach($docs as $field => $d)
                        {{ $field }}: {{ \Illuminate\Support\Js::from(old("{$field}_mode", $submission && $submission->isLink($field) ? 'link' : 'file')) }},
                        @endforeach
                    },
                    confirmOpen: false,
                    captchaInput: '',
                    academicNumber: {{ \Illuminate\Support\Js::from($taruna->academic_number) }},
                    openConfirm() {
                        if (this.$refs.uploadForm.reportValidity()) {
                            this.captchaInput = '';
                            this.confirmOpen = true;
                        }
                    }
                }">
                <form action="{{ route('repository.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="repositoryUploadForm" x-ref="uploadForm">
                    @csrf

                    @foreach($docs as $field => $d)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-sm font-medium text-gray-700">{{ $d['label'] }}</label>
                            <div class="flex items-center text-xs bg-gray-100 rounded-full p-1">
                                <button type="button" @click="mode.{{ $field }} = 'file'"
                                    :class="mode.{{ $field }} === 'file' ? 'bg-white shadow text-primary-700' : 'text-gray-500'"
                                    class="px-3 py-1 rounded-full font-medium transition-colors duration-150">Upload File</button>
                                <button type="button" @click="mode.{{ $field }} = 'link'"
                                    :class="mode.{{ $field }} === 'link' ? 'bg-white shadow text-primary-700' : 'text-gray-500'"
                                    class="px-3 py-1 rounded-full font-medium transition-colors duration-150">Tautan</button>
                            </div>
                        </div>
                        <input type="hidden" name="{{ $field }}_mode" x-bind:value="mode.{{ $field }}">

                        <div x-show="mode.{{ $field }} === 'file'">
                            @if($submission && $submission->{$field . '_path'})
                            <p class="text-xs text-green-600 mb-1">Berkas saat ini: {{ $submission->{$field . '_original_name'} }} &mdash; biarkan kosong untuk tetap memakai berkas ini.</p>
                            @endif
                            <input type="file" name="{{ $field }}" accept=".pdf"
                                class="w-full text-sm border border-gray-300 rounded-lg p-3 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700">
                            <p class="text-xs text-gray-400 mt-1">Format PDF, maksimal {{ $d['max'] }}</p>
                        </div>
                        <div x-show="mode.{{ $field }} === 'link'" x-cloak>
                            <input type="url" name="{{ $field }}_link" value="{{ old("{$field}_link", $submission->{$field . '_url'} ?? '') }}"
                                placeholder="https://drive.google.com/..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <p class="text-xs text-gray-400 mt-1">Tautan Google Drive/OneDrive/lainnya yang bisa diakses publik</p>
                        </div>
                    </div>
                    @endforeach

                    <button type="button" @click="openConfirm()" class="w-full bg-primary-600 text-white py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors duration-200">
                        Submit Skripsi
                    </button>
                </form>

                <!-- Confirmation Modal -->
                <div x-show="confirmOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="confirmOpen = false"></div>
                    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                        <div class="flex items-start mb-4">
                            <svg class="w-8 h-8 text-yellow-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Periksa Kembali Data Anda</h3>
                                <p class="text-sm text-gray-600 mt-1">Pastikan cover, halaman pengesahan, abstrak, dan naskah skripsi yang Anda pilih sudah benar. Setelah submit, berkas ini akan menimpa data sebelumnya (jika ada) dan menjadi bukti resmi pengumpulan skripsi Anda.</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-4 mb-4 text-center">
                            <p class="text-xs text-gray-500 mb-1">Untuk konfirmasi, ketik ulang Nomor Akademik Anda</p>
                            <p class="text-lg font-mono font-bold tracking-widest text-gray-800 select-none">{{ $taruna->academic_number }}</p>
                        </div>

                        <input type="text" name="confirm_academic_number" form="repositoryUploadForm"
                            x-model="captchaInput" autocomplete="off" placeholder="Ketik ulang nomor akademik di atas"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-primary-500 font-mono">

                        <div class="flex space-x-3">
                            <button type="button" @click="confirmOpen = false" class="flex-1 px-4 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                Kembali
                            </button>
                            <button type="submit" form="repositoryUploadForm" :disabled="captchaInput.trim() !== academicNumber"
                                :class="captchaInput.trim() === academicNumber ? 'bg-primary-600 hover:bg-primary-700' : 'bg-gray-300 cursor-not-allowed'"
                                class="flex-1 px-4 py-3 text-white rounded-lg font-semibold transition-colors duration-200">
                                Ya, Submit Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-6">
                <form action="{{ route('repository.reset') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">Bukan Anda? Ganti data</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
