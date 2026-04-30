<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_assets', 'create_assets', 'edit_assets', 'delete_assets',
            'view_activity_logs', 'manage_settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'administrator']);
        $stafRole = Role::firstOrCreate(['name' => 'staf_operasional']);

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());

        // Assign some permissions to staff
        $stafRole->syncPermissions(['view_assets', 'view_users']);

        // Create dummy roles for testing
        Role::factory()->count(3)->create();

        // Assign to existing users
        $admin = User::where('email', 'admin@simi.com')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }

        $staf = User::where('email', 'staf@simi.com')->first();
        if ($staf) {
            $staf->assignRole($stafRole);
        }
    }
}
