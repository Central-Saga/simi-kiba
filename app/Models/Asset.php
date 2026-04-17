<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_code',
        'name',
        'category',
        'quantity',
        'unit',
        'condition',
        'location_id',
        'description',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function usages()
    {
        return $this->hasMany(AssetUsage::class);
    }

    public function mutations()
    {
        return $this->hasMany(AssetMutation::class);
    }
}
