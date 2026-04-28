<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@simi.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'administrator',
                'is_active' => true,
            ]
        );

        // Staf Operasional
        User::updateOrCreate(
            ['email' => 'staf@simi.com'],
            [
                'name' => 'Staf Operasional',
                'password' => Hash::make('password'),
                'role' => 'staf_operasional',
                'is_active' => true,
            ]
        );
    }
}
