<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['code' => 'L001', 'name' => 'Ruang Sidang Utama', 'description' => 'Ruang sidang utama di lantai 1'],
            ['code' => 'L002', 'name' => 'Ruang Sekretariat', 'description' => 'Ruang administrasi sekretariat'],
            ['code' => 'L003', 'name' => 'Gudang Inventaris', 'description' => 'Gudang penyimpanan barang'],
            ['code' => 'L004', 'name' => 'Ruang Komisioner', 'description' => 'Ruang kerja para komisioner'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
