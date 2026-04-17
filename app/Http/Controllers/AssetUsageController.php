<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetUsage;
use App\Http\Requests\AssetUsage\AssetUsageRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetUsageController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetUsage::with(['asset', 'user']);

        if ($request->search) {
            $query->whereHas('asset', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $usages = $query->latest()->paginate(10)->withQueryString();
        
        $view = Auth::user()->isAdmin() ? 'pages.admin.usages.index' : 'pages.staf.usages.index';
        return view($view, compact('usages'));
    }

    public function show(AssetUsage $usage)
    {
        $usage->load(['asset.location', 'user']);
        
        $view = Auth::user()->isAdmin() ? 'pages.admin.usages.show' : 'pages.staf.usages.show';
        return view($view, compact('usage'));
    }

    public function create()
    {
        $assets = Asset::where('quantity', '>', 0)->get();
        
        $view = Auth::user()->isAdmin() ? 'pages.admin.usages.create' : 'pages.staf.usages.create';
        return view($view, compact('assets'));
    }

    public function store(AssetUsageRequest $request)
    {
        $asset = Asset::findOrFail($request->asset_id);

        if ($request->quantity > $asset->quantity) {
            return back()->withInput()->with('error', 'Jumlah penggunaan melebihi stok yang tersedia.');
        }

        DB::transaction(function () use ($request, $asset) {
            $usage = AssetUsage::create([
                'asset_id' => $request->asset_id,
                'user_id' => Auth::id(),
                'usage_date' => $request->usage_date,
                'quantity' => $request->quantity,
                'purpose' => $request->purpose,
                'notes' => $request->notes,
            ]);

            $asset->decrement('quantity', $request->quantity);

            ActivityLogger::log('Penggunaan Aset', "Mencatat penggunaan aset: {$asset->name}, Jumlah: {$request->quantity}");
        });

        $route = Auth::user()->isAdmin() ? 'admin.usages.index' : 'staf.usages.index';
        return redirect()->route($route)->with('success', 'Catatan penggunaan aset berhasil disimpan.');
    }
}
