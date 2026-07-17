<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemPickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemPickupController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemPickup::with(['item', 'user']);

        if ($request->user()->role !== 'admin') {
            $query->where('user_id', $request->user()->id);
        }

        return response()->json([
            'data' => $query->latest()->paginate($request->integer('per_page', 15)),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'taken_date' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $item = Item::findOrFail($request->item_id);

        if ($item->stock < $request->quantity) {
            return response()->json([
                'message' => "Stok tidak mencukupi. Sisa stok: {$item->stock}.",
            ], 422);
        }

        $pickup = DB::transaction(function () use ($request, $item) {
            $item->decrement('stock', $request->quantity);

            return ItemPickup::create([
                'item_id' => $item->id,
                'user_id' => $request->user()->id,
                'quantity' => $request->quantity,
                'taken_date' => $request->taken_date,
            ]);
        });

        return response()->json([
            'message' => 'Barang berhasil diambil.',
            'data' => $pickup->load(['item', 'user']),
        ], 201);
    }

    public function show(Request $request, ItemPickup $itemPickup)
    {
        if ($request->user()->role !== 'admin' && $itemPickup->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Tidak diizinkan.'], 403);
        }

        return response()->json(['data' => $itemPickup->load(['item', 'user'])]);
    }

    public function destroy(ItemPickup $itemPickup)
    {
        DB::transaction(function () use ($itemPickup) {
            $itemPickup->item()->increment('stock', $itemPickup->quantity);
            $itemPickup->delete();
        });

        return response()->json(['message' => 'Data pengambilan barang dihapus dan stok dikembalikan.']);
    }
}
