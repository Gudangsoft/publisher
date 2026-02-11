@extends('layouts.admin')

@section('title', isset($user->id) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($user->id) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h1>
            <p class="text-gray-600 mt-1">{{ isset($user->id) ? 'Perbarui informasi pengguna' : 'Tambahkan pengguna atau administrator baru' }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Display Errors -->
@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
            <h3 class="text-sm font-semibold text-red-800">Terdapat beberapa kesalahan:</h3>
            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Form -->
<form action="{{ isset($user->id) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
    @csrf
    @if(isset($user->id))
        @method('PUT')
    @endif
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Pengguna</h2>
        </div>
        
        <!-- Form Fields -->
        <div class="p-6 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name ?? '') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email ?? '') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror"
                       placeholder="contoh@email.com"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    Password 
                    @if(isset($user->id))
                        <span class="text-gray-500 font-normal text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                    @else
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-red-500 @enderror"
                       placeholder="Minimal 6 karakter"
                       {{ isset($user->id) ? '' : 'required' }}>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                    Konfirmasi Password 
                    @if(isset($user->id))
                        <span class="text-gray-500 font-normal text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                    @else
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="Ulangi password"
                       {{ isset($user->id) ? '' : 'required' }}>
            </div>
            
            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" 
                           id="is_admin" 
                           name="is_admin" 
                           value="1" 
                           {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}
                           class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-2 focus:ring-primary-500">
                    <label for="is_admin" class="text-sm text-gray-700 cursor-pointer">Administrator</label>
                </div>
                <p class="mt-2 text-xs text-gray-500">Administrator memiliki akses penuh ke panel admin dan dapat mengelola semua konten</p>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ isset($user->id) ? 'Update Pengguna' : 'Tambah Pengguna' }}
            </button>
        </div>
    </div>
</form>
@endsection
