<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequestRequest;
use App\Http\Requests\UpdateItemRequestRequest;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ItemRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemRequests = ItemRequest::with('requestedBy.jobDivision')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->when(Auth::user()->role == 'user', function ($query) {
                $query->where('requested_by', Auth::user()->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('apps.item-requests.index', compact('itemRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apps.item-requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequestRequest $request)
    {
        try {
            $validated = $request->validated();

            $itemRequest = ItemRequest::make($validated);

            $itemRequest->requested_by = Auth::user()->id;

            $itemRequest->save();

            return redirect()->route('item-requests.index')->with('success', 'Pengajuan barang berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error creating item request: ' . $e->getMessage());

            return redirect()->route('item-requests.create')->with('error', 'Pengajuan barang gagal dibuat');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemRequest $itemRequest)
    {
        $itemRequest->load('requestedBy.jobDivision');

        return view('apps.item-requests.show', compact('itemRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemRequest $itemRequest)
    {
        $itemRequest->load('requestedBy');

        return view('apps.item-requests.edit', compact('itemRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequestRequest $request, ItemRequest $itemRequest)
    {
        try {
            $validated = $request->validated();

            $itemRequest->fill($validated);

            $itemRequest->saveOrFail();

            return redirect()->route('item-requests.index')->with('success', 'Pengajuan barang berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error updating item request: ' . $e->getMessage());

            return redirect()->route('item-requests.edit', $itemRequest)->with('error', 'Pengajuan barang gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemRequest $itemRequest)
    {
        try {
            $itemRequest->delete();

            return redirect()->route('item-requests.index')->with('success', 'Pengajuan barang berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting item request: ' . $e->getMessage());

            return redirect()->route('item-requests.index')->with('error', 'Pengajuan barang gagal dihapus');
        }
    }
}
