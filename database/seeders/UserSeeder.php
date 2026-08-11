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

        // Staf dengan nama Bali
        $staff = [
            ['name' => 'I Wayan Sudarma', 'email' => 'staf@simi.com'],
            ['name' => 'Ni Putu Ayu Lestari', 'email' => 'putu.lestari@simi.com'],
            ['name' => 'I Komang Adi Wirawan', 'email' => 'komang.wirawan@simi.com'],
            ['name' => 'Ni Made Sari Dewi', 'email' => 'made.sari@simi.com'],
            ['name' => 'I Nyoman Gede Purnama', 'email' => 'nyoman.purnama@simi.com'],
            ['name' => 'Ni Ketut Ratna Wulandari', 'email' => 'ketut.ratna@simi.com'],
            ['name' => 'I Gede Putra Astika', 'email' => 'gede.astika@simi.com'],
            ['name' => 'Ni Luh Putu Indah Pratiwi', 'email' => 'luh.indah@simi.com'],
            ['name' => 'I Made Agus Wirawan', 'email' => 'made.agus@simi.com'],
            ['name' => 'Ni Wayan Suci Rahayu', 'email' => 'wayan.suci@simi.com'],
        ];

        foreach ($staff as $s) {
            User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['name'],
                    'password' => Hash::make('password'),
                    'role' => 'staf_operasional',
                    'is_active' => true,
                ]
            );
        }
    }
}
