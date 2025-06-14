<?php

namespace App\Http\Controllers\InventoryStaff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class InventoryStaffDashboardController extends Controller
{
    public function index()
    {
        return view('inventory-staff.dashboard');
    }

    public function index()
    {
        $staffId = Auth::id();

        // Items listed by this staff
        $items = InventoryItem::where('inventory_staff_id', $staffId)
            ->withCount(['inventoryOrders as total_sold' => function ($query) {
                $query->where('status', 'approved')->select(\DB::raw('SUM(quantity)'));
            }])
            ->with(['inventoryOrders.customEvent.request'])
            ->get();

        // Revenue per item
        $itemRevenue = $items->map(function ($item) {
            return [
                'item_name' => $item->item_name,
                'revenue' => $item->total_sold * $item->price_per_unit,
                'quantity_available' => $item->quantity_available,
            ];
        });

        // Monthly revenue
        $monthlyRevenue = EventInventoryOrder::with('inventoryItem')
            ->whereHas('inventoryItem', function ($q) use ($staffId) {
                $q->where('inventory_staff_id', $staffId);
            })
            ->where('status', 'approved')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m');
            })
            ->map(function ($orders) {
                return $orders->sum(function ($order) {
                    return $order->quantity * optional($order->inventoryItem)->price_per_unit;
                });
            });

        // Events where items are ordered most
        $ordersByEvent = EventInventoryOrder::with(['customEvent.request', 'inventoryItem'])
            ->whereHas('inventoryItem', function ($q) use ($staffId) {
                $q->where('inventory_staff_id', $staffId);
            })
            ->get()
            ->groupBy('custom_event_id')
            ->map(function ($orders, $eventId) {
                $eventTitle = optional($orders->first()->customEvent->request)->title ?? 'Unknown';
                return [
                    'event' => $eventTitle,
                    'items' => $orders->map(function ($order) {
                        return $order->inventoryItem->item_name . ' x' . $order->quantity;
                    })->toArray(),
                ];
            });

        return view('inventory-staff.dashboard', compact(
            'items',
            'itemRevenue',
            'monthlyRevenue',
            'ordersByEvent'
        ));
    }

    public function downloadReport(Request $request)
    {
        $chart1 = $request->input('chart1');
        $chart2 = $request->input('chart2');

        $data = [
            'chart1' => $chart1,
            'chart2' => $chart2,
        ];

        $pdf = Pdf::loadView('inventory-staff.reports.dashboard_pdf', $data);
        return $pdf->download('inventory_report.pdf');
    }
}
