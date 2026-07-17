<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemPickupRequest;
use App\Http\Requests\UpdateItemPickupRequest;
use App\Models\Item;
use App\Models\ItemPickup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ItemPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemPickups = ItemPickup::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->whereHas('item', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
            });

        if (Auth::user()->role == 'admin') {
            $itemPickups = $itemPickups->paginate(10);
        } else {
            $division = Auth::user()->jobDivision;
            $itemPickups = $itemPickups->whereHas('user', function ($query) use ($division) {
                $query->where('job_division_id', $division->id);
            })->paginate(10);
        }

        return view('apps.item-pickups.index', compact('itemPickups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $users = User::all();
        return view('apps.item-pickups.create', compact('items', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemPickupRequest $request)
    {
        $validated = $request->validated();

        // if user id is null, set it to the current user
        if (!$request->user_id) {
            $request->merge(['user_id' => Auth::user()->id]);
        }

        try {
            // Start a transaction
            DB::beginTransaction();

            // Validate stock for all items first
            foreach ($validated['items'] as $item) {
                $itemModel = Item::findOrFail($item['item_id']);
                if ($itemModel->stock < $item['quantity']) {
                    return redirect()->back()->with([
                        'error' => "Stok tidak cukup untuk barang {$itemModel->name}. Stok tersedia: {$itemModel->stock}"
                    ]);
                }
            }

            // Create item pickups and update stocks
            foreach ($validated['items'] as $item) {
                // Create the item pickup
                $itemPickup = ItemPickup::create([
                    'user_id' => $request->user_id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'taken_date' => $validated['taken_date']
                ]);

                // Update the item stock
                $itemModel = Item::findOrFail($item['item_id']);
                $itemModel->stock -= $item['quantity'];
                $itemModel->saveOrFail();
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('item-pickups.index')->with(['success' => 'Pengambilan barang berhasil disimpan']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            // Rollback the transaction
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Gagal menyimpan pengambilan barang']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemPickup $itemPickup)
    {
        $itemPickup = ItemPickup::findOrFail($itemPickup->id);

        return view('apps.item-pickups.show', compact('itemPickup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemPickup $itemPickup)
    {
        $itemPickup = ItemPickup::findOrFail($itemPickup->id);
        $items = Item::all();
        $users = User::all();
        return view('apps.item-pickups.edit', compact('itemPickup', 'items', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemPickupRequest $request, ItemPickup $itemPickup)
    {
        $validated = $request->validated();

        // ensure the item stock is enough
        $item = Item::findOrFail($validated['item_id']);
        if ($item->stock < ($itemPickup->quantity - $validated['quantity'])) {
            return redirect()->route('item-pickups.edit', $itemPickup->id)->with(['error' => 'Item stock is not enough']);
        }

        // if user id is null, set it to the current user
        if (!$request->user_id) {
            $request->merge(['user_id' => Auth::user()->id]);
        }

        try {
            // Start a transaction
            DB::beginTransaction();

            // Calculate the stock difference: negative if quantity increased, positive if decreased
            $stockDifference = $itemPickup->quantity - $validated['quantity'];

            // Update the item pickup
            $itemPickup->update($request->all());

            // Update the item stock
            $item = Item::findOrFail($validated['item_id']);

            // Add the difference to current stock
            $item->stock += $stockDifference;
            $item->saveOrFail();

            // Commit the transaction
            DB::commit();

            return redirect()->route('item-pickups.index')->with(['success' => 'Item pickup updated successfully']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            // Rollback the transaction
            DB::rollBack();

            return redirect()->route('item-pickups.edit', $itemPickup->id)->with(['error' => 'Failed to update item pickup']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPickup $itemPickup)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            // Update the item stock
            $item = Item::findOrFail($itemPickup->item_id);
            $item->stock += $itemPickup->quantity;
            $item->saveOrFail();

            // Delete the item pickup
            $itemPickup->delete();

            // Commit the transaction
            DB::commit();

            return redirect()->route('item-pickups.index')->with(['success' => 'Item pickup deleted successfully']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            // Rollback the transaction
            DB::rollBack();

            return redirect()->route('item-pickups.index')->with(['error' => 'Failed to delete item pickup']);
        }
    }

    /**
     * Display a report of item pickups with filtering options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        // Get filter parameters
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $itemId = $request->input('item_id');
        $userId = $request->input('user_id');

        // Build query with filters
        $query = ItemPickup::with(['item', 'user', 'user.jobDivision'])
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('taken_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('taken_date', '<=', $endDate);
            })
            ->when($itemId, function ($query) use ($itemId) {
                return $query->where('item_id', $itemId);
            })
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            });

        // Get the paginated results
        $itemPickups = $query->orderBy('taken_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Calculate report statistics
        $totalPickups = $query->count();
        $totalQuantity = $query->sum('quantity');
        $uniqueUsers = $query->distinct('user_id')->count('user_id');
        $uniqueItems = $query->distinct('item_id')->count('item_id');

        // Get top items for chart
        $topItems = ItemPickup::select('items.name', DB::raw('SUM(item_pickups.quantity) as total_quantity'))
            ->join('items', 'items.id', '=', 'item_pickups.item_id')
            ->whereDate('taken_date', '>=', $startDate)
            ->whereDate('taken_date', '<=', $endDate)
            ->when($itemId, function ($query) use ($itemId) {
                return $query->where('item_id', $itemId);
            })
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->groupBy('items.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        $topItemsLabels = $topItems->pluck('name')->toArray();
        $topItemsData = $topItems->pluck('total_quantity')->toArray();

        // Get daily trend data
        $dailyTrend = ItemPickup::selectRaw('DATE(taken_date) as date, COUNT(*) as count')
            ->whereDate('taken_date', '>=', $startDate)
            ->whereDate('taken_date', '<=', $endDate)
            ->when($itemId, function ($query) use ($itemId) {
                return $query->where('item_id', $itemId);
            })
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyTrendLabels = $dailyTrend->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();

        $dailyTrendData = $dailyTrend->pluck('count')->toArray();

        // Get all items and users for filter dropdowns
        $items = Item::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('apps.item-pickups.report', compact(
            'itemPickups',
            'items',
            'users',
            'totalPickups',
            'totalQuantity',
            'uniqueUsers',
            'uniqueItems',
            'topItemsLabels',
            'topItemsData',
            'dailyTrendLabels',
            'dailyTrendData'
        ));
    }
}
