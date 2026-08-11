<?php

namespace Database\Seeders;

use App\Models\StockRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockRequestSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@simi.com')->first();
        $staf = User::where('email', 'staf@simi.com')->first();

        $requests = [
            // Disetujui
            [
                'requested_by' => $staf->id,
                'item_name' => 'Kertas HVS A4 80gr',
                'quantity' => 10,
                'request_date' => '2026-06-01',
                'status' => 'disetujui',
                'notes' => 'Kebutuhan cetak dokumen sidang',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-02 09:00:00',
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Tinta Printer Epson 003',
                'quantity' => 5,
                'request_date' => '2026-06-03',
                'status' => 'disetujui',
                'notes' => 'Tinta untuk printer sekretariat',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-03 14:30:00',
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Map Dokumen Plastik',
                'quantity' => 25,
                'request_date' => '2026-06-05',
                'status' => 'disetujui',
                'notes' => 'Map untuk berkas sengketa informasi',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-05 10:15:00',
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Ballpoint Pilot G-2',
                'quantity' => 20,
                'request_date' => '2026-06-07',
                'status' => 'disetujui',
                'notes' => 'Alat tulis untuk peserta sidang',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-07 11:00:00',
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Amplop Coklat',
                'quantity' => 30,
                'request_date' => '2026-06-08',
                'status' => 'disetujui',
                'notes' => 'Pengiriman dokumen ke PPID Kabupaten',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-08 09:30:00',
            ],

            // Pending
            [
                'requested_by' => $staf->id,
                'item_name' => 'Stapler Max HD-10',
                'quantity' => 5,
                'request_date' => '2026-06-15',
                'status' => 'diajukan',
                'notes' => 'Stapler baru untuk ruang sekretariat',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Baterai AA Alkaline',
                'quantity' => 20,
                'request_date' => '2026-06-16',
                'status' => 'diajukan',
                'notes' => 'Baterai untuk remote AC dan perangkat rapat',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Kabel LAN Cat6 5m',
                'quantity' => 10,
                'request_date' => '2026-06-18',
                'status' => 'diajukan',
                'notes' => 'Kabel jaringan untuk penambahan titik LAN di ruang komisioner',
                'approved_by' => null,
                'approved_at' => null,
            ],

            // Ditolak
            [
                'requested_by' => $staf->id,
                'item_name' => 'Monitor 24" LED',
                'quantity' => 3,
                'request_date' => '2026-06-10',
                'status' => 'ditolak',
                'notes' => 'Monitor tambahan untuk staf',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-11 08:00:00',
            ],
            [
                'requested_by' => $staf->id,
                'item_name' => 'Headset Wireless',
                'quantity' => 5,
                'request_date' => '2026-06-12',
                'status' => 'ditolak',
                'notes' => 'Headset untuk meeting online',
                'approved_by' => $admin->id,
                'approved_at' => '2026-06-12 15:00:00',
            ],
        ];

        foreach ($requests as $request) {
            StockRequest::create($request);
        }
    }
}
