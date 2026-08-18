@extends('layouts.admin')

@section('title', 'Data Pengunjung')

@section('content')
<div x-data="{ importOpen: false }">

<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Data Pengunjung</h1>
        <p class="text-gray-600 mt-1">Kelola data kunjungan perpustakaan</p>
    </div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.visitor-logs.export', request()->query()) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export
        </a>
        <button type="button" @click="importOpen = true" class="bg-primary-600 text-white px-4 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/>
            </svg>
            Import
        </button>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg relative" role="alert">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('import_warning'))
<div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-800 px-6 py-4 rounded-lg relative" role="alert">
    <p class="font-medium mb-1">Sebagian data tidak diimpor</p>
    <p class="text-sm">{{ session('import_warning') }}</p>
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg relative" role="alert">
    <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $visitorLogs->total() }}</p>
            </div>
            <div class="bg-primary-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Hari Ini</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\VisitorLog::whereDate('checked_in_at', today())->count() }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\VisitorLog::whereMonth('checked_in_at', now()->month)->whereYear('checked_in_at', now()->year)->count() }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.visitor-logs.index') }}" class="flex flex-wrap items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no. identitas..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 w-64">
            <select name="identity_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Jenis</option>
                @foreach($identityTypes as $value => $label)
                <option value="{{ $value }}" @selected(request('identity_type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <input type="date" name="from" value="{{ request('from') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            <span class="text-gray-500">s/d</span>
            <input type="date" name="to" value="{{ request('to') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            <button type="submit" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'identity_type', 'from', 'to']))
            <a href="{{ route('admin.visitor-logs.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm">Reset</a>
            @endif
        </form>
    </div>

    @if($visitorLogs->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. Identitas</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Prodi/Unit</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Keperluan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu Masuk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu Keluar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($visitorLogs as $log)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $log->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $log->identity_number ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-700">
                            {{ $identityTypes[$log->identity_type] ?? $log->identity_type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->study_program ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->purpose ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->checked_in_at?->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->checked_out_at?->format('d M Y H:i') ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">Menampilkan {{ $visitorLogs->firstItem() }}-{{ $visitorLogs->lastItem() }} dari {{ $visitorLogs->total() }} kunjungan</p>
            <div class="flex items-center space-x-2">
                {{ $visitorLogs->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/>
        </svg>
        <p class="text-gray-500 mb-2">Belum ada data pengunjung</p>
        <p class="text-sm text-gray-400">Gunakan tombol Import untuk mengunggah data pengunjung secara massal.</p>
    </div>
    @endif
</div>

<!-- Import Modal -->
<div x-show="importOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="importOpen = false"></div>
    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Import Data Pengunjung</h3>
        <p class="text-sm text-gray-600 mb-4">
            Unggah file Excel (.xlsx/.xls/.csv) sesuai format template.
            <a href="{{ route('admin.visitor-logs.template') }}" class="text-primary-600 hover:underline">Unduh template</a>.
        </p>
        <form action="{{ route('admin.visitor-logs.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full mb-4 text-sm border border-gray-300 rounded-lg p-2">
            <p class="text-xs text-gray-500 mb-4">
                Kolom Jenis diisi salah satu: mahasiswa, dosen, staf, tamu. Format waktu: YYYY-MM-DD HH:MM.
            </p>
            <div class="flex justify-end space-x-2">
                <button type="button" @click="importOpen = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-primary-600 rounded-lg hover:bg-primary-700">Import</button>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
