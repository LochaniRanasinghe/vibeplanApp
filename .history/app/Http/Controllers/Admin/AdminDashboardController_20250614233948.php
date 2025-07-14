<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;

use App\Models\Payment;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Sales data: how much quantity sold per item
        $salesPerItem = InventoryItem::withTrashed()
            ->with('staff') // include user who added it
            ->withCount(['inventoryOrders as total_sold' => function ($query) {
                $query->select(DB::raw("SUM(quantity)"))->where('status', 'approved');
            }])->get();
        

        // Most and least requested event types
        $eventRequests = EventType::withCount('eventRequests')
            ->orderByDesc('event_requests_count')
            ->get();

        $monthlyItemRevenue = EventInventoryOrder::with(['inventoryItem.staff'])
            ->where('status', 'approved')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m'); // e.g., "2025-06"
            })
            ->map(function ($ordersByMonth) {
                return $ordersByMonth->groupBy('inventory_item_id')->map(function ($orders) {
                    $item = $orders->first()->inventoryItem;
                    $itemName = $item ? $item->item_name . ' (' . ($item->staff->name ?? 'Unknown') . ')' : 'Unknown Item';
                    $totalRevenue = $orders->sum(function ($order) use ($item) {
                        return optional($item)->price_per_unit * $order->quantity;
                    });
                    return [
                        'item' => $itemName,
                        'revenue' => $totalRevenue,
                    ];
                })->values();
            });
        

        $salesByEvent = EventInventoryOrder::with('customEvent.request')
        ->select('custom_event_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('custom_event_id')
        ->get()
        ->map(function ($order) {
            $eventTitle = optional($order->customEvent->request)->title ?? 'Unknown Event';
            return [
                'event' => $eventTitle,
                'quantity' => $order->total_quantity,
            ];
        });

        $eventRevenue = Payment::with([
            'customEvent.request.eventType.addedBy'
        ])
            ->where('payment_status', 'paid')
            ->get()
            ->groupBy(function ($payment) {
                $eventType = optional(optional(optional($payment->customEvent)->request)->eventType);
                $typeName = $eventType->name ?? 'Unknown Type';
                $creator = $eventType->addedBy->name ?? 'Unknown';
                return $typeName . ' (' . $creator . ')';
            })
            ->map(function ($payments) {
                $totalPaid = $payments->sum('amount');
                return [
                    'revenue' => $totalPaid,
                    'events' => $payments->pluck('customEvent.request.title')->filter()->unique()->values()
                ];
            });    


        return view('admin.dashboard', compact('salesPerItem', 'eventRevenue', 'eventRequests', 'monthlyItemRevenue', 'salesByEvent'));
    }

    public function generateReport(Request $request)
{
    $charts = [
        'salesChart' => $request->input('salesChart'),
        'salesByEventChart' => $request->input('salesByEventChart'),
        'monthlyRevenueChart' => $request->input('monthlyRevenueChart'),
        'eventTypeRevenueChart' => $request->input('eventTypeRevenueChart'),
    ];

    // Re-fetch the exact same data as in your dashboard
    $salesPerItem = InventoryItem::withTrashed()
        ->with('staff')
        ->withCount(['inventoryOrders as total_sold' => function ($query) {
            $query->select(DB::raw("SUM(quantity)"))->where('status', 'approved');
        }])->get();

    $salesByEvent = EventInventoryOrder::with('customEvent.request')
        ->select('custom_event_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('custom_event_id')
        ->get()
        ->map(function ($order) {
            $eventTitle = optional($order->customEvent->request)->title ?? 'Unknown Event';
            return [
                'event' => $eventTitle,
                'quantity' => $order->total_quantity,
            ];
        });

    $monthlyItemRevenue = EventInventoryOrder::with(['inventoryItem.staff'])
        ->where('status', 'approved')
        ->get()
        ->groupBy(function ($order) {
            return \Carbon\Carbon::parse($order->created_at)->format('Y-m');
        })
        ->map(function ($ordersByMonth) {
            return $ordersByMonth->groupBy('inventory_item_id')->map(function ($orders) {
                $item = $orders->first()->inventoryItem;
                $itemName = $item ? $item->item_name . ' (' . ($item->staff->name ?? 'Unknown') . ')' : 'Unknown Item';
                $totalRevenue = $orders->sum(function ($order) use ($item) {
                    return optional($item)->price_per_unit * $order->quantity;
                });
                return [
                    'item' => $itemName,
                    'revenue' => $totalRevenue,
                ];
            })->values();
        });

    $eventRevenue = Payment::with(['customEvent.request.eventType.addedBy'])
        ->where('payment_status', 'paid')
        ->get()
        ->groupBy(function ($payment) {
            $eventType = optional(optional(optional($payment->customEvent)->request)->eventType);
            $typeName = $eventType->name ?? 'Unknown Type';
            $creator = $eventType->addedBy->name ?? 'Unknown';
            return $typeName . ' (' . $creator . ')';
        })
        ->map(function ($payments) {
            return [
                'revenue' => $payments->sum('amount'),
                'events' => $payments->pluck('customEvent.request.title')->filter()->unique()->values()
            ];
        });

    // Now pass data directly
    $tableData = compact('salesPerItem', 'salesByEvent', 'monthlyItemRevenue', 'eventRevenue');

    $pdf = Pdf::loadView('admin.reports.dashboard_pdf', compact('charts', 'tableData'));

    return $pdf->download('dashboard_report.pdf');
}




}
