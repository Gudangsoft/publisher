@extends('layouts.admin')
@section('title', 'Buat Role Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.roles.index') }}" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Role Baru</h1>
            <p class="text-sm text-gray-500 mt-0.5">Tentukan nama dan hak akses untuk role ini</p>
        </div>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nama & Warna -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-5">
            <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">Informasi Role</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Role <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="cth: Editor Konten">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="Deskripsi singkat role ini...">
                </div>
            </div>

            <!-- Color Picker -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Badge</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['blue','green','purple','red','orange','yellow','teal','pink'] as $c)
                    <label class="cursor-pointer">
                        <input type="radio" name="color" value="{{ $c }}" class="sr-only peer" {{ old('color','blue') === $c ? 'checked' : '' }}>
                        <div class="w-8 h-8 rounded-full transition-all peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-500
                            @if($c==='blue') bg-blue-500 @elseif($c==='green') bg-green-500 @elseif($c==='purple') bg-purple-500 @elseif($c==='red') bg-red-500 @elseif($c==='orange') bg-orange-500 @elseif($c==='yellow') bg-yellow-400 @elseif($c==='teal') bg-teal-500 @else bg-pink-500 @endif">
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">Hak Akses</h2>
                <button type="button" id="selectAll"
                        class="text-xs text-primary-600 hover:text-primary-700 font-semibold">
                    Pilih Semua
                </button>
            </div>

            <div class="p-6 space-y-6">
                @foreach($permissions as $group => $groupPerms)
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ $group }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($groupPerms as $perm)
                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all hover:border-primary-300 has-[:checked]:border-primary-400 has-[:checked]:bg-primary-50">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                   class="perm-check w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                   {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 text-sm">
                                <span>{{ $perm->icon }}</span>
                                <span class="font-medium text-gray-700">{{ $perm->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                Simpan Role
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('selectAll').addEventListener('click', function() {
    const checks = document.querySelectorAll('.perm-check');
    const allChecked = [...checks].every(c => c.checked);
    checks.forEach(c => c.checked = !allChecked);
    this.textContent = allChecked ? 'Pilih Semua' : 'Hapus Semua';
});
</script>
@endsection
