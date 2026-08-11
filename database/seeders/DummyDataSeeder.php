<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\AssetUsage;
use App\Models\Location;
use App\Models\StockRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@simi.com')->first() ?? User::first();
        $staf = User::where('email', 'staf@simi.com')->first() ?? $user;
        $asset = Asset::first();
        $location1 = Location::first();
        $location2 = Location::skip(1)->first() ?? $location1;

        if ($user && $asset) {
            // Stock Request (Permintaan Stok Pending - diajukan)
            StockRequest::firstOrCreate(
                ['item_name' => 'Kertas A4 80gsm'],
                [
                    'requested_by' => $staf->id,
                    'quantity' => 5,
                    'request_date' => now()->format('Y-m-d'),
                    'status' => 'diajukan',
                    'notes' => 'Untuk keperluan print dokumen rapat',
                ]
            );

            // Asset Usage (Penggunaan Asset)
            AssetUsage::firstOrCreate(
                ['notes' => 'Peminjaman sementara untuk acara luar kantor'],
                [
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'usage_date' => now()->format('Y-m-d'),
                    'quantity' => 1,
                    'purpose' => 'Presentasi di luar kota',
                ]
            );

            // Asset Mutation (Mutasi Asset)
            AssetMutation::firstOrCreate(
                ['notes' => 'Pindah ruangan karena renovasi'],
                [
                    'asset_id' => $asset->id,
                    'from_location_id' => $location1->id,
                    'to_location_id' => $location2->id,
                    'mutation_date' => now()->format('Y-m-d'),
                    'quantity' => 1,
                    'created_by' => $user->id,
                ]
            );
        }
    }
}
