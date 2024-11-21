<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::findOrCreate('admin');
        $employeeRole = Role::findOrCreate('employee');
        $managerRole = Role::findOrCreate('manager');
        $customerRole = Role::findOrCreate('customer');

        // Assign all permissions to the admin role
        $adminRole->syncPermissions(Permission::all());

        // Define permissions for each role
        $managerPermissions = [
            'view-list-product', 'view-detail-product', 'create-product', 'update-product', 'delete-product',
            'view-list-order', 'view-detail-order', 'create-order', 'update-order',
            'view-list-customer', 'view-detail-customer', 'update-customer',
            'view-list-employee', 'view-detail-employee',
            'view-list-category', 'view-detail-category', 'create-category', 'update-category', 'delete-category',
            'view-list-voucher', 'view-detail-voucher', 'create-voucher', 'update-voucher', 'delete-voucher',
        ];

        $employeePermissions = [
            'view-list-product', 'view-detail-product',
            'view-list-order', 'view-detail-order', 'create-order',
            'view-list-customer', 'view-detail-customer', 'update-customer',
            'view-list-category', 'view-detail-category',
            'view-list-voucher', 'view-detail-voucher',
        ];

        $customerPermissions = [
            'view-list-product', 'view-detail-product',
            'view-list-order', 'view-detail-order',
        ];

        // Assign permissions to each role
        $managerRole->syncPermissions($managerPermissions);
        $employeeRole->syncPermissions($employeePermissions);
        $customerRole->syncPermissions($customerPermissions);
    }
}
