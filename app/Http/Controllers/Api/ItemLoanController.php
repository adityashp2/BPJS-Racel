<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemLoanController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemLoan::with(['item', 'user']);

        if ($request->user()->role !== 'admin') {
            $query->where('user_id', $request->user()->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
            'loan_date' => ['required', 'date'],
            'return_date' => ['required', 'date', 'after_or_equal:loan_date'],
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

        $loan = DB::transaction(function () use ($request, $item) {
            $item->decrement('stock', $request->quantity);

            return ItemLoan::create([
                'item_id' => $item->id,
                'user_id' => $request->user()->id,
                'quantity' => $request->quantity,
                'loan_date' => $request->loan_date,
                'return_date' => $request->return_date,
                'status' => 'dipinjam',
            ]);
        });

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat.',
            'data' => $loan->load(['item', 'user']),
        ], 201);
    }

    public function show(Request $request, ItemLoan $itemLoan)
    {
        if ($request->user()->role !== 'admin' && $itemLoan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Tidak diizinkan.'], 403);
        }

        return response()->json(['data' => $itemLoan->load(['item', 'user'])]);
    }

    public function returnItem(Request $request, ItemLoan $itemLoan)
    {
        if ($request->user()->role !== 'admin' && $itemLoan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Tidak diizinkan.'], 403);
        }

        if ($itemLoan->status === 'dikembalikan') {
            return response()->json(['message' => 'Barang ini sudah dikembalikan.'], 422);
        }

        DB::transaction(function () use ($itemLoan) {
            $itemLoan->item()->increment('stock', $itemLoan->quantity);
            $itemLoan->update(['status' => 'dikembalikan']);
        });

        return response()->json([
            'message' => 'Barang berhasil dikembalikan.',
            'data' => $itemLoan->load(['item', 'user']),
        ]);
    }

    public function destroy(ItemLoan $itemLoan)
    {
        DB::transaction(function () use ($itemLoan) {
            if ($itemLoan->status !== 'dikembalikan') {
                $itemLoan->item()->increment('stock', $itemLoan->quantity);
            }
            $itemLoan->delete();
        });

        return response()->json(['message' => 'Data peminjaman dihapus.']);
    }
}
