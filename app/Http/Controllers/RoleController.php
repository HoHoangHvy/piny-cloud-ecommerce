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
        return response()->json([
            'success' => true,
            'data' => $roles
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        $role = Role::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'data' => $role
        ], 200);
    }

    public function assignPermission(Request $request, Role $role)
    {
        $request->validate(['permission' => 'required|exists:permissions,name']);
        $permission = Permission::where('name', $request->permission)->first();
        $role->givePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => 'Permission assigned to role successfully.',
            'data' => $role->load('permissions')
        ], 200);
    }

    public function revokePermission(Request $request, Role $role)
    {
        $request->validate(['permission' => 'required|exists:permissions,name']);
        $permission = Permission::where('name', $request->permission)->first();
        $role->revokePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => 'Permission revoked from role successfully.',
            'data' => $role->load('permissions')
        ], 200);
    }
}
