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
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@simi.com',
            'password' => Hash::make('password'),
            'role' => 'administrator',
            'is_active' => true,
        ]);

        // Staf Operasional
        User::create([
            'name' => 'Staf Operasional',
            'email' => 'staf@simi.com',
            'password' => Hash::make('password'),
            'role' => 'staf_operasional',
            'is_active' => true,
        ]);
    }
}
