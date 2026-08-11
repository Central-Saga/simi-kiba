<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssetMutationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@simi.com')->first();
        $loc = Location::all()->keyBy('code');
        $assets = Asset::all()->keyBy('asset_code');

        $mutations = [
            // Mutasi AC dari gudang ke ruang komisioner
            [
                'asset_id' => $assets['AST-008']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L009']->id,
                'mutation_date' => '2026-05-10',
                'quantity' => 2,
                'notes' => 'Pemasangan AC baru di ruang ketua komisioner',
                'created_by' => $admin->id,
            ],
            // Mutasi meja dari gudang ke sekretariat
            [
                'asset_id' => $assets['AST-019']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L005']->id,
                'mutation_date' => '2026-05-15',
                'quantity' => 5,
                'notes' => 'Penambahan meja untuk staf baru sekretariat',
                'created_by' => $admin->id,
            ],
            // Mutasi laptop dari IT ke sekretariat
            [
                'asset_id' => $assets['AST-001']->id,
                'from_location_id' => $loc['L008']->id,
                'to_location_id' => $loc['L005']->id,
                'mutation_date' => '2026-05-20',
                'quantity' => 3,
                'notes' => 'Distribusi laptop untuk staf administrasi baru',
                'created_by' => $admin->id,
            ],
            // Mutasi kursi dari gudang ke ruang sidang
            [
                'asset_id' => $assets['AST-021']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L001']->id,
                'mutation_date' => '2026-05-25',
                'quantity' => 20,
                'notes' => 'Penambahan kursi untuk kapasitas ruang sidang utama',
                'created_by' => $admin->id,
            ],
            // Mutasi printer dari gudang ke kepegawaian
            [
                'asset_id' => $assets['AST-004']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L006']->id,
                'mutation_date' => '2026-06-01',
                'quantity' => 2,
                'notes' => 'Printer baru untuk bagian kepegawaian',
                'created_by' => $admin->id,
            ],
            // Mutasi AC dari gudang ke ruang komisioner II
            [
                'asset_id' => $assets['AST-008']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L012']->id,
                'mutation_date' => '2026-06-05',
                'quantity' => 1,
                'notes' => 'Pemasangan AC di ruang komisioner II',
                'created_by' => $admin->id,
            ],
            // Mutasi scanner dari sekretariat ke arsip
            [
                'asset_id' => $assets['AST-005']->id,
                'from_location_id' => $loc['L005']->id,
                'to_location_id' => $loc['L004']->id,
                'mutation_date' => '2026-06-08',
                'quantity' => 1,
                'notes' => 'Scanner dipindahkan ke ruang arsip untuk digitalisasi dokumen',
                'created_by' => $admin->id,
            ],
            // Mutasi meja dari gudang ke ruang komisioner
            [
                'asset_id' => $assets['AST-018']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L011']->id,
                'mutation_date' => '2026-06-12',
                'quantity' => 1,
                'notes' => 'Meja eksekutif baru untuk komisioner I',
                'created_by' => $admin->id,
            ],
            // Mutasi laptop dari IT ke ruang sidang media
            [
                'asset_id' => $assets['AST-001']->id,
                'from_location_id' => $loc['L008']->id,
                'to_location_id' => $loc['L002']->id,
                'mutation_date' => '2026-06-15',
                'quantity' => 2,
                'notes' => 'Laptop untuk operator sidang media',
                'created_by' => $admin->id,
            ],
            // Mutasi kursi dari gudang ke perpustakaan
            [
                'asset_id' => $assets['AST-020']->id,
                'from_location_id' => $loc['L015']->id,
                'to_location_id' => $loc['L017']->id,
                'mutation_date' => '2026-06-18',
                'quantity' => 5,
                'notes' => 'Kursi untuk area baca perpustakaan',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($mutations as $mutation) {
            AssetMutation::create($mutation);
        }
    }
}
