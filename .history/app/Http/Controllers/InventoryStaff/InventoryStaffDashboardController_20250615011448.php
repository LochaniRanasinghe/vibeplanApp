<?php

namespace App\Http\Controllers\InventoryStaff;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventoryStaffDashboardController extends Controller
{

    public function index()
    {
        $staffId = Auth::id();

        $items = InventoryItem::with('inventoryOrders.customEvent')
            ->where('inventory_staff_id', $staffId)
            ->get();

        $itemsSummary = $items->map(function ($item) {
            $totalSold = $item->inventoryOrders->where('status', 'approved')->sum('quantity');
            $totalRevenue = $totalSold * $item->price_per_unit;

            $events = $item->inventoryOrders
                ->filter(fn($o) => $o->status === 'approved')
                ->map(fn($o) => optional(optional($o->customEvent)->request)->title)
                ->filter()
                ->unique()
                ->values();

            return [
                'item_name' => $item->item_name,
                'quantity_sold' => $totalSold,
                'revenue' => $totalRevenue,
                'quantity_available' => $item->quantity_available,
                'events' => $events
            ];
        });

        $monthlyRevenue = EventInventoryOrder::whereHas('inventoryItem', fn($q) => $q->where('inventory_staff_id', $staffId))
            ->where('status', 'approved')
            ->get()
            ->groupBy(fn($order) => Carbon::parse($order->created_at)->format('Y-m'))
            ->map(fn($orders) => $orders->sum(fn($o) => $o->quantity * optional($o->inventoryItem)->price_per_unit));

        return view('inventory-staff.dashboard', compact('itemsSummary', 'monthlyRevenue'));
    }

    public function downloadReport(Request $request)
    {
        $chart1 = $request->input('chart1');
        $chart2 = $request->input('chart2');

        $staffId = Auth::id();

        $items = InventoryItem::with('inventoryOrders.customEvent')
            ->where('inventory_staff_id', $staffId)
            ->get();

        $itemsSummary = $items->map(function ($item) {
            $totalSold = $item->inventoryOrders->where('status', 'approved')->sum('quantity');
            $totalRevenue = $totalSold * $item->price_per_unit;

            $events = $item->inventoryOrders
                ->filter(fn($o) => $o->status === 'approved')
                ->map(fn($o) => optional(optional($o->customEvent)->request)->title)
                ->filter()
                ->unique()
                ->values();

            return [
                'item_name' => $item->item_name,
                'quantity_sold' => $totalSold,
                'revenue' => $totalRevenue,
                'quantity_available' => $item->quantity_available,
                'events' => $events
            ];
        });

        $monthlyRevenue = EventInventoryOrder::whereHas('inventoryItem', fn($q) => $q->where('inventory_staff_id', $staffId))
            ->where('status', 'approved')
            ->get()
            ->groupBy(fn($order) => Carbon::parse($order->created_at)->format('Y-m'))
            ->map(fn($orders) => $orders->sum(fn($o) => $o->quantity * optional($o->inventoryItem)->price_per_unit));

        $pdf = Pdf::loadView('inventory-staff.reports.dashboard_pdf', compact('itemsSummary', 'monthlyRevenue', 'chart1', 'chart2'));
        return $pdf->download('inventory_staff_report.pdf');
    }
}
