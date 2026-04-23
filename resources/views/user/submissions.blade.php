@extends('layouts.app')

@section('title', 'Submisi Saya - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-primary-600">Dashboard</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium">Submisi Saya</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Submisi Saya</h1>
                <p class="text-gray-600 mt-1">Pantau semua pengajuan naskah Anda</p>
            </div>
            <a href="{{ route('submissions.create') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajukan Naskah Baru
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" action="{{ route('user.submissions') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-600">Status:</label>
                    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>Direview</option>
                        <option value="revision_required" {{ request('status') == 'revision_required' ? 'selected' : '' }}>Perlu Revisi</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="in_production" {{ request('status') == 'in_production' ? 'selected' : '' }}>Produksi</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 text-sm">
                    Filter
                </button>
                @if(request('status'))
                <a href="{{ route('user.submissions') }}" class="text-sm text-gray-500 hover:text-gray-700">Reset</a>
                @endif
            </form>
        </div>

        <!-- Submissions List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @forelse($submissions as $submission)
            <a href="{{ route('user.submissions.show', $submission->id) }}" class="block border-b border-gray-200 last:border-0 hover:bg-gray-50 transition-colors">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-gray-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 truncate">{{ $submission->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $submission->submission_number }}</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-400">
                                        <span>{{ $submission->type_label ?? ucfirst($submission->type) }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $submission->estimated_pages ?? '-' }} halaman</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $submission->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-4 flex items-center">
                            @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'in_review' => 'bg-blue-100 text-blue-800',
                                'revision_required' => 'bg-orange-100 text-orange-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'in_production' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-gray-100 text-gray-800',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'in_review' => 'Direview',
                                'revision_required' => 'Perlu Revisi',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'in_production' => 'Produksi',
                                'completed' => 'Selesai',
                            ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$submission->status] ?? ucfirst($submission->status) }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada submisi</h3>
                <p class="text-gray-500 mb-4">Anda belum mengajukan naskah apapun.</p>
                <a href="{{ route('submissions.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Naskah Pertama
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($submissions->hasPages())
        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
