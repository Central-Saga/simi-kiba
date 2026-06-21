<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Location;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = Location::all();

        $assets = [
            [
                'asset_code' => 'AST-001',
                'register_number' => 'REG-0001',
                'name' => 'Laptop Dell XPS 15',
                'category' => 'Elektronik',
                'quantity' => 5,
                'unit' => 'Unit',
                'condition' => 'baik',
                'location_id' => $locations->where('code', 'L002')->first()->id,
                'description' => 'Laptop untuk operasional staf',
            ],
            [
                'asset_code' => 'AST-002',
                'register_number' => 'REG-0002',
                'name' => 'Printer Epson L3110',
                'category' => 'Peralatan Kantor',
                'quantity' => 2,
                'unit' => 'Unit',
                'condition' => 'baik',
                'location_id' => $locations->where('code', 'L003')->first()->id,
                'description' => 'Printer warna multifungsi',
            ],
            [
                'asset_code' => 'AST-003',
                'register_number' => 'REG-0003',
                'name' => 'Meja Kerja Kayu Jati',
                'category' => 'Mebel',
                'quantity' => 10,
                'unit' => 'Unit',
                'condition' => 'cukup',
                'location_id' => $locations->where('code', 'L001')->first()->id,
                'description' => 'Meja kerja standar ruang sidang',
            ],
            [
                'asset_code' => 'AST-004',
                'register_number' => 'REG-0004',
                'name' => 'AC Split Panasonic 1PK',
                'category' => 'Elektronik',
                'quantity' => 4,
                'unit' => 'Unit',
                'condition' => 'rusak',
                'location_id' => $locations->where('code', 'L004')->first()->id,
                'description' => 'AC ruang komisioner, perlu perbaikan',
            ],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}
