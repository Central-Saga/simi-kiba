<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'from_location_id',
        'to_location_id',
        'mutation_date',
        'quantity',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'mutation_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::created(function ($mutation) {
            // // Deduct from source
            // $fromStock = AssetStock::firstOrCreate([
            //     'asset_id' => $mutation->asset_id,
            //     'location_id' => $mutation->from_location_id,
            // ]);
            // $fromStock->decrement('quantity', $mutation->quantity);

            // // Add to destination
            // $toStock = AssetStock::firstOrCreate([
            //     'asset_id' => $mutation->asset_id,
            //     'location_id' => $mutation->to_location_id,
            // ]);
            // $toStock->increment('quantity', $mutation->quantity);
        });
    }
}
