<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\Location;
use App\Services\ActivityLogger;
use App\Http\Requests\AssetMutation\AssetMutationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetMutationController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetMutation::with(['asset', 'fromLocation', 'toLocation', 'creator']);

        if ($request->search) {
            $query->whereHas('asset', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $mutations = $query->latest()->paginate(10)->withQueryString();
        
        return view('pages.admin.mutations.index', compact('mutations'));
    }

    public function show(AssetMutation $mutation)
    {
        $mutation->load(['asset.location', 'fromLocation', 'toLocation', 'creator']);
        return view('pages.admin.mutations.show', compact('mutation'));
    }

    public function create()
    {
        $assets = Asset::all();
        $locations = Location::all();
        return view('pages.admin.mutations.create', compact('assets', 'locations'));
    }

    public function store(AssetMutationRequest $request)
    {
        if ($request->from_location_id == $request->to_location_id) {
            return back()->withInput()->with('error', 'Lokasi asal dan tujuan tidak boleh sama.');
        }

        $asset = Asset::findOrFail($request->asset_id);

        if ($request->quantity > $asset->quantity) {
             return back()->withInput()->with('error', 'Jumlah mutasi melebihi stok yang tersedia.');
        }

        DB::transaction(function () use ($request, $asset) {
            $mutation = AssetMutation::create([
                'asset_id' => $request->asset_id,
                'from_location_id' => $request->from_location_id,
                'to_location_id' => $request->to_location_id,
                'mutation_date' => $request->mutation_date,
                'quantity' => $request->quantity,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Update asset primary location
            $asset->update(['location_id' => $request->to_location_id]);

            ActivityLogger::log('Mutasi Aset', "Mutasi aset: {$asset->name} ke " . Location::find($request->to_location_id)->name);
        });

        return redirect()->route('admin.mutations.index')->with('success', 'Mutasi aset berhasil dicatat dan lokasi aset telah diperbarui.');
    }
}
