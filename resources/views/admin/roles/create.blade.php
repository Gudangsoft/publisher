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

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <!-- Informasi Role -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-5 mb-6">
            <h2 class="font-bold text-gray-700 text-xs uppercase tracking-widest pb-2 border-b border-gray-100">Informasi Role</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Role <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="cth: Editor Konten">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="Deskripsi singkat...">
                </div>
            </div>

            <!-- Color Picker -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Badge</label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['blue','green','purple','red','orange','yellow','teal','pink'] as $c)
                    <label class="cursor-pointer group">
                        <input type="radio" name="color" value="{{ $c }}" class="sr-only peer" {{ old('color','blue') === $c ? 'checked' : '' }}>
                        <div class="w-9 h-9 rounded-full ring-2 ring-transparent peer-checked:ring-offset-2 peer-checked:ring-gray-700 transition-all
                            @if($c==='blue') bg-blue-500 @elseif($c==='green') bg-green-500 @elseif($c==='purple') bg-purple-500
                            @elseif($c==='red') bg-red-500 @elseif($c==='orange') bg-orange-500 @elseif($c==='yellow') bg-yellow-400
                            @elseif($c==='teal') bg-teal-500 @else bg-pink-500 @endif">
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Hak Akses -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6"
             x-data="{
                 checked: {},
                 init() {
                     document.querySelectorAll('.perm-check').forEach(cb => {
                         this.checked[cb.value] = cb.checked;
                     });
                 },
                 toggle(id) { this.checked[id] = !this.checked[id]; },
                 selectAll() {
                     const all = Object.values(this.checked).every(v => v);
                     Object.keys(this.checked).forEach(k => this.checked[k] = !all);
                     document.querySelectorAll('.perm-check').forEach(cb => cb.checked = !all);
                 }
             }">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div>
                    <h2 class="font-bold text-gray-700 text-xs uppercase tracking-widest">Hak Akses</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Pilih menu yang boleh diakses role ini</p>
                </div>
                <button type="button" @click="selectAll()"
                        class="text-xs font-semibold text-primary-600 hover:text-primary-800 px-3 py-1.5 rounded-lg hover:bg-primary-50 transition">
                    Pilih / Hapus Semua
                </button>
            </div>

            <div class="p-6 space-y-7">
                @foreach($permissions as $group => $groupPerms)
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $group }}</span>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($groupPerms as $perm)
                        <label class="flex items-center gap-3 px-3 py-2.5 rounded-lg border cursor-pointer transition-colors"
                               :class="checked['{{ $perm->id }}'] ? 'bg-primary-50 border-primary-300' : 'bg-white border-gray-200 hover:border-gray-300'"
                               @click="toggle('{{ $perm->id }}')">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $perm->id }}"
                                   class="perm-check w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500 shrink-0"
                                   x-model="checked['{{ $perm->id }}']"
                                   {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="text-base leading-none">{{ $perm->icon }}</span>
                                <span class="text-sm font-medium text-gray-700 truncate">{{ $perm->name }}</span>
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
            <a href="{{ route('admin.roles.index') }}"
               class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                Simpan Role
            </button>
        </div>
    </form>
</div>
@endsection
