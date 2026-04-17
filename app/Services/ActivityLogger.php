<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($type, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => $type,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
