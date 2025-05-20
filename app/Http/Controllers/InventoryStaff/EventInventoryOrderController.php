<?php

namespace App\Http\Controllers\InventoryStaff;
use Throwable;

use App\Models\CustomEvent;
use Illuminate\Http\Request;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EventInventoryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inventory-staff.inventory-orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory-staff.inventory-orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EventInventoryOrder $inventoryOrder)
    {
        $inventoryOrder->load([
            'customEvent.organizer',
            'customEvent.request.eventType',
            'inventoryItem.staff'
        ]);
        return view('inventory-staff.inventory-orders.show', compact('inventoryOrder'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventInventoryOrder $eventInventoryOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventInventoryOrder $inventoryOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'quantity' => 'required|integer|min:1',
        ]);

        $inventoryOrder->update([
            'status' => $validated['status'],
            'quantity'=> $validated['quantity'],
        ]);

        flash()->success('Inventory order status updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventInventoryOrder $eventInventoryOrder)
    {
        //
    }


    public function getInventoryOrders(Request $request)
    {
        try {
            $query = EventInventoryOrder::with(['customEvent.organizer', 'customEvent.request', 'inventoryItem.staff'])
                ->whereHas('inventoryItem', function ($q) {
                    $q->where('inventory_staff_id', auth()->id());
                })
                ->select('event_inventory_orders.*')
                ->orderBy('event_inventory_orders.created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('item_name', fn($order) => $order->inventoryItem?->item_name ?? 'N/A')
                ->addColumn('ordered_by', fn($order) => $order->customEvent?->organizer?->name ?? 'N/A')
                ->addColumn('quantity', fn($order) => $order->quantity)
                ->addColumn('unit_price', fn($order) => 'LKR ' . number_format($order->inventoryItem?->price_per_unit ?? 0, 2))
                ->addColumn('total_price', function ($order) {
                    $unitPrice = $order->inventoryItem?->price_per_unit ?? 0;
                    return 'LKR ' . number_format($unitPrice * $order->quantity, 2);
                })
                ->addColumn('event_title', fn($order) => $order->customEvent?->request?->title ?? 'N/A')
                ->addColumn('status', function ($order) {
                    $status = strtolower($order->status);
                    $badgeClass = match ($status) {
                        'pending'  => 'badge bg-primary text-white',
                        'approved' => 'badge bg-success',
                        'rejected' => 'badge bg-danger',
                        default    => 'badge bg-secondary',
                    };
                    return "<span class='{$badgeClass}'>" . ucfirst($status) . "</span>";
                })
                ->addColumn('ordered_from', function ($order) {
                    return $order->inventoryItem?->staff?->name ?? 'N/A';
                })
                ->addColumn('actions', function ($order) {
                    return view('inventory-staff.inventory-orders.components.actions', compact('order'))->render();
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getOrdersByCustomEvent(Request $request, CustomEvent $customEvent)
    {
        try {
            $query = $customEvent->inventoryOrders()
                ->with(['inventoryItem.staff']) // eager load item + staff
                ->select('event_inventory_orders.*')
                ->orderBy('event_inventory_orders.created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('item_name', fn($order) => $order->inventoryItem?->item_name ?? 'N/A')
                ->addColumn('ordered_from', fn($order) => $order->inventoryItem?->staff?->name ?? 'N/A')
                ->addColumn('quantity', fn($order) => $order->quantity)
                ->addColumn('unit_price', fn($order) =>
                    'LKR ' . number_format($order->inventoryItem?->price_per_unit ?? 0, 2)
                )
                ->addColumn('total_price', fn($order) =>
                    'LKR ' . number_format(($order->inventoryItem?->price_per_unit ?? 0) * $order->quantity, 2)
                )
                ->addColumn('status', function ($order) {
                    $status = strtolower($order->status);
                    $badgeClass = match ($status) {
                        'pending' => 'badge bg-primary text-white',
                        'approved' => 'badge bg-success',
                        'rejected' => 'badge bg-danger',
                        default => 'badge bg-secondary',
                    };
                    return "<span class='{$badgeClass}'>" . ucfirst($status) . "</span>";
                })
                ->rawColumns(['status']) // allow HTML in these columns
                ->make(true);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
