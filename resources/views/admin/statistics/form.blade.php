@extends('layouts.admin')

@section('title', isset($statistic) ? 'Edit Statistik' : 'Tambah Statistik')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="{{ route('admin.statistics.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($statistic) ? 'Edit Statistik' : 'Tambah Statistik Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($statistic) ? 'Perbarui informasi statistik' : 'Tambahkan data statistik baru' }}</p>
        </div>
    </div>
</div>

@if($errors->any())
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="font-semibold">Terdapat beberapa kesalahan:</p>
            <ul class="list-disc list-inside mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form method="POST" action="{{ isset($statistic) ? route('admin.statistics.update', $statistic->id) : route('admin.statistics.store') }}">
    @csrf
    @if(isset($statistic)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <!-- Informasi Statistik -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Statistik</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Label <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="label" value="{{ old('label', $statistic->label ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('label') border-red-500 @enderror"
                            placeholder="Judul Buku" required>
                        @error('label')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Contoh: Judul Buku, Penulis, Pembaca</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="value" value="{{ old('value', $statistic->value ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('value') border-red-500 @enderror"
                                placeholder="1000" required>
                            @error('value')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Contoh: 1000, 500, 50K</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                            <input type="text" name="suffix" value="{{ old('suffix', $statistic->suffix ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="+">
                            <p class="mt-1 text-sm text-gray-500">Contoh: +, K+, juta</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                        <input type="text" name="icon" value="{{ old('icon', $statistic->icon ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="📚">
                        <p class="mt-1 text-sm text-gray-500">Opsional: Emoji untuk mempercantik tampilan</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <select name="color" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="primary" {{ old('color', $statistic->color ?? 'primary') == 'primary' ? 'selected' : '' }}>Primary (Biru)</option>
                            <option value="red" {{ old('color', $statistic->color ?? '') == 'red' ? 'selected' : '' }}>Merah</option>
                            <option value="green" {{ old('color', $statistic->color ?? '') == 'green' ? 'selected' : '' }}>Hijau</option>
                            <option value="orange" {{ old('color', $statistic->color ?? '') == 'orange' ? 'selected' : '' }}>Orange</option>
                            <option value="purple" {{ old('color', $statistic->color ?? '') == 'purple' ? 'selected' : '' }}>Ungu</option>
                            <option value="indigo" {{ old('color', $statistic->color ?? '') == 'indigo' ? 'selected' : '' }}>Indigo</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Warna untuk nilai statistik</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Pengaturan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Pengaturan</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="display_order" value="{{ old('display_order', $statistic->display_order ?? 0) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                            min="0">
                        <p class="mt-1 text-sm text-gray-500">Urutan tampil statistik (lebih kecil = lebih awal)</p>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                {{ old('is_active', $statistic->is_active ?? true) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                                Aktifkan Statistik
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 ml-8">Statistik aktif akan ditampilkan di homepage</p>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Preview</h3>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-primary-600" id="preview-value">1000+</div>
                    <div class="text-sm text-gray-600 mt-1" id="preview-label">Judul Buku</div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($statistic) ? 'Update Statistik' : 'Simpan Statistik' }}
                </button>
                <a href="{{ route('admin.statistics.index') }}" class="w-full px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const valueInput = document.querySelector('input[name="value"]');
    const suffixInput = document.querySelector('input[name="suffix"]');
    const labelInput = document.querySelector('input[name="label"]');
    const previewValue = document.getElementById('preview-value');
    const previewLabel = document.getElementById('preview-label');

    function updatePreview() {
        const value = valueInput.value || '1000';
        const suffix = suffixInput.value || '';
        const label = labelInput.value || 'Judul Buku';
        
        previewValue.textContent = value + suffix;
        previewLabel.textContent = label;
    }

    valueInput.addEventListener('input', updatePreview);
    suffixInput.addEventListener('input', updatePreview);
    labelInput.addEventListener('input', updatePreview);
});
</script>
@endsection
