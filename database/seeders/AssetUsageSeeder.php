<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetUsage;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssetUsageSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@simi.com')->first();
        $staf = User::where('email', 'staf@simi.com')->first();
        $loc = Location::all()->keyBy('code');
        $assets = Asset::all()->keyBy('asset_code');

        $usages = [
            // Sidang sengketa informasi - penggunaan ruang sidang
            [
                'asset_id' => $assets['AST-006']->id,
                'location_id' => $loc['L001']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-10',
                'quantity' => 1,
                'purpose' => 'Sidang Sengketa Informasi - Kasus 05/S/2026',
                'notes' => 'Proyektor digunakan untuk presentasi bukti dokumen',
            ],
            [
                'asset_id' => $assets['AST-007']->id,
                'location_id' => $loc['L001']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-10',
                'quantity' => 1,
                'purpose' => 'Sidang Sengketa Informasi - Kasus 05/S/2026',
                'notes' => 'TV monitor untuk menampilkan data pendukung sidang',
            ],
            [
                'asset_id' => $assets['AST-030']->id,
                'location_id' => $loc['L001']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-10',
                'quantity' => 2,
                'purpose' => 'Sidang Sengketa Informasi - Kasus 05/S/2026',
                'notes' => 'Mikrofon untuk komisioner dan pemohon',
            ],
            // Dokumentasi sidang
            [
                'asset_id' => $assets['AST-011']->id,
                'location_id' => $loc['L002']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-10',
                'quantity' => 1,
                'purpose' => 'Dokumentasi sidang sengketa informasi',
                'notes' => 'Dokumentasi foto untuk arsip sidang',
            ],
            [
                'asset_id' => $assets['AST-031']->id,
                'location_id' => $loc['L002']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-10',
                'quantity' => 1,
                'purpose' => 'Rekaman audio sidang sengketa',
                'notes' => 'Rekaman resmi untuk berita acara sidang',
            ],
            // Rapat pimpinan
            [
                'asset_id' => $assets['AST-006']->id,
                'location_id' => $loc['L014']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-12',
                'quantity' => 1,
                'purpose' => 'Rapat Koordinasi Pimpinan Bulanan',
                'notes' => 'Proyektor untuk presentasi laporan kinerja',
            ],
            // Kegiatan sosialisasi
            [
                'asset_id' => $assets['AST-011']->id,
                'location_id' => $loc['L002']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-15',
                'quantity' => 1,
                'purpose' => 'Sosialisasi Keterbukaan Informasi Publik di Kabupaten Badung',
                'notes' => 'Dokumentasi kegiatan sosialisasi lapangan',
            ],
            [
                'asset_id' => $assets['AST-032']->id,
                'location_id' => $loc['L002']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-15',
                'quantity' => 1,
                'purpose' => 'Sosialisasi Keterbukaan Informasi Publik',
                'notes' => 'Lighting untuk dokumentasi dan live streaming',
            ],
            // Penggunaan kendaraan
            [
                'asset_id' => $assets['AST-028']->id,
                'location_id' => $loc['L020']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-17',
                'quantity' => 1,
                'purpose' => 'Kunjungan Lapangan - Monitoring PPID Kabupaten Gianyar',
                'notes' => 'Kendaraan operasional untuk tim monitoring',
            ],
            [
                'asset_id' => $assets['AST-029']->id,
                'location_id' => $loc['L020']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-18',
                'quantity' => 2,
                'purpose' => 'Pengantaran dokumen sengketa ke Pengadilan',
                'notes' => 'Motor dinas untuk pengantaran dokumen cepat',
            ],
            // Sidang lanjutan
            [
                'asset_id' => $assets['AST-006']->id,
                'location_id' => $loc['L001']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-20',
                'quantity' => 1,
                'purpose' => 'Sidang Lanjutan - Kasus 07/S/2026',
                'notes' => 'Proyektor untuk presentasi bukti',
            ],
            [
                'asset_id' => $assets['AST-030']->id,
                'location_id' => $loc['L001']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-20',
                'quantity' => 2,
                'purpose' => 'Sidang Lanjutan - Kasus 07/S/2026',
                'notes' => 'Mikrofon untuk persidangan',
            ],
            // Rapat koordinasi dengan PPID
            [
                'asset_id' => $assets['AST-012']->id,
                'location_id' => $loc['L001']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-22',
                'quantity' => 1,
                'purpose' => 'Rapat Koordinasi PPID se-Bali',
                'notes' => 'Sound system untuk acara dengan peserta 40 orang',
            ],
            // Penggunaan laptop untuk pelatihan
            [
                'asset_id' => $assets['AST-001']->id,
                'location_id' => $loc['L008']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-24',
                'quantity' => 5,
                'purpose' => 'Pelatihan Aplikasi PPID Online untuk Desa',
                'notes' => 'Laptop untuk peserta pelatihan',
            ],
            // Dokumentasi kegiatan
            [
                'asset_id' => $assets['AST-011']->id,
                'location_id' => $loc['L002']->id,
                'user_id' => $staf->id,
                'usage_date' => '2026-06-25',
                'quantity' => 1,
                'purpose' => 'Liputan Media - Hari Keterbukaan Informasi',
                'notes' => 'Dokumentasi foto dan video kegiatan',
            ],
            // Penggunaan kendaraan dinas ketua
            [
                'asset_id' => $assets['AST-027']->id,
                'location_id' => $loc['L020']->id,
                'user_id' => $admin->id,
                'usage_date' => '2026-06-26',
                'quantity' => 1,
                'purpose' => 'Rapat dengan Gubernur Bali - Pembahasan Perda KIP',
                'notes' => 'Kendaraan dinas ketua komisioner',
            ],
        ];

        foreach ($usages as $usage) {
            AssetUsage::create($usage);
        }
    }
}
