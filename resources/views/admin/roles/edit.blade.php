@extends('layouts.admin')
@section('title', 'Edit Role: ' . $role->name)

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
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-900">Edit Role</h1>
                @if($role->is_system)
                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-xs rounded font-medium">Sistem</span>
                @endif
            </div>
            <p class="text-sm text-gray-500 mt-0.5">{{ $role->name }}</p>
        </div>
    </div>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <!-- Nama & Warna -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-5">
            <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">Informasi Role</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Role <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <input type="text" name="description" value="{{ old('description', $role->description) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <!-- Color Picker -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Badge</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['blue','green','purple','red','orange','yellow','teal','pink'] as $c)
                    <label class="cursor-pointer">
                        <input type="radio" name="color" value="{{ $c }}" class="sr-only peer"
                               {{ old('color', $role->color) === $c ? 'checked' : '' }}>
                        <div class="w-8 h-8 rounded-full transition-all peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-500
                            @if($c==='blue') bg-blue-500 @elseif($c==='green') bg-green-500 @elseif($c==='purple') bg-purple-500 @elseif($c==='red') bg-red-500 @elseif($c==='orange') bg-orange-500 @elseif($c==='yellow') bg-yellow-400 @elseif($c==='teal') bg-teal-500 @else bg-pink-500 @endif">
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden" id="permBox">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div>
                    <h2 class="font-bold text-gray-700 text-xs uppercase tracking-widest">Hak Akses</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Centang menu yang boleh diakses oleh role ini</p>
                </div>
                <button type="button" id="btnSelectAll"
                        class="text-xs font-semibold text-primary-600 hover:text-primary-800 px-3 py-1.5 rounded-lg hover:bg-primary-50 transition">
                    Pilih / Hapus Semua
                </button>
            </div>

            <div class="p-6 space-y-7">
                @forelse($permissions as $group => $groupPerms)
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $group }}</span>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($groupPerms as $perm)
                        <label class="perm-label flex items-center gap-3 px-3 py-2.5 rounded-lg border cursor-pointer transition-colors {{ in_array($perm->id, old('permissions', $selectedPermissions)) ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }}">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $perm->id }}"
                                   class="perm-check w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500 shrink-0"
                                   {{ in_array($perm->id, old('permissions', $selectedPermissions)) ? 'checked' : '' }}>
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="text-base leading-none">{{ $perm->icon }}</span>
                                <span class="text-sm font-medium text-gray-700 truncate">{{ $perm->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada hak akses tersedia.</p>
                @endforelse
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                Perbarui Role
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateLabel(cb) {
        var label = cb.closest('.perm-label');
        if (cb.checked) {
            label.classList.add('bg-blue-50', 'border-blue-300');
            label.classList.remove('bg-white', 'border-gray-200');
        } else {
            label.classList.remove('bg-blue-50', 'border-blue-300');
            label.classList.add('bg-white', 'border-gray-200');
        }
    }
    document.querySelectorAll('.perm-check').forEach(function (cb) {
        cb.addEventListener('change', function () { updateLabel(cb); });
    });
    var btn = document.getElementById('btnSelectAll');
    if (btn) {
        btn.addEventListener('click', function () {
            var checks = document.querySelectorAll('.perm-check');
            var allChecked = Array.from(checks).every(function (c) { return c.checked; });
            checks.forEach(function (c) {
                c.checked = !allChecked;
                updateLabel(c);
            });
        });
    }
});
</script>
@endsection
