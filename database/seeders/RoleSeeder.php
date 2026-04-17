<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $stafRole = Role::create(['name' => 'staf']);

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
