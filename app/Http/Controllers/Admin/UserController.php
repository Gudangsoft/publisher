<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $query = User::with('role');

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if (request('role_filter') !== null && request('role_filter') !== '') {
            if (request('role_filter') === 'admin') {
                $query->where('is_admin', true);
            } elseif (request('role_filter') === 'staff') {
                $query->where('is_admin', false)->whereNotNull('role_id');
            } elseif (request('role_filter') === 'user') {
                $query->where('is_admin', false)->whereNull('role_id');
            } elseif (is_numeric(request('role_filter'))) {
                $query->where('role_id', request('role_filter'));
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::active()->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::where('is_active', true)->orderBy('name')->get();
        return view('admin.users.form', ['user' => new User(), 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
        ]);

        $validated['is_admin'] = $request->has('is_admin') ? 1 : 0;
        $validated['password'] = Hash::make($validated['password']);
        $validated['role_id']  = $validated['is_admin'] ? null : ($validated['role_id'] ?? null);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::where('is_active', true)->orderBy('name')->get();
        return view('admin.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
        ]);

        $isAdmin = $request->has('is_admin') ? 1 : 0;
        $validated['is_admin'] = $isAdmin;
        $validated['role_id']  = $isAdmin ? null : ($validated['role_id'] ?? null);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function loginAs(User $user)
    {
        session(['admin_user_id' => auth()->id()]);
        auth()->login($user);
        return redirect('/')->with('success', 'Anda sekarang login sebagai ' . $user->name);
    }

    public function switchBack()
    {
        $adminUserId = session('admin_user_id');
        if ($adminUserId) {
            $adminUser = User::find($adminUserId);
            if ($adminUser) {
                auth()->login($adminUser);
                session()->forget('admin_user_id');
                return redirect()->route('admin.users.index')->with('success', 'Kembali ke akun admin.');
            }
        }
        return redirect('/')->with('error', 'Tidak dapat kembali ke akun admin.');
    }
}
