<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemRequest::with('requestedBy');

        if ($request->user()->role !== 'admin') {
            $query->where('requested_by', $request->user()->id);
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'request_date' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $itemRequest = ItemRequest::create([
            'requested_by' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'pending',
            'request_date' => $request->request_date,
        ]);

        return response()->json([
            'message' => 'Permintaan barang berhasil diajukan.',
            'data' => $itemRequest->load('requestedBy'),
        ], 201);
    }

    public function show(Request $request, ItemRequest $itemRequest)
    {
        if ($request->user()->role !== 'admin' && $itemRequest->requested_by !== $request->user()->id) {
            return response()->json(['message' => 'Tidak diizinkan.'], 403);
        }

        return response()->json(['data' => $itemRequest->load('requestedBy')]);
    }

    public function approve(ItemRequest $itemRequest)
    {
        $itemRequest->update(['status' => 'approved']);

        return response()->json([
            'message' => 'Permintaan barang disetujui.',
            'data' => $itemRequest,
        ]);
    }

    public function reject(ItemRequest $itemRequest)
    {
        $itemRequest->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Permintaan barang ditolak.',
            'data' => $itemRequest,
        ]);
    }

    public function destroy(Request $request, ItemRequest $itemRequest)
    {
        if ($request->user()->role !== 'admin' && $itemRequest->requested_by !== $request->user()->id) {
            return response()->json(['message' => 'Tidak diizinkan.'], 403);
        }

        $itemRequest->delete();

        return response()->json(['message' => 'Permintaan barang dihapus.']);
    }
}
