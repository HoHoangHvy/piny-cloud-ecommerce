<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $request->validate([
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'description' => $request->description,
                'is_admin' => $request->is_admin ? 1 : 0,
                'apply_team_visibility' => $request->apply_team_visibility ? 1 : 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create role.',
                'error' => $e->getMessage()
            ], 500);
        }
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
