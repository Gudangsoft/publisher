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
                Unggah cover, lembar pengesahan, abstrak, dan naskah skripsi Anda di sini.
            </p>
            <a href="{{ route('repository.collection') }}" class="inline-block mt-4 text-primary-100 underline hover:text-white">Lihat koleksi skripsi yang sudah terbit &rarr;</a>
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
                    <p class="text-gray-600 text-sm">Pilih korps &amp; angkatan, lalu cari nama Anda</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">2</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Unggah Berkas</h3>
                    <p class="text-gray-600 text-sm">Cover, pengesahan, abstrak, naskah per bab</p>
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
                    korps: {{ \Illuminate\Support\Js::from(old('korps', '')) }},
                    angkatan: {{ \Illuminate\Support\Js::from(old('angkatan', '')) }},
                    query: {{ \Illuminate\Support\Js::from(old('name', '')) }},
                    academicNumber: {{ \Illuminate\Support\Js::from(old('academic_number', '')) }},
                    name: {{ \Illuminate\Support\Js::from(old('name', '')) }},
                    results: [],
                    searching: false,
                    searchTimer: null,
                    selected: false,
                    get canSearch() { return this.korps && this.angkatan },
                    onScopeChange() {
                        this.results = [];
                        this.selected = false;
                        this.academicNumber = '';
                        this.name = '';
                        this.query = '';
                    },
                    onQueryInput() {
                        this.selected = false;
                        this.academicNumber = '';
                        this.name = this.query;
                        clearTimeout(this.searchTimer);
                        if (!this.canSearch) return;
                        this.searchTimer = setTimeout(() => this.doSearch(), 400);
                    },
                    async doSearch() {
                        this.searching = true;
                        try {
                            const params = new URLSearchParams({ korps: this.korps, angkatan: this.angkatan, q: this.query });
                            const res = await fetch('{{ route('repository.search') }}?' + params.toString());
                            const data = await res.json();
                            this.results = data.results || [];
                        } catch (e) {
                            this.results = [];
                        }
                        this.searching = false;
                    },
                    selectResult(r) {
                        this.name = r.name;
                        this.academicNumber = r.academic_number;
                        this.query = r.name;
                        this.results = [];
                        this.selected = true;
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
                    <input type="hidden" name="korps" x-model="korps">
                    <input type="hidden" name="angkatan" x-model="angkatan">
                    <input type="hidden" name="academic_number" x-model="academicNumber">
                    <input type="hidden" name="name" x-model="name">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Korps</label>
                            <div class="grid grid-cols-5 gap-2">
                                @foreach($korpsOptions as $k)
                                <button type="button" @click="korps = '{{ $k }}'; onScopeChange()"
                                    :class="korps === '{{ $k }}' ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                                    class="py-2 rounded-lg border font-semibold transition-colors duration-150">{{ $k }}</button>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                            <select x-model="angkatan" @change="onScopeChange()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Pilih</option>
                                @foreach($angkatanOptions as $a)
                                <option value="{{ $a }}">{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div x-show="!canSearch" x-cloak class="text-xs text-gray-400">Pilih korps dan angkatan terlebih dahulu.</div>

                    <div x-show="canSearch" x-cloak class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / Nomor Akademik</label>
                        <input type="text" x-model="query" @input="onQueryInput()" autocomplete="off" placeholder="Ketik nama atau nomor akademik..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">

                        <div x-show="searching" class="text-xs text-gray-400 mt-1">Mencari...</div>

                        <ul x-show="results.length > 0" x-cloak class="absolute z-10 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-56 overflow-y-auto">
                            <template x-for="r in results" :key="r.id">
                                <li @click="selectResult(r)" class="px-4 py-3 hover:bg-primary-50 cursor-pointer border-b border-gray-100 last:border-0">
                                    <p class="text-sm font-medium text-gray-900" x-text="r.name"></p>
                                    <p class="text-xs text-gray-500 font-mono" x-text="r.academic_number"></p>
                                </li>
                            </template>
                        </ul>

                        <p x-show="canSearch && !searching && query.length > 0 && results.length === 0 && !selected" x-cloak class="text-xs text-yellow-600 mt-1">
                            Tidak ditemukan di korps &amp; angkatan ini. Periksa ejaan, atau hubungi admin jika data belum terdaftar.
                        </p>
                    </div>

                    <div x-show="selected" x-cloak class="bg-green-50 border border-green-200 rounded-lg p-4 text-sm">
                        <p class="font-semibold text-green-800" x-text="name"></p>
                        <p class="text-green-700 font-mono" x-text="academicNumber"></p>
                    </div>

                    <button type="submit" :disabled="!selected"
                        :class="selected ? 'bg-primary-600 hover:bg-primary-700' : 'bg-gray-300 cursor-not-allowed'"
                        class="w-full text-white py-3 rounded-lg font-semibold transition-colors duration-200">
                        Lanjutkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
