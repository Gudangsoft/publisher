<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')
            ->with('permissions')
            ->orderBy('is_system', 'desc')
            ->orderBy('name')
            ->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::allGrouped();
        $colors = array_keys(Role::colorClasses());
        return view('admin.roles.create', compact('permissions', 'colors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color'       => 'required|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'color'       => $validated['color'],
            'is_system'   => false,
            'is_active'   => true,
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$role->name}\" berhasil dibuat.");
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::allGrouped();
        $colors = array_keys(Role::colorClasses());
        $selectedPermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'colors', 'selectedPermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color'       => 'required|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'color'       => $validated['color'],
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$role->name}\" berhasil diperbarui.");
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role sistem tidak dapat dihapus.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Role ini masih digunakan oleh {$role->users()->count()} pengguna. Pindahkan pengguna terlebih dahulu.");
        }

        $name = $role->name;
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$name}\" berhasil dihapus.");
    }

    public function toggleActive(Role $role)
    {
        if ($role->is_system) {
            return back()->with('error', 'Role sistem tidak dapat dinonaktifkan.');
        }

        $role->update(['is_active' => !$role->is_active]);
        $status = $role->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Role \"{$role->name}\" berhasil {$status}.");
    }
}
