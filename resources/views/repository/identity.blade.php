@extends('layouts.app')

@section('title', 'Repository Skripsi - ' . \App\Models\Setting::get('site_name', 'Publisher'))

@section('content')
<section class="relative py-16 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-display">
                Repository Skripsi
            </h1>
            <p class="text-xl text-primary-100">
                Unggah cover, halaman pengesahan, abstrak, dan naskah skripsi Anda di sini.
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">1</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Verifikasi Identitas</h3>
                    <p class="text-gray-600 text-sm">Isi nama, nomor akademik, dan korps Anda</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">2</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Unggah Berkas</h3>
                    <p class="text-gray-600 text-sm">Cover, halaman pengesahan, abstrak, naskah</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">3</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Bukti Submit</h3>
                    <p class="text-gray-600 text-sm">Unduh tanda bukti pengumpulan skripsi Anda</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8"
                x-data="{
                    academicNumber: {{ \Illuminate\Support\Js::from(old('academic_number', '')) }},
                    name: {{ \Illuminate\Support\Js::from(old('name', '')) }},
                    korps: {{ \Illuminate\Support\Js::from(old('korps', '')) }},
                    lookupStatus: '',
                    lookupTimer: null,
                    onAcademicNumberInput() {
                        clearTimeout(this.lookupTimer);
                        this.lookupStatus = '';
                        if (this.academicNumber.trim().length < 3) return;
                        this.lookupTimer = setTimeout(() => this.doLookup(), 500);
                    },
                    async doLookup() {
                        this.lookupStatus = 'loading';
                        try {
                            const res = await fetch('{{ route('repository.lookup') }}?academic_number=' + encodeURIComponent(this.academicNumber.trim()));
                            const data = await res.json();
                            if (data.found) {
                                this.name = data.name;
                                this.korps = data.korps;
                                this.lookupStatus = 'found';
                            } else {
                                this.lookupStatus = 'not-found';
                            }
                        } catch (e) {
                            this.lookupStatus = '';
                        }
                    }
                }">
                <h2 class="text-xl font-semibold text-gray-900 mb-1">Verifikasi Identitas</h2>
                <p class="text-sm text-gray-500 mb-6">Data Anda harus sudah terdaftar di daftar taruna tingkat akhir. Hubungi admin jika belum terdaftar.</p>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('repository.verify') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Akademik</label>
                        <input type="text" name="academic_number" x-model="academicNumber" @input="onAcademicNumberInput()" required autofocus autocomplete="off"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs mt-1" x-cloak
                            x-show="lookupStatus"
                            :class="{ 'text-gray-400': lookupStatus === 'loading', 'text-green-600': lookupStatus === 'found', 'text-yellow-600': lookupStatus === 'not-found' }">
                            <span x-show="lookupStatus === 'loading'">Mencari data...</span>
                            <span x-show="lookupStatus === 'found'">✓ Data ditemukan, nama dan korps terisi otomatis.</span>
                            <span x-show="lookupStatus === 'not-found'">Nomor akademik belum terdaftar, isi nama dan korps secara manual.</span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Korps</label>
                        <input type="text" name="korps" x-model="korps" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors duration-200">
                        Lanjutkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
