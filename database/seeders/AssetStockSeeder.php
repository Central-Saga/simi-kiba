<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetStock;
use App\Models\Location;
use Illuminate\Database\Seeder;

class AssetStockSeeder extends Seeder
{
    public function run(): void
    {
        $loc = Location::all()->keyBy('code');
        $assets = Asset::all()->keyBy('asset_code');

        // Sync stok berdasarkan data aset dan penggunaannya
        $stocks = [
            // Elektronik di sekretariat
            ['asset_id' => $assets['AST-001']->id, 'location_id' => $loc['L005']->id, 'quantity' => 10, 'used_quantity' => 5],
            ['asset_id' => $assets['AST-001']->id, 'location_id' => $loc['L008']->id, 'quantity' => 3, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-001']->id, 'location_id' => $loc['L002']->id, 'quantity' => 2, 'used_quantity' => 2],

            // PC Desktop di IT
            ['asset_id' => $assets['AST-002']->id, 'location_id' => $loc['L008']->id, 'quantity' => 8, 'used_quantity' => 0],

            // Printer
            ['asset_id' => $assets['AST-003']->id, 'location_id' => $loc['L005']->id, 'quantity' => 3, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-004']->id, 'location_id' => $loc['L006']->id, 'quantity' => 2, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-004']->id, 'location_id' => $loc['L015']->id, 'quantity' => 3, 'used_quantity' => 0],

            // Scanner
            ['asset_id' => $assets['AST-005']->id, 'location_id' => $loc['L004']->id, 'quantity' => 2, 'used_quantity' => 1],

            // Proyektor
            ['asset_id' => $assets['AST-006']->id, 'location_id' => $loc['L001']->id, 'quantity' => 2, 'used_quantity' => 1],
            ['asset_id' => $assets['AST-006']->id, 'location_id' => $loc['L014']->id, 'quantity' => 1, 'used_quantity' => 1],
            ['asset_id' => $assets['AST-006']->id, 'location_id' => $loc['L015']->id, 'quantity' => 1, 'used_quantity' => 0],

            // TV
            ['asset_id' => $assets['AST-007']->id, 'location_id' => $loc['L001']->id, 'quantity' => 2, 'used_quantity' => 1],

            // AC
            ['asset_id' => $assets['AST-008']->id, 'location_id' => $loc['L005']->id, 'quantity' => 9, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-008']->id, 'location_id' => $loc['L009']->id, 'quantity' => 2, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-008']->id, 'location_id' => $loc['L012']->id, 'quantity' => 1, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-009']->id, 'location_id' => $loc['L009']->id, 'quantity' => 8, 'used_quantity' => 0],

            // UPS
            ['asset_id' => $assets['AST-010']->id, 'location_id' => $loc['L008']->id, 'quantity' => 6, 'used_quantity' => 0],

            // Kamera
            ['asset_id' => $assets['AST-011']->id, 'location_id' => $loc['L002']->id, 'quantity' => 2, 'used_quantity' => 2],

            // Sound system
            ['asset_id' => $assets['AST-012']->id, 'location_id' => $loc['L001']->id, 'quantity' => 2, 'used_quantity' => 1],

            // Server & IT
            ['asset_id' => $assets['AST-013']->id, 'location_id' => $loc['L008']->id, 'quantity' => 2, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-014']->id, 'location_id' => $loc['L008']->id, 'quantity' => 1, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-015']->id, 'location_id' => $loc['L008']->id, 'quantity' => 4, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-016']->id, 'location_id' => $loc['L008']->id, 'quantity' => 10, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-017']->id, 'location_id' => $loc['L008']->id, 'quantity' => 1, 'used_quantity' => 0],

            // Mebel
            ['asset_id' => $assets['AST-018']->id, 'location_id' => $loc['L009']->id, 'quantity' => 5, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-018']->id, 'location_id' => $loc['L011']->id, 'quantity' => 1, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-019']->id, 'location_id' => $loc['L005']->id, 'quantity' => 20, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-019']->id, 'location_id' => $loc['L015']->id, 'quantity' => 5, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-020']->id, 'location_id' => $loc['L005']->id, 'quantity' => 25, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-020']->id, 'location_id' => $loc['L017']->id, 'quantity' => 5, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-021']->id, 'location_id' => $loc['L001']->id, 'quantity' => 30, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-021']->id, 'location_id' => $loc['L015']->id, 'quantity' => 20, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-022']->id, 'location_id' => $loc['L004']->id, 'quantity' => 10, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-023']->id, 'location_id' => $loc['L017']->id, 'quantity' => 6, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-024']->id, 'location_id' => $loc['L003']->id, 'quantity' => 4, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-025']->id, 'location_id' => $loc['L014']->id, 'quantity' => 3, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-026']->id, 'location_id' => $loc['L003']->id, 'quantity' => 2, 'used_quantity' => 0],

            // Kendaraan
            ['asset_id' => $assets['AST-027']->id, 'location_id' => $loc['L020']->id, 'quantity' => 1, 'used_quantity' => 1],
            ['asset_id' => $assets['AST-028']->id, 'location_id' => $loc['L020']->id, 'quantity' => 2, 'used_quantity' => 1],
            ['asset_id' => $assets['AST-029']->id, 'location_id' => $loc['L020']->id, 'quantity' => 3, 'used_quantity' => 2],

            // Peralatan sidang
            ['asset_id' => $assets['AST-030']->id, 'location_id' => $loc['L001']->id, 'quantity' => 4, 'used_quantity' => 2],
            ['asset_id' => $assets['AST-031']->id, 'location_id' => $loc['L002']->id, 'quantity' => 2, 'used_quantity' => 1],
            ['asset_id' => $assets['AST-032']->id, 'location_id' => $loc['L002']->id, 'quantity' => 3, 'used_quantity' => 1],

            // Perlengkapan ibadah
            ['asset_id' => $assets['AST-033']->id, 'location_id' => $loc['L018']->id, 'quantity' => 10, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-034']->id, 'location_id' => $loc['L018']->id, 'quantity' => 5, 'used_quantity' => 0],

            // Perlengkapan dapur
            ['asset_id' => $assets['AST-035']->id, 'location_id' => $loc['L019']->id, 'quantity' => 2, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-036']->id, 'location_id' => $loc['L019']->id, 'quantity' => 4, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-037']->id, 'location_id' => $loc['L019']->id, 'quantity' => 2, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-038']->id, 'location_id' => $loc['L019']->id, 'quantity' => 1, 'used_quantity' => 0],

            // Perlengkapan kebersihan
            ['asset_id' => $assets['AST-039']->id, 'location_id' => $loc['L015']->id, 'quantity' => 3, 'used_quantity' => 0],
            ['asset_id' => $assets['AST-040']->id, 'location_id' => $loc['L015']->id, 'quantity' => 1, 'used_quantity' => 0],
        ];

        foreach ($stocks as $stock) {
            AssetStock::create($stock);
        }
    }
}
