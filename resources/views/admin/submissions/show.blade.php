@extends('layouts.admin')

@section('title', 'Detail Pengajuan - ' . $submission->submission_number)

@section('content')
<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.submissions.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pengajuan</h1>
            <p class="text-gray-600 mt-1">{{ $submission->submission_number }}</p>
        </div>
    </div>
    <div class="flex items-center space-x-3">
        @php
            $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                'reviewing' => 'bg-blue-100 text-blue-800 border-blue-300',
                'revision' => 'bg-orange-100 text-orange-800 border-orange-300',
                'approved' => 'bg-green-100 text-green-800 border-green-300',
                'rejected' => 'bg-red-100 text-red-800 border-red-300',
                'in_progress' => 'bg-purple-100 text-purple-800 border-purple-300',
                'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            ];
        @endphp
        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold border {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
            {{ $submission->status_label }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Submission Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Naskah</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Judul</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $submission->title }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Jenis</label>
                        <p class="text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $submission->type == 'book' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $submission->type_label }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Kategori</label>
                        <p class="text-gray-900">{{ $submission->category?->name ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Estimasi Halaman</label>
                        <p class="text-gray-900">{{ $submission->estimated_pages ? $submission->estimated_pages . ' halaman' : '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Bahasa</label>
                        <p class="text-gray-900">{{ $submission->language }}</p>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Target Pembaca</label>
                    <p class="text-gray-900">{{ $submission->target_audience ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                    <p class="text-gray-900 whitespace-pre-line">{{ $submission->description }}</p>
                </div>
                
                @if($submission->synopsis)
                <div>
                    <label class="text-sm font-medium text-gray-500">Sinopsis</label>
                    <p class="text-gray-900 whitespace-pre-line">{{ $submission->synopsis }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Files -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">File Dokumen</h2>
            
            <div class="space-y-3">
                <!-- Manuscript File -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-red-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                            <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">File Naskah</p>
                            <p class="text-sm text-gray-500">{{ basename($submission->manuscript_file) }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.submissions.download', [$submission, 'manuscript']) }}" 
                       class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download
                    </a>
                </div>

                <!-- Cover Proposal -->
                @if($submission->cover_proposal)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $submission->cover_proposal) }}" 
                             alt="Cover Proposal" 
                             class="w-10 h-10 object-cover rounded mr-3">
                        <div>
                            <p class="font-medium text-gray-900">Cover Proposal</p>
                            <p class="text-sm text-gray-500">{{ basename($submission->cover_proposal) }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.submissions.download', [$submission, 'cover']) }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download
                    </a>
                </div>
                @endif

                <!-- Additional Files -->
                @if($submission->additional_files && count($submission->additional_files) > 0)
                    @foreach($submission->additional_files as $index => $file)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center">
                            <svg class="w-10 h-10 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">File Tambahan {{ $index + 1 }}</p>
                                <p class="text-sm text-gray-500">{{ basename($file) }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $file) }}" target="_blank"
                           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat
                        </a>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Update Status & Review</h2>
            
            <form action="{{ route('admin.submissions.update', $submission) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="pending" {{ $submission->status == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                                <option value="reviewing" {{ $submission->status == 'reviewing' ? 'selected' : '' }}>Sedang Direview</option>
                                <option value="revision" {{ $submission->status == 'revision' ? 'selected' : '' }}>Perlu Revisi</option>
                                <option value="approved" {{ $submission->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ $submission->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="in_progress" {{ $submission->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses Cetak</option>
                                <option value="completed" {{ $submission->status == 'completed' ? 'selected' : '' }}>Selesai/Terbit</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Cetak</label>
                            <input type="number" name="print_quantity" value="{{ old('print_quantity', $submission->print_quantity) }}" 
                                   placeholder="Jumlah cetak" min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Biaya (Rp)</label>
                        <input type="number" name="estimated_cost" value="{{ old('estimated_cost', $submission->estimated_cost) }}" 
                               placeholder="Contoh: 5000000" min="0" step="1000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin (Internal)</label>
                        <textarea name="admin_notes" rows="3" 
                                  placeholder="Catatan internal untuk tim..." 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('admin_notes', $submission->admin_notes) }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Revisi (Untuk Pengaju)</label>
                        <textarea name="revision_notes" rows="3" 
                                  placeholder="Catatan yang akan dilihat oleh pengaju..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('revision_notes', $submission->revision_notes) }}</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Submitter Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pengaju</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                    <p class="text-gray-900 font-medium">{{ $submission->submitter_name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Email</label>
                    <p class="text-gray-900">
                        <a href="mailto:{{ $submission->submitter_email }}" class="text-primary-600 hover:underline">
                            {{ $submission->submitter_email }}
                        </a>
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Telepon</label>
                    <p class="text-gray-900">
                        <a href="tel:{{ $submission->submitter_phone }}" class="text-primary-600 hover:underline">
                            {{ $submission->submitter_phone }}
                        </a>
                    </p>
                </div>
                @if($submission->submitter_institution)
                <div>
                    <label class="text-sm font-medium text-gray-500">Institusi</label>
                    <p class="text-gray-900">{{ $submission->submitter_institution }}</p>
                </div>
                @endif
                @if($submission->submitter_address)
                <div>
                    <label class="text-sm font-medium text-gray-500">Alamat</label>
                    <p class="text-gray-900">{{ $submission->submitter_address }}</p>
                </div>
                @endif
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200 flex space-x-2">
                <a href="mailto:{{ $submission->submitter_email }}" 
                   class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $submission->submitter_phone) }}" target="_blank"
                   class="flex-1 bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Timeline</h2>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Pengajuan Dibuat</p>
                        <p class="text-xs text-gray-500">{{ $submission->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                @if($submission->reviewed_at)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Terakhir Diupdate</p>
                        <p class="text-xs text-gray-500">{{ $submission->reviewed_at->format('d M Y, H:i') }}</p>
                        @if($submission->reviewer)
                            <p class="text-xs text-gray-500">oleh {{ $submission->reviewer->name }}</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Pricing Info (if approved) -->
        @if($submission->estimated_cost || $submission->print_quantity)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Harga</h2>
            
            <div class="space-y-3">
                @if($submission->print_quantity)
                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah Cetak</span>
                    <span class="font-medium">{{ number_format($submission->print_quantity) }} eksemplar</span>
                </div>
                @endif
                @if($submission->estimated_cost)
                <div class="flex justify-between">
                    <span class="text-gray-600">Estimasi Biaya</span>
                    <span class="font-bold text-primary-600">Rp {{ number_format($submission->estimated_cost, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi</h2>
            
            <div class="space-y-3">
                <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini? Aksi ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Pengajuan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
