<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'location_id',
        'user_id',
        'usage_date',
        'quantity',
        'purpose',
        'notes',
    ];

    protected $casts = [
        'usage_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($usage) {
            // if ($usage->location_id) {
            //     $stock = AssetStock::firstOrCreate([
            //         'asset_id' => $usage->asset_id,
            //         'location_id' => $usage->location_id,
            //     ]);
            //     $stock->increment('used_quantity', $usage->quantity);
            // }
        });
    }
}
