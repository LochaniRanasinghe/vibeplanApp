<?php

namespace App\Http\Controllers\InventoryStaff;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventoryStaffDashboardController extends Controller
{

    public function index()
    {
        $user = Auth()->user();

        $itemsSold = InventoryItem::where('inventory_staff_id', $user->id)
            ->withCount(['inventoryOrders as total_sold' => function ($q) {
                $q->select(DB::raw("SUM(quantity)"))->where('status', 'approved');
            }])
            ->get()
            ->map(function ($item) {
                $revenue = $item->total_sold * $item->price_per_unit;
                return [
                    'item_name' => $item->item_name,
                    'quantity' => $item->total_sold ?? 0,
                    'available' => $item->quantity_available,
                    'revenue' => $revenue,
                ];
            });

        $monthlyRevenue = EventInventoryOrder::with('inventoryItem')
            ->whereHas('inventoryItem', function ($q) use ($user) {
                $q->where('inventory_staff_id', $user->id);
            })
            ->where('status', 'approved')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m');
            })
            ->map(function ($orders) {
                return $orders->sum(function ($order) {
                    return optional($order->inventoryItem)->price_per_unit * $order->quantity;
                });
            });

        return view('inventory-staff.dashboard', compact('itemsSold', 'monthlyRevenue'));
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
