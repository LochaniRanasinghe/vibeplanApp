<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;

use App\Models\Payment;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\DB;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Sales data: how much quantity sold per item
        $salesPerItem = InventoryItem::withTrashed()
            ->withCount(['inventoryOrders as total_sold' => function ($query) {
                $query->select(DB::raw("SUM(quantity)"))->where('status', 'approved');
            }])->get();

        // Most and least requested event types
        $eventRequests = EventType::withCount('eventRequests')
            ->orderByDesc('event_requests_count')
            ->get();

        $monthlyItemRevenue = EventInventoryOrder::with(['inventoryItem'])
            ->where('status', 'approved')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m'); // e.g., "2025-06"
            })
            ->map(function ($ordersByMonth) {
                return $ordersByMonth->groupBy('inventory_item_id')->map(function ($orders) {
                    $itemName = optional($orders->first()->inventoryItem)->item_name ?? 'Unknown Item';
                    $totalRevenue = $orders->sum(function ($order) {
                        return optional($order->inventoryItem)->price_per_unit * $order->quantity;
                    });
                    return [
                        'item' => $itemName,
                        'revenue' => $totalRevenue,
                    ];
                })->values(); // return array of [item, revenue] pairs
            });

        // Sales over time (grouped by date)
        $salesOverTime = EventInventoryOrder::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(quantity) as total_quantity')
        )
        ->where('status', 'approved')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

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
            'customEvent.request.eventType'
        ])
        ->where('payment_status', 'paid') // Or 'paid', depending on your app
        ->get()
        ->groupBy(function ($payment) {
            return optional(optional(optional($payment->customEvent)->request)->eventType)->name ?? 'Unknown Type';
        })
        ->map(function ($payments) {
            $totalPaid = $payments->sum('amount');
            return [
                'revenue' => $totalPaid,
                'events' => $payments->pluck('customEvent.request.title')->filter()->unique()->values()
            ];
        }); 


        return view('admin.dashboard', compact('salesPerItem', 'eventRevenue', 'eventRequests', 'monthlyItemRevenue', 'salesOverTime', 'salesByEvent'));
    }
}
