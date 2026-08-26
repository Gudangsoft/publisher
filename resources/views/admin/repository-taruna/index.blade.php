@extends('layouts.admin')

@section('title', 'Repository Skripsi')

@section('content')
<div x-data="{
    importOpen: false,
    addOpen: false,
    editOpen: false,
    filesOpen: false,
    editing: { id: null, name: '', academic_number: '', korps: '' },
    viewingFiles: { name: '', code: '', files: [] },
    openEdit(t) { this.editing = t; this.editOpen = true },
    openFiles(t) { this.viewingFiles = t; this.filesOpen = true }
}">

<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Repository Skripsi</h1>
        <p class="text-gray-600 mt-1">Daftar taruna tingkat akhir & status pengumpulan skripsi</p>
    </div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.repository-taruna.template') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Template
        </a>
        <button type="button" @click="importOpen = true" class="bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/>
            </svg>
            Import
        </button>
        <button type="button" @click="addOpen = true" class="bg-primary-600 text-white px-4 py-3 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Taruna
        </button>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg relative" role="alert">
    <span>{{ session('success') }}</span>
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
                <p class="text-sm font-medium text-gray-600">Total Taruna Tk. Akhir</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTaruna }}</p>
            </div>
            <div class="bg-primary-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055 12.083 12.083 0 015.84 10.578L12 14z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Sudah Mengumpulkan</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalSubmitted }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Belum Mengumpulkan</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $totalTaruna - $totalSubmitted }}</p>
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
        <form method="GET" action="{{ route('admin.repository-taruna.index') }}" class="flex flex-wrap items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no. akademik..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 w-64">
            <select name="korps" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Korps</option>
                @foreach($korpsList as $k)
                <option value="{{ $k }}" @selected(request('korps') === $k)>{{ $k }}</option>
                @endforeach
            </select>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Status</option>
                <option value="sudah" @selected(request('status') === 'sudah')>Sudah Mengumpulkan</option>
                <option value="belum" @selected(request('status') === 'belum')>Belum Mengumpulkan</option>
            </select>
            <button type="submit" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">Filter</button>
            @if(request()->anyFilled(['search', 'korps', 'status']))
            <a href="{{ route('admin.repository-taruna.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm">Reset</a>
            @endif
        </form>
    </div>

    @if($tarunas->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. Akademik</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Korps</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($tarunas as $t)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $t->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $t->academic_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $t->korps ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($t->submission)
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Sudah Mengumpulkan</span>
                        @else
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Belum Mengumpulkan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            @if($t->submission)
                            <button type="button"
                                @click="openFiles({
                                    name: {{ \Illuminate\Support\Js::from($t->name) }},
                                    code: {{ \Illuminate\Support\Js::from($t->submission->submission_code) }},
                                    submittedAt: {{ \Illuminate\Support\Js::from($t->submission->updated_at->format('d M Y H:i')) }},
                                    files: {{ \Illuminate\Support\Js::from(collect(\App\Models\ThesisSubmission::FILE_FIELDS)->map(fn($label, $field) => [
                                        'label' => $label . ($t->submission->isLink($field) ? ' (Tautan)' : ''),
                                        'url' => $t->submission->documentUrl($field),
                                        'name' => $t->submission->documentLabel($field),
                                    ])->values()) }}
                                })"
                                class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Lihat Berkas">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            @endif
                            <button type="button"
                                @click="openEdit({ id: {{ $t->id }}, name: {{ \Illuminate\Support\Js::from($t->name) }}, academic_number: {{ \Illuminate\Support\Js::from($t->academic_number) }}, korps: {{ \Illuminate\Support\Js::from($t->korps) }} })"
                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.repository-taruna.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data taruna ini beserta berkas yang sudah diupload?')">
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
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">Menampilkan {{ $tarunas->firstItem() }}-{{ $tarunas->lastItem() }} dari {{ $tarunas->total() }} taruna</p>
            <div class="flex items-center space-x-2">
                {{ $tarunas->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="p-12 text-center">
        <p class="text-gray-500 mb-2">Belum ada data taruna tingkat akhir</p>
        <p class="text-sm text-gray-400">Gunakan tombol Import atau Tambah Taruna untuk memulai.</p>
    </div>
    @endif
</div>

<!-- Import Modal -->
<div x-show="importOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="importOpen = false"></div>
    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Import Daftar Taruna</h3>
        <p class="text-sm text-gray-600 mb-4">
            Unggah file Excel (.xlsx/.xls/.csv) sesuai format template.
            <a href="{{ route('admin.repository-taruna.template') }}" class="text-primary-600 hover:underline">Unduh template</a>.
            Nomor Akademik yang sudah ada akan diperbarui datanya, bukan diduplikasi.
        </p>
        <form action="{{ route('admin.repository-taruna.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full mb-4 text-sm border border-gray-300 rounded-lg p-2">
            <div class="flex justify-end space-x-2">
                <button type="button" @click="importOpen = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-primary-600 rounded-lg hover:bg-primary-700">Import</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Modal -->
<div x-show="addOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="addOpen = false"></div>
    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Taruna</h3>
        <form action="{{ route('admin.repository-taruna.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Akademik</label>
                <input type="text" name="academic_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Korps</label>
                <input type="text" name="korps" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" @click="addOpen = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-primary-600 rounded-lg hover:bg-primary-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div x-show="editOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="editOpen = false"></div>
    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Taruna</h3>
        <form :action="'/admin/repository-taruna/' + editing.id" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" x-model="editing.name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Akademik</label>
                <input type="text" name="academic_number" x-model="editing.academic_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Korps</label>
                <input type="text" name="korps" x-model="editing.korps" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" @click="editOpen = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-primary-600 rounded-lg hover:bg-primary-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Files Modal -->
<div x-show="filesOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" @click="filesOpen = false"></div>
    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-1" x-text="viewingFiles.name"></h3>
        <p class="text-sm text-gray-500 mb-4">
            Kode bukti: <span class="font-mono" x-text="viewingFiles.code"></span>
            &middot; Terakhir diupload: <span x-text="viewingFiles.submittedAt"></span>
        </p>
        <ul class="divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
            <template x-for="f in viewingFiles.files" :key="f.label">
                <li class="flex items-center justify-between px-4 py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900" x-text="f.label"></p>
                        <p class="text-xs text-gray-500" x-text="f.name"></p>
                    </div>
                    <a :href="f.url" target="_blank" class="text-primary-600 hover:underline text-sm font-medium">Buka</a>
                </li>
            </template>
        </ul>
        <div class="flex justify-end pt-4">
            <button type="button" @click="filesOpen = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Tutup</button>
        </div>
    </div>
</div>

</div>
@endsection
