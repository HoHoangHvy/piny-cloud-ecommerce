<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define your modules and actions
        $modules = ['user', 'product', 'order', 'customer', 'category', 'employee', 'voucher'];
        $actions = ['view-detail', 'view-list', 'create', 'update', 'delete'];

        // Loop through each module and action to create permissions
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$action}-{$module}"]);
            }
        }
    }
}
