<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); // Include permissions for each role
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        $role = Role::create(['name' => $request->name]);

        return response()->json([
            'message' => 'Role created successfully.',
            'role' => $role,
        ]);
    }

    public function assignPermission(Request $request, Role $role)
    {
        $request->validate(['permission' => 'required|exists:permissions,name']);
        $permission = Permission::where('name', $request->permission)->first();
        $role->givePermissionTo($permission);

        return response()->json([
            'message' => 'Permission assigned to role successfully.',
            'role' => $role->load('permissions'),
        ]);
    }

    public function revokePermission(Request $request, Role $role)
    {
        $request->validate(['permission' => 'required|exists:permissions,name']);
        $permission = Permission::where('name', $request->permission)->first();
        $role->revokePermissionTo($permission);

        return response()->json([
            'message' => 'Permission revoked from role successfully.',
            'role' => $role->load('permissions'),
        ]);
    }
}
