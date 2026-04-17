<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\Location\LocationRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $locations = $query->withCount('assets')->latest()->paginate(10)->withQueryString();
        
        $totalLocations = Location::count();
        $emptyLocations = Location::doesntHave('assets')->count();
        $totalMappedAssets = \App\Models\Asset::whereNotNull('location_id')->count();
        
        return view('pages.admin.locations.index', compact('locations', 'totalLocations', 'emptyLocations', 'totalMappedAssets'));
    }

    public function create()
    {
        return view('pages.admin.locations.create');
    }

    public function store(LocationRequest $request)
    {
        Location::create($request->validated());

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('pages.admin.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        if ($location->assets()->count() > 0) {
            return back()->with('error', 'Lokasi tidak bisa dihapus karena masih memiliki aset.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
