<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemLoanRequest;
use App\Http\Requests\UpdateItemLoanRequest;
use App\Models\Item;
use App\Models\ItemLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ItemLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemLoans = ItemLoan::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->whereHas('item', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('created_at', 'desc');

        if (Auth::user()->role == 'admin') {
            $itemLoans = $itemLoans->paginate(10);
        } else {
            $division = Auth::user()->jobDivision;
            $itemLoans = $itemLoans->whereHas('user', function ($query) use ($division) {
                $query->where('job_division_id', $division->id);
            })->paginate(10);
        }

        return view('apps.item-loans.index', compact('itemLoans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $users = User::all();
        
        return view('apps.item-loans.create', compact('items', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemLoanRequest $request)
    {
        try {     
            // if user id is null, set it to the current user
            if (!$request->user_id) {
                $request->merge(['user_id' => Auth::user()->id]);
            }

            // if status is null, set it to 'loaned'
            if (!$request->status) {
                $request->merge(['status' => 'loaned']);
            }

            $itemLoan = ItemLoan::create($request->all());

            // Ensure if stock is enough
            $item = Item::find($request->item_id);
            if ($item->stock < $request->quantity) {
                return redirect()->route('item-loans.create')->with('error', 'Stock not enough');
            }
            
            // Update the item quantity
            $item = Item::find($request->item_id);
            $item->stock -= $request->quantity;
            $item->save();

            if (Auth::user()->role == 'admin') {
                return redirect()->route('item-loans.index')->with('success', 'Item loan created successfully');
            } else {
                return redirect()->route('item-pickups.index')->with('success', 'Item loan created successfully');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            return redirect()->route('item-loans.create')->with('error', 'Failed to create item loan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemLoan $itemLoan)
    {
        return view('apps.item-loans.show', compact('itemLoan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemLoan $itemLoan)
    {
        $items = Item::all();
        $users = User::all();

        return view('apps.item-loans.edit', compact('itemLoan', 'items', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemLoanRequest $request, ItemLoan $itemLoan)
    {
        try {
            // Ensure if stock is enough
            $item = Item::find($request->item_id);
            if ($item->stock - ($request->quantity - $itemLoan->quantity) < 0) {
                return redirect()->route('item-loans.edit', $itemLoan)->with('error', 'Stock not enough');
            }

            // Check if quantity is changed
            if ($request->quantity != $itemLoan->quantity) {
                if ($request->quantity > $itemLoan->quantity) {
                    $item->stock -= ($request->quantity - $itemLoan->quantity);
                } else {
                    $item->stock += ($itemLoan->quantity - $request->quantity);
                }
                $item->save();
            }

            $itemLoan->update($request->all());

            // Update the item quantity
            if ($request->status == 'returned') {
                $item = Item::find($request->item_id);
                $item->stock += $request->quantity;
                $item->save();
            }

            return redirect()->route('item-loans.index')->with('success', 'Item loan updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('item-loans.edit', $itemLoan)->with('error', 'Failed to update item loan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemLoan $itemLoan)
    {
        try {
            $itemLoan->delete();

            // Update the item quantity
            $item = Item::find($itemLoan->item_id);
            $item->stock += $itemLoan->quantity;
            $item->save();

            return redirect()->route('item-loans.index')->with('success', 'Item loan deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('item-loans.index')->with('error', 'Failed to delete item loan');
        }
    }
}
