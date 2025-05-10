<?php

namespace App\Http\Controllers\Admin;
use Throwable;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventory-items.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staffList = User::where('role', 'inventory_staff')->get();
        return view('admin.inventory-items.create', compact('staffList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity_available' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'inventory_staff_id' => 'required|exists:users,id',
        ]);

        InventoryItem::create($validated);

        flash()->success('Inventory item created successfully.');
        return redirect()->route('admin.inventory-items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        return view('admin.inventory-items.show', compact('inventoryItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity_available' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $inventoryItem->update($validated);

        flash()->success('Inventory item updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        //
    }

    public function getInventoryItems(Request $request)
    {
        try {
            $query = InventoryItem::with('staff')
                ->orderBy('created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('item_name', fn($item) => $item->item_name)
                ->addColumn('description', fn($item) => $item->description)
                ->addColumn('quantity_available', fn($item) => $item->quantity_available)
                ->addColumn('price_per_unit', fn($item) => $item->price_per_unit)
                ->addColumn('added_by', fn($item) => $item->staff?->name ?? 'N/A')
                ->addColumn('created_at', function ($item) {
                    return $item->created_at
                        ? Carbon::parse($item->created_at)->format('Y-m-d')
                        : 'N/A';
                })
                ->addColumn('actions', function ($item) {
                    return view('admin.inventory-items.components.actions', compact('item'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
