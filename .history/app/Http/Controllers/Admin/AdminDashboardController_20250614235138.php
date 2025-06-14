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
        

            $salesByEvent = EventInventoryOrder::with(['customEvent.request', 'inventoryItem'])
            ->where('status', 'approved')
            ->get()
            ->groupBy('custom_event_id')
            ->map(function ($orders) {
                $eventTitle = optional($orders->first()->customEvent->request)->title ?? 'Unknown Event';
                $quantity = $orders->sum('quantity');
                $items = $orders->pluck('inventoryItem.item_name')->filter()->unique()->values();
        
                return [
                    'event' => $eventTitle,
                    'quantity' => $quantity,
                    'items' => $items,
                ];
            })
            ->values(); // reset keys
        
        
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

    // public function generateReport(Request $request)
    // {
    //     $charts = [
    //         'salesChart' => $request->input('salesChart'),
    //         'salesByEventChart' => $request->input('salesByEventChart'),
    //         'monthlyRevenueChart' => $request->input('monthlyRevenueChart'),
    //         'eventTypeRevenueChart' => $request->input('eventTypeRevenueChart'),
    //     ];

    //     // Parse and decode raw data JSON inputs
    //     $tableData = [
    //         'salesPerItem' => json_decode($request->input('salesPerItem'), true) ?? [],
    //         'salesByEvent' => json_decode($request->input('salesByEvent'), true) ?? [],
    //         'monthlyItemRevenue' => json_decode($request->input('monthlyItemRevenue'), true) ?? [],
    //         'eventRevenue' => json_decode($request->input('eventRevenue'), true) ?? [],
    //     ];

    //     $pdf = Pdf::loadView('admin.reports.dashboard_pdf', compact('charts', 'tableData'));

    //     return $pdf->download('dashboard_report.pdf');
    // }

    public function generateReport(Request $request)
    {
        $charts = [
            'salesChart' => $request->input('salesChart'),
            'salesByEventChart' => $request->input('salesByEventChart'),
            'monthlyRevenueChart' => $request->input('monthlyRevenueChart'),
            'eventTypeRevenueChart' => $request->input('eventTypeRevenueChart'),
        ];

        // Fresh data queries (same as in your dashboard)
        $salesPerItem = InventoryItem::withTrashed()
            ->with('staff')
            ->withCount(['inventoryOrders as total_sold' => function ($query) {
                $query->select(DB::raw("SUM(quantity)"))->where('status', 'approved');
            }])->get()
            ->map(function ($item) {
                return [
                    'item_name' => $item->item_name,
                    'staff' => ['name' => $item->staff->name ?? 'Unknown'],
                    'total_sold' => $item->total_sold ?? 0,
                ];
            });

        $salesByEvent = EventInventoryOrder::with('customEvent.request')
            ->select('custom_event_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('custom_event_id')
            ->get()
            ->map(function ($order) {
                return [
                    'event' => optional($order->customEvent->request)->title ?? 'Unknown Event',
                    'quantity' => $order->total_quantity,
                ];
            });

        $monthlyItemRevenue = EventInventoryOrder::with(['inventoryItem.staff'])
            ->where('status', 'approved')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m');
            })
            ->map(function ($ordersByMonth) {
                return $ordersByMonth->groupBy('inventory_item_id')->map(function ($orders) {
                    $item = $orders->first()->inventoryItem;
                    $itemName = $item ? $item->item_name . ' (' . ($item->staff->name ?? 'Unknown') . ')' : 'Unknown Item';
                    $totalRevenue = $orders->sum(fn($order) => optional($item)->price_per_unit * $order->quantity);
                    return [
                        'item' => $itemName,
                        'revenue' => $totalRevenue,
                    ];
                })->values();
            });

        $eventRevenue = Payment::with('customEvent.request.eventType.addedBy')
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

        $tableData = [
            'salesPerItem' => $salesPerItem,
            'salesByEvent' => $salesByEvent,
            'monthlyItemRevenue' => $monthlyItemRevenue,
            'eventRevenue' => $eventRevenue,
        ];

        $pdf = Pdf::loadView('admin.reports.dashboard_pdf', compact('charts', 'tableData'));

        return $pdf->download('dashboard_report.pdf');
    }




}
