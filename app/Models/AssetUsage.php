<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
