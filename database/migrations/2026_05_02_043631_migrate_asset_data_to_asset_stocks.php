<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $assets = DB::table('assets')->get();
        foreach ($assets as $asset) {
            if ($asset->location_id && $asset->quantity > 0) {
                DB::table('asset_stocks')->insert([
                    'asset_id' => $asset->id,
                    'location_id' => $asset->location_id,
                    'quantity' => $asset->quantity,
                    'used_quantity' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_stocks', function (Blueprint $table) {
            //
        });
    }
};
