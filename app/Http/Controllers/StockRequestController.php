<?php

namespace App\Http\Controllers;

use App\Models\StockRequest;
use App\Services\ActivityLogger;
use App\Http\Requests\StockRequest\StockRequestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = StockRequest::with(['requester', 'approver']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if (!Auth::user()->isAdmin()) {
            $query->where('requested_by', Auth::id());
        }

        $requests = $query->latest()->paginate(10)->withQueryString();
        
        $view = Auth::user()->isAdmin() ? 'pages.admin.requests.index' : 'pages.staf.requests.index';
        return view($view, compact('requests'));
    }

    public function show(StockRequest $stockRequest)
    {
        $stockRequest->load(['requester', 'approver']);
        
        $view = Auth::user()->isAdmin() ? 'pages.admin.requests.show' : 'pages.staf.requests.show';
        return view($view, compact('stockRequest'));
    }

    public function create()
    {
        return view('pages.staf.requests.create');
    }

    public function store(StockRequestRequest $request)
    {
        StockRequest::create([
            'requested_by' => Auth::id(),
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'request_date' => $request->request_date,
            'notes' => $request->notes,
            'status' => 'diajukan',
        ]);

        return redirect()->route('staf.requests.index')->with('success', 'Permintaan stok berhasil diajukan.');
    }

    public function approve(Request $request, StockRequest $stockRequest)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $stockRequest->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes ?? $stockRequest->notes,
        ]);

        ActivityLogger::log('Persetujuan Stok', "Menyetujui permintaan stok: {$stockRequest->item_name}");

        return back()->with('success', 'Permintaan stok disetujui.');
    }

    public function reject(Request $request, StockRequest $stockRequest)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $stockRequest->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes ?? $stockRequest->notes,
        ]);

        ActivityLogger::log('Penolakan Stok', "Menolak permintaan stok: {$stockRequest->item_name}");

        return back()->with('success', 'Permintaan stok ditolak.');
    }
}
