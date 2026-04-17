<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Http\Requests\Asset\AssetRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with('location');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('asset_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        if ($request->location_id) {
            $query->where('location_id', $request->location_id);
        }

        $assets = $query->latest()->paginate(10)->withQueryString();
        $locations = Location::all();
        $categories = Asset::select('category')->distinct()->whereNotNull('category')->pluck('category');

        $totalAssets = Asset::count();
        $baikCount = Asset::where('condition', 'baik')->count();
        $cukupCount = Asset::where('condition', 'cukup')->count();
        $rusakCount = Asset::where('condition', 'rusak')->count();

        $view = Auth::user()->isAdmin() ? 'pages.admin.assets.index' : 'pages.staf.assets.index';
        
        return view($view, compact('assets', 'locations', 'categories', 'totalAssets', 'baikCount', 'cukupCount', 'rusakCount'));
    }

    public function show(Asset $asset)
    {
        $asset->load('location', 'usages.user', 'mutations.fromLocation', 'mutations.toLocation');
        
        $view = Auth::user()->isAdmin() ? 'pages.admin.assets.show' : 'pages.staf.assets.show';
        return view($view, compact('asset'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('pages.admin.assets.create', compact('locations'));
    }

    public function store(AssetRequest $request)
    {
        $asset = Asset::create($request->validated());

        ActivityLogger::log('Aset Baru', "Menambah aset baru: {$asset->name} ({$asset->asset_code})");

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $locations = Location::all();
        return view('pages.admin.assets.edit', compact('asset', 'locations'));
    }

    public function update(AssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        ActivityLogger::log('Update Aset', "Memperbarui data aset: {$asset->name}");

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $name = $asset->name;
        $code = $asset->asset_code;
        
        $asset->delete();

        ActivityLogger::log('Hapus Aset', "Menghapus aset: {$name} ({$code})");

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
