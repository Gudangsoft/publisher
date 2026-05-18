@extends('layouts.admin')
@section('title', 'Manajemen Role & Hak Akses')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Role & Hak Akses</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola role dan izin akses untuk staf</p>
        </div>
        <a href="{{ route('admin.roles.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Role Baru
        </a>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
        <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($roles as $role)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
            <!-- Card Header -->
            <div class="px-5 py-4 border-b border-gray-100 flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        @if($role->color === 'blue') bg-blue-100 @elseif($role->color === 'green') bg-green-100 @elseif($role->color === 'purple') bg-purple-100 @elseif($role->color === 'red') bg-red-100 @elseif($role->color === 'orange') bg-orange-100 @elseif($role->color === 'yellow') bg-yellow-100 @elseif($role->color === 'teal') bg-teal-100 @else bg-pink-100 @endif">
                        <svg class="w-5 h-5
                            @if($role->color === 'blue') text-blue-600 @elseif($role->color === 'green') text-green-600 @elseif($role->color === 'purple') text-purple-600 @elseif($role->color === 'red') text-red-600 @elseif($role->color === 'orange') text-orange-600 @elseif($role->color === 'yellow') text-yellow-600 @elseif($role->color === 'teal') text-teal-600 @else text-pink-600 @endif"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-bold text-gray-900 text-sm truncate">{{ $role->name }}</h3>
                            @if($role->is_system)
                            <span class="px-1.5 py-0.5 bg-gray-100 text-gray-500 text-xs rounded font-medium">Sistem</span>
                            @endif
                        </div>
                        @if($role->description)
                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $role->description }}</p>
                        @endif
                    </div>
                </div>
                <!-- Status + Actions -->
                <div class="flex items-center gap-1.5 shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $role->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $role->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <!-- Permissions -->
            <div class="px-5 py-4">
                @php
                    $rolePerms = $role->permissions ?? [];
                    $flatPerms = collect($allPermissions)->flatMap(fn($g) => $g);
                    $displayPerms = array_slice($rolePerms, 0, 8);
                @endphp
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2.5">Hak Akses ({{ count($rolePerms) }})</p>
                <div class="flex flex-wrap gap-1.5">
                    @forelse($displayPerms as $slug)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-50 border border-gray-200 text-gray-600 rounded-lg text-xs">
                        {{ $flatPerms[$slug]['icon'] ?? '' }} {{ $flatPerms[$slug]['label'] ?? $slug }}
                    </span>
                    @empty
                    <span class="text-xs text-gray-400 italic">Belum ada hak akses</span>
                    @endforelse
                    @if(count($rolePerms) > 8)
                    <span class="inline-flex items-center px-2 py-0.5 bg-gray-100 text-gray-500 rounded-lg text-xs">
                        +{{ count($rolePerms) - 8 }} lainnya
                    </span>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>{{ $role->users_count }} pengguna</span>
                </div>
                <div class="flex items-center gap-2">
                    @if(!$role->is_system)
                    <form action="{{ route('admin.roles.toggle', $role) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1 rounded hover:bg-gray-100 transition">
                            {{ $role->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('admin.roles.edit', $role) }}"
                       class="text-xs text-primary-600 hover:text-primary-700 font-semibold px-2 py-1 rounded hover:bg-primary-50 transition">
                        Edit
                    </a>
                    @if(!$role->is_system)
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                          onsubmit="return confirm('Hapus role \'{{ $role->name }}\'? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 px-2 py-1 rounded hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-200">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Belum Ada Role</h3>
            <p class="text-sm text-gray-500 mb-4">Buat role pertama untuk mengatur hak akses staf</p>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-semibold hover:bg-primary-700 transition">
                Buat Role Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-blue-700">
                <p class="font-semibold mb-1">Cara Penggunaan</p>
                <ul class="space-y-0.5 text-blue-600">
                    <li>• <strong>Admin</strong> selalu memiliki akses penuh ke semua menu</li>
                    <li>• <strong>Staf</strong> hanya melihat dan mengakses menu sesuai role yang ditetapkan</li>
                    <li>• Role bertanda <strong>Sistem</strong> adalah preset bawaan dan tidak dapat dihapus</li>
                    <li>• Tetapkan role ke pengguna di menu <a href="{{ route('admin.users.index') }}" class="underline font-semibold">Pengguna</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
