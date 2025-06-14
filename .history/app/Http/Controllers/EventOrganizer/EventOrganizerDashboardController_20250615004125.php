<?php

namespace App\Http\Controllers\EventOrganizer;
use Illuminate\Http\Request;

use App\Models\EventInventoryOrder;
use App\Http\Controllers\Controller;

class EventOrganizerDashboardController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();

        // 1. Income per event
        $incomePerEvent = Payment::with('customEvent.request')
            ->whereHas('customEvent', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->where('payment_status', 'paid')
            ->get()
            ->groupBy(function ($payment) {
                return optional(optional($payment->customEvent)->request)->title ?? 'Unknown Event';
            })
            ->map(function ($payments) {
                return $payments->sum('amount');
            });

        // 2. Monthly income
        $monthlyIncome = Payment::whereHas('customEvent', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->where('payment_status', 'paid')
            ->get()
            ->groupBy(function ($payment) {
                return Carbon::parse($payment->paid_at)->format('Y-m');
            })
            ->map(function ($payments) {
                return $payments->sum('amount');
            });

        // 3. Most ordered items
        $mostOrderedItems = EventInventoryOrder::with('inventoryItem')
            ->whereHas('customEvent', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->where('status', 'approved')
            ->get()
            ->groupBy('inventory_item_id')
            ->map(function ($orders) {
                $item = optional($orders->first()->inventoryItem);
                return [
                    'item_name' => $item ? $item->item_name : 'Unknown',
                    'quantity' => $orders->sum('quantity'),
                ];
            })
            ->values();

        return view('event-organizer.dashboard', compact('incomePerEvent', 'monthlyIncome', 'mostOrderedItems'));
    }
}
