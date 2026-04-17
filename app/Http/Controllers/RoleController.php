<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles and permissions.
     */
    public function index()
    {
        $roles = Role::withCount('users')->with('permissions')->get();
        $permissions = Permission::orderBy('name')->get();
        return view('pages.admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:100',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return back()->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    /**
     * Update permissions for an existing role.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', "Permissions untuk role '{$role->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'staf'])) {
            return back()->with('error', "Role '{$role->name}' adalah role bawaan sistem dan tidak dapat dihapus.");
        }

        $role->delete();
        return back()->with('success', "Role '{$role->name}' berhasil dihapus.");
    }
}
