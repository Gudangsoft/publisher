<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    private function adminOnly(): void
    {
        if (!auth()->user()?->is_admin) {
            abort(403, 'Hanya administrator yang dapat mengelola role.');
        }
    }

    public function index()
    {
        $this->adminOnly();
        $roles = Role::withCount('users')->orderBy('is_system', 'desc')->orderBy('name')->get();
        $allPermissions = Role::allPermissions();
        return view('admin.roles.index', compact('roles', 'allPermissions'));
    }

    public function create()
    {
        $this->adminOnly();
        $allPermissions = Role::allPermissions();
        return view('admin.roles.create', compact('allPermissions'));
    }

    public function store(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color'       => 'required|string',
        ]);

        Role::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'color'       => $request->color,
            'permissions' => $request->input('permissions', []),
            'is_system'   => false,
            'is_active'   => true,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$request->name}\" berhasil dibuat.");
    }

    public function show(Role $role)
    {
        $this->adminOnly();
        return redirect()->route('admin.roles.edit', $role);
    }

    public function edit(Role $role)
    {
        $this->adminOnly();
        $allPermissions = Role::allPermissions();
        return view('admin.roles.edit', compact('role', 'allPermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->adminOnly();
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color'       => 'required|string',
        ]);

        $role->update([
            'name'        => $request->name,
            'description' => $request->description,
            'color'       => $request->color,
            'permissions' => $request->input('permissions', []),
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$role->name}\" berhasil diperbarui.");
    }

    public function destroy(Role $role)
    {
        $this->adminOnly();
        if ($role->is_system) {
            return back()->with('error', 'Role sistem tidak dapat dihapus.');
        }
        if ($role->users()->count() > 0) {
            return back()->with('error', "Role ini masih digunakan oleh {$role->users()->count()} pengguna.");
        }
        $name = $role->name;
        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$name}\" berhasil dihapus.");
    }

    public function toggleActive(Role $role)
    {
        $this->adminOnly();
        if ($role->is_system) {
            return back()->with('error', 'Role sistem tidak dapat dinonaktifkan.');
        }
        $role->update(['is_active' => !$role->is_active]);
        $status = $role->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Role \"{$role->name}\" berhasil {$status}.");
    }
}
