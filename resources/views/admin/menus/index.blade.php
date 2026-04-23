@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Menu</h1>
            <p class="text-gray-600 mt-2">Kelola menu navigasi website</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Menu Baru
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg flex items-center">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<!-- Menus Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    @if($menus->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Label</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Submenu</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($menus as $menu)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($menu->icon)
                            <span class="mr-2">{{ $menu->icon }}</span>
                            @endif
                            <p class="font-semibold text-gray-900">{{ $menu->label }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="text-primary-600 hover:underline text-sm">
                            {{ Str::limit($menu->url, 40) }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        @if($menu->location == 'header')
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">Header</span>
                        @elseif($menu->location == 'footer')
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-medium">Footer</span>
                        @else
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-medium">Keduanya</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($menu->children->count() > 0)
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                {{ $menu->children->count() }} submenu
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">{{ $menu->display_order }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($menu->is_active)
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                Aktif
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                
                @if($menu->children->count() > 0)
                    @foreach($menu->children as $child)
                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                        <td class="px-6 py-3">
                            <div class="flex items-center pl-8">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                @if($child->icon)
                                <span class="mr-2">{{ $child->icon }}</span>
                                @endif
                                <p class="text-gray-700">{{ $child->label }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ $child->url }}" target="{{ $child->target }}" class="text-primary-600 hover:underline text-sm">
                                {{ Str::limit($child->url, 40) }}
                            </a>
                        </td>
                        <td class="px-6 py-3">
                            @if($child->location == 'header')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">Header</span>
                            @elseif($child->location == 'footer')
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-medium">Footer</span>
                            @else
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-medium">Keduanya</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span class="inline-block px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-sm">{{ $child->display_order }}</span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            @if($child->is_active)
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.menus.edit', $child->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $child->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus submenu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-16">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada menu</h3>
        <p class="mt-2 text-gray-500">Mulai dengan menambahkan menu pertama Anda.</p>
        <div class="mt-6">
            <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Menu
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
