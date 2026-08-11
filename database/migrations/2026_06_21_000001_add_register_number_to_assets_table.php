<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('register_number')->nullable()->after('asset_code');
            $table->unique('register_number');
        });

        // Backfill existing rows with a deterministic sequence so we can
        // safely add the unique constraint without violating existing data.
        $assets = DB::table('assets')->orderBy('id')->get();
        $sequence = 1;
        foreach ($assets as $asset) {
            DB::table('assets')
                ->where('id', $asset->id)
                ->update([
                    'register_number' => 'REG-'.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT),
                ]);
            $sequence++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropUnique(['register_number']);
            $table->dropColumn('register_number');
        });
    }
};
