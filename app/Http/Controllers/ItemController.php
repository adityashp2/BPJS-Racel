<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Item::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

        return view('apps.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apps.items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        try {
            $item = Item::create($request->all());

            if ($request->hasFile('image')) {
                $path = Storage::disk('public')->put(Item::IMAGE_PATH, $request->file('image'));
                $item->image = $path;
                $item->saveOrFail();
            }

            return redirect()->route('items.index')->with('success', 'Item created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('items.create')->with('error', 'Failed to create item');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        // Ambil semua peminjaman aktif (status 'loaned') untuk item ini
        $currentLoans = \App\Models\ItemLoan::with(['user.jobDivision'])
            ->where('item_id', $item->id)
            ->where('status', 'loaned')
            ->get();

        return view('apps.items.show', compact('item', 'currentLoans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('apps.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        try {
            $item->fill($request->all());
            $item->saveOrFail();

            if ($request->hasFile('image')) {
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }

                $path = Storage::disk('public')->put(Item::IMAGE_PATH, $request->file('image'));
                $item->image = $path;
                $item->saveOrFail();
            }

            return redirect()->route('items.index')->with('success', 'Item updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('items.edit', $item)->with('error', 'Failed to update item');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        try {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $item->delete();

            return redirect()->route('items.index')->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('items.index')->with('error', 'Failed to delete item');
        }
    }

    /**
     * Display a listing of the item gallery.
     */
    public function itemGallery(Request $request)
    {
        $items = Item::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->paginate(9);

        return view('apps.items.item-gallery', compact('items'));
    }
}
