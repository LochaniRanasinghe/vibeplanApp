<?php

namespace App\Http\Controllers\Admin;
use App\Models\EventType;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
{
    // Sales data: how much quantity sold per item
    $salesPerItem = InventoryItem::withTrashed()
        ->withCount(['inventoryOrders as total_sold' => function ($query) {
            $query->select(DB::raw("SUM(quantity)"))->where('status', 'completed');
        }])->get();

    // Most and least requested event types
    $eventRequests = EventType::withCount('eventRequests')
        ->orderByDesc('event_requests_count')
        ->get();

    // Sales over time (grouped by date)
    $salesOverTime = EventInventoryOrder::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(quantity) as total_quantity')
    )
    ->where('status', 'completed')
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    return view('admin.dashboard', compact('salesPerItem', 'eventRequests', 'salesOverTime'));
}
}
