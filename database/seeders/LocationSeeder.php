<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Lantai 1 - Pelayanan & Sidang
            ['code' => 'L001', 'name' => 'Ruang Sidang Utama', 'description' => 'Ruang sidang utama lantai 1, kapasitas 50 orang'],
            ['code' => 'L002', 'name' => 'Ruang Sidang Media', 'description' => 'Ruang sidang khusus sengketa media informasi'],
            ['code' => 'L003', 'name' => 'Lobby & Resepsionis', 'description' => 'Area penerimaan tamu dan informasi publik'],
            ['code' => 'L004', 'name' => 'Ruang Arsip & Dokumentasi', 'description' => 'Penyimpanan arsip dan dokumen sengketa informasi'],

            // Lantai 2 - Sekretariat & Administrasi
            ['code' => 'L005', 'name' => 'Ruang Sekretariat', 'description' => 'Ruang administrasi dan kesekretariatan utama'],
            ['code' => 'L006', 'name' => 'Ruang Kepegawaian & Umum', 'description' => 'Bagian kepegawaian dan urusan umum'],
            ['code' => 'L007', 'name' => 'Ruang Keuangan', 'description' => 'Bagian perencanaan, keuangan, dan pelaporan'],
            ['code' => 'L008', 'name' => 'Ruang IT & Pengelola Data', 'description' => 'Pusat data dan infrastruktur teknologi informasi'],

            // Lantai 3 - Komisioner & Pimpinan
            ['code' => 'L009', 'name' => 'Ruang Ketua Komisioner', 'description' => 'Ruang kerja Ketua Komisi Informasi Bali'],
            ['code' => 'L010', 'name' => 'Ruang Wakil Ketua', 'description' => 'Ruang kerja Wakil Ketua Komisi Informasi Bali'],
            ['code' => 'L011', 'name' => 'Ruang Komisioner I', 'description' => 'Ruang kerja Komisioner Bidang Kelembagaan'],
            ['code' => 'L012', 'name' => 'Ruang Komisioner II', 'description' => 'Ruang kerja Komisioner Bidang Advokasi & Sosialisasi'],
            ['code' => 'L013', 'name' => 'Ruang Komisioner III', 'description' => 'Ruang kerja Komisioner Bidang Penyelesaian Sengketa'],
            ['code' => 'L014', 'name' => 'Ruang Rapat Pimpinan', 'description' => 'Ruang rapat terbatas pimpinan dan komisioner'],

            // Fasilitas Umum
            ['code' => 'L015', 'name' => 'Gudang Inventaris Utama', 'description' => 'Gudang penyimpanan barang inventaris utama'],
            ['code' => 'L016', 'name' => 'Gudang ATK', 'description' => 'Gudang penyimpanan alat tulis kantor dan perlengkapan habis pakai'],
            ['code' => 'L017', 'name' => 'Perpustakaan & Pusat Informasi', 'description' => 'Perpustakaan referensi keterbukaan informasi publik'],
            ['code' => 'L018', 'name' => 'Mushola', 'description' => 'Tempat ibadah di lingkungan kantor'],
            ['code' => 'L019', 'name' => 'Pantry & Ruang Istirahat', 'description' => 'Dapur kecil dan ruang istirahat pegawai'],
            ['code' => 'L020', 'name' => 'Area Parkir Kantor', 'description' => 'Area parkir kendaraan dinas dan pegawai'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
