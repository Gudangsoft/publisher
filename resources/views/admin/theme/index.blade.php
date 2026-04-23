@extends('layouts.admin')

@section('title', 'Pengaturan Tema & Layout')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Pengaturan Tema & Layout</h1>
    <p class="text-gray-600 mt-1">Kustomisasi tampilan dan nuansa website Anda</p>
</div>

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg flex items-center">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('admin.theme.update') }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Warna Tema -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                    Warna Tema
                </h2>
                <p class="text-sm text-gray-500 mb-6">Pilih warna utama website Anda</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($colorPresets as $key => $preset)
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="theme_color" value="{{ $key }}" class="sr-only peer" {{ $settings['theme_color'] === $key ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-4 transition-all peer-checked:border-gray-900 peer-checked:shadow-lg border-gray-200 hover:border-gray-400">
                            <div class="flex items-center space-x-2 mb-3">
                                <div class="w-8 h-8 rounded-full shadow-inner" style="background-color: {{ $preset['primary'] }}"></div>
                                <span class="text-sm font-medium text-gray-700">{{ $preset['name'] }}</span>
                            </div>
                            <div class="flex space-x-1">
                                @foreach([300, 400, 500, 600, 700] as $shade)
                                <div class="flex-1 h-4 rounded" style="background-color: {{ $preset['shades'][$shade] }}"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="absolute top-2 right-2 hidden peer-checked:block">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('theme_color')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Font -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    Tipografi
                </h2>
                <p class="text-sm text-gray-500 mb-6">Atur font untuk tampilan website</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Font Body (Teks Utama)</label>
                        <select name="theme_font" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @foreach($fontOptions as $key => $font)
                            <option value="{{ $key }}" {{ $settings['theme_font'] === $key ? 'selected' : '' }}>{{ $font['name'] }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-500">Font untuk paragraf dan teks umum</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Font Display (Judul)</label>
                        <select name="theme_display_font" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @foreach($displayFontOptions as $key => $font)
                            <option value="{{ $key }}" {{ $settings['theme_display_font'] === $key ? 'selected' : '' }}>{{ $font['name'] }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-500">Font untuk heading dan judul besar</p>
                    </div>
                </div>
            </div>

            <!-- Layout & Komponen -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                    </svg>
                    Layout & Komponen
                </h2>
                <p class="text-sm text-gray-500 mb-6">Atur tata letak dan gaya komponen website</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Layout -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Layout Website</label>
                        <select name="theme_layout" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @foreach($layoutOptions as $key => $label)
                            <option value="{{ $key }}" {{ $settings['theme_layout'] === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Navbar Style -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gaya Navbar</label>
                        <select name="theme_navbar_style" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="light" {{ $settings['theme_navbar_style'] === 'light' ? 'selected' : '' }}>Terang</option>
                            <option value="dark" {{ $settings['theme_navbar_style'] === 'dark' ? 'selected' : '' }}>Gelap</option>
                            <option value="transparent" {{ $settings['theme_navbar_style'] === 'transparent' ? 'selected' : '' }}>Transparan</option>
                        </select>
                    </div>

                    <!-- Footer Style -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gaya Footer</label>
                        <select name="theme_footer_style" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="dark" {{ $settings['theme_footer_style'] === 'dark' ? 'selected' : '' }}>Gelap</option>
                            <option value="light" {{ $settings['theme_footer_style'] === 'light' ? 'selected' : '' }}>Terang</option>
                        </select>
                    </div>

                    <!-- Hero Style -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gaya Hero Section</label>
                        <select name="theme_hero_style" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="slider" {{ $settings['theme_hero_style'] === 'slider' ? 'selected' : '' }}>Slider (Carousel)</option>
                            <option value="static" {{ $settings['theme_hero_style'] === 'static' ? 'selected' : '' }}>Statis (Gambar Tunggal)</option>
                            <option value="minimal" {{ $settings['theme_hero_style'] === 'minimal' ? 'selected' : '' }}>Minimal (Teks Saja)</option>
                        </select>
                    </div>

                    <!-- Border Radius -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gaya Sudut (Border Radius)</label>
                        <select name="theme_border_radius" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="none" {{ $settings['theme_border_radius'] === 'none' ? 'selected' : '' }}>Lancip (Tanpa Radius)</option>
                            <option value="rounded" {{ $settings['theme_border_radius'] === 'rounded' ? 'selected' : '' }}>Rounded (Default)</option>
                            <option value="pill" {{ $settings['theme_border_radius'] === 'pill' ? 'selected' : '' }}>Pill (Sangat Bulat)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Custom CSS -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    Custom CSS
                </h2>
                <p class="text-sm text-gray-500 mb-4">Tambahkan CSS kustom untuk penyesuaian lanjutan</p>

                <textarea name="theme_custom_css" rows="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 font-mono text-sm"
                    placeholder="/* Masukkan CSS kustom di sini */&#10;.my-class {&#10;    color: red;&#10;}">{{ old('theme_custom_css', $settings['theme_custom_css']) }}</textarea>
                <p class="mt-2 text-xs text-gray-500">CSS ini akan diterapkan di semua halaman publik website</p>
                @error('theme_custom_css')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Pengaturan Tema
                </button>
            </div>
        </div>

        <!-- Right Column - Preview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Preview Warna
                </h3>

                <div id="colorPreview" class="space-y-4">
                    <div class="space-y-2">
                        <div class="flex space-x-1">
                            <div id="previewShade50" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade100" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade200" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade300" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade400" class="flex-1 h-6 rounded"></div>
                        </div>
                        <div class="flex space-x-1">
                            <div id="previewShade500" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade600" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade700" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade800" class="flex-1 h-6 rounded"></div>
                            <div id="previewShade900" class="flex-1 h-6 rounded"></div>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Contoh Komponen</p>
                        <button id="previewBtn" class="w-full py-2 px-4 text-white rounded-lg text-sm font-medium">
                            Tombol Utama
                        </button>
                        <button id="previewBtnOutline" class="w-full py-2 px-4 bg-white border-2 rounded-lg text-sm font-medium">
                            Tombol Outline
                        </button>
                        <div id="previewBadge" class="inline-block px-3 py-1 text-xs font-semibold rounded-full">
                            Label Badge
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-3">Tips</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>Perubahan tema akan langsung terlihat di website publik setelah disimpan.</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>Custom CSS memungkinkan penyesuaian mendalam tanpa mengubah kode sumber.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const colorPresets = @json($colorPresets);

function updatePreview(colorKey) {
    const preset = colorPresets[colorKey];
    if (!preset) return;

    const shades = preset.shades;
    [50,100,200,300,400,500,600,700,800,900].forEach(s => {
        const el = document.getElementById('previewShade' + s);
        if (el) el.style.backgroundColor = shades[s];
    });

    const btn = document.getElementById('previewBtn');
    btn.style.backgroundColor = shades[600];

    const btnOutline = document.getElementById('previewBtnOutline');
    btnOutline.style.borderColor = shades[500];
    btnOutline.style.color = shades[600];

    const badge = document.getElementById('previewBadge');
    badge.style.backgroundColor = shades[100];
    badge.style.color = shades[700];
}

// Init preview
document.querySelectorAll('input[name="theme_color"]').forEach(radio => {
    radio.addEventListener('change', function() {
        updatePreview(this.value);
    });
    if (radio.checked) updatePreview(radio.value);
});
</script>
@endpush
