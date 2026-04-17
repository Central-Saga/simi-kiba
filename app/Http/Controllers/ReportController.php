<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetUsage;
use App\Models\AssetMutation;
use App\Models\Location;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::all();
        $categories = Asset::select('category')->distinct()->whereNotNull('category')->pluck('category');

        $query = Asset::with('location');

        if ($request->location_id) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        $assets = $query->get();

        return view('pages.admin.reports.index', compact('assets', 'locations', 'categories'));
    }

    public function print(Request $request)
    {
        $query = Asset::with('location');

        if ($request->location_id) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        $assets = $query->get();
        
        $location = $request->location_id ? Location::find($request->location_id) : null;
        
        $filters = [
            'location' => $location ? $location->name : 'Semua',
            'category' => $request->category ?: 'Semua',
            'condition' => $request->condition ?: 'Semua',
        ];

        return view('pages.admin.reports.print', compact('assets', 'filters'));
    }
}
