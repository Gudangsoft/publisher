@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Login</h2>
    <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block text-sm">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="flex justify-end">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Login</button>
        </div>
    </form>
</div>
@endsection
