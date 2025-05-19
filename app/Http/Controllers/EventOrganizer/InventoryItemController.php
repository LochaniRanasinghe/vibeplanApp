<?php

namespace App\Http\Controllers\EventOrganizer;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\CustomEvent;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = InventoryItem::with('staff')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('event-organizer.inventory-items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staffList = User::where('role', 'inventory_staff')->get();
        return view('event-organizer.inventory-items.create', compact('staffList'));
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
        return redirect()->route('event-organizer.inventory-items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        return view('event-organizer.inventory-items.show', compact('inventoryItem'));
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

    public function orderItem($id)
    {
        $item = InventoryItem::findOrFail($id);
       
        $customEvents = CustomEvent::with('request')
            ->where('organizer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

            $orderedQty = EventInventoryOrder::where('inventory_item_id', $item->id)
                ->whereIn('status', ['pending', 'approved']) 
                ->sum('quantity');

            $availableQty = max($item->quantity_available - $orderedQty, 0); 

        return view('event-organizer.inventory-items.components.order-item', compact('item', 'customEvents','availableQty','orderedQty'));
    }

    public function placeOrder(Request $request, $itemId)
    {
        $request->validate([
            'custom_event_id' => 'required|exists:custom_events,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = InventoryItem::findOrFail($itemId);

        if ($request->quantity > $item->quantity_available) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        EventInventoryOrder::create([
            'custom_event_id' => $request->custom_event_id,
            'inventory_item_id' => $item->id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('event_organizer.inventory-orders.index')
            ->with('success', 'Inventory item successfully ordered.');
    }

    
}
