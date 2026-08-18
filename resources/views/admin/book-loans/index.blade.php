@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
<div x-data="{ importOpen: false }">

<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Data Peminjaman</h1>
        <p class="text-gray-600 mt-1">Kelola data peminjaman buku perpustakaan</p>
    </div>
    <button type="button" @click="importOpen = true" class="bg-primary-600 text-white px-4 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/>
        </svg>
        Import
    </button>
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
                <p class="text-sm font-medium text-gray-600">Total Peminjaman</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $bookLoans->total() }}</p>
            </div>
            <div class="bg-primary-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Sedang Dipinjam</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\BookLoan::where('status', 'dipinjam')->count() }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Terlambat</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\BookLoan::where('status', 'terlambat')->count() }}</p>
            </div>
            <div class="bg-red-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.book-loans.index') }}" class="flex flex-wrap items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam / judul buku..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 w-64">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Status</option>
                @foreach($statuses as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <input type="date" name="from" value="{{ request('from') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            <span class="text-gray-500">s/d</span>
            <input type="date" name="to" value="{{ request('to') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            <button type="submit" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'status', 'from', 'to']))
            <a href="{{ route('admin.book-loans.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm">Reset</a>
            @endif
        </form>
    </div>

    @if($bookLoans->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jatuh Tempo</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Kembali</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($bookLoans as $loan)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $loan->displayTitle() }}</td>
                    <td class="px-6 py-4">
                        <p class="text-gray-900">{{ $loan->borrower_name }}</p>
                        <p class="text-xs text-gray-500">{{ $loan->borrower_identity_number ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-700">
                            {{ \App\Models\BookLoan::BORROWER_TYPES[$loan->borrower_type] ?? $loan->borrower_type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $loan->loaned_at?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $loan->due_at?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $loan->returned_at?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @php
                        $statusColors = [
                            'dipinjam' => 'bg-blue-100 text-blue-700',
                            'dikembalikan' => 'bg-green-100 text-green-700',
                            'terlambat' => 'bg-red-100 text-red-700',
                        ];
                        @endphp
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$loan->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $statuses[$loan->status] ?? $loan->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">Menampilkan {{ $bookLoans->firstItem() }}-{{ $bookLoans->lastItem() }} dari {{ $bookLoans->total() }} peminjaman</p>
            <div class="flex items-center space-x-2">
                {{ $bookLoans->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        <p class="text-gray-500 mb-2">Belum ada data peminjaman</p>
        <p class="text-sm text-gray-400">Gunakan tombol Import untuk mengunggah data peminjaman secara massal.</p>
    </div>
    @endif
</div>

<!-- Import Modal -->
<div x-show="importOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="importOpen = false"></div>
    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Import Data Peminjaman</h3>
        <p class="text-sm text-gray-600 mb-4">
            Unggah file Excel (.xlsx/.xls/.csv) sesuai format template.
            <a href="{{ route('admin.book-loans.template') }}" class="text-primary-600 hover:underline">Unduh template</a>.
        </p>
        <form action="{{ route('admin.book-loans.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full mb-4 text-sm border border-gray-300 rounded-lg p-2">
            <p class="text-xs text-gray-500 mb-4">
                Isi ISBN (dicocokkan ke katalog buku) dan/atau Judul Buku. Jenis Peminjam: mahasiswa, dosen, staf, tamu. Format tanggal: YYYY-MM-DD.
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
