<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\AssetUsage;
use App\Models\Location;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->stafDashboard();
    }

    private function adminDashboard()
    {
        $stats = [
            'total_assets' => Asset::count(),
            'total_locations' => Location::count(),
            'total_usages' => AssetUsage::count(),
            'total_mutations' => AssetMutation::count(),
            'total_requests' => StockRequest::count(),
            'pending_requests' => StockRequest::where('status', 'diajukan')->count(),
        ];

        $condition_stats = [
            'baik' => Asset::where('condition', 'baik')->count(),
            'cukup' => Asset::where('condition', 'cukup')->count(),
            'rusak' => Asset::where('condition', 'rusak')->count(),
        ];

        $recent_activities = ActivityLog::with('user')->latest()->take(10)->get();
        $recent_requests = StockRequest::with('requester')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'condition_stats', 'recent_activities', 'recent_requests'));
    }

    private function stafDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'available_assets' => Asset::where('quantity', '>', 0)->count(),
            'my_usages' => AssetUsage::where('user_id', $user->id)->count(),
            'my_requests' => StockRequest::where('requested_by', $user->id)->count(),
        ];

        $recent_usages = AssetUsage::with('asset')->where('user_id', $user->id)->latest()->take(5)->get();
        $recent_requests = StockRequest::where('requested_by', $user->id)->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_usages', 'recent_requests'));
    }
}
