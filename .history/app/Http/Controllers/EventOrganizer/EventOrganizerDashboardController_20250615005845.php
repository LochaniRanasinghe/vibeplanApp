<?php

namespace App\Http\Controllers\EventOrganizer;
use Carbon\Carbon;

use App\Models\Payment;
use App\Models\CustomEvent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $mostOrderedItems = EventInventoryOrder::with('inventoryItem.staff')
            ->whereHas('customEvent', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->where('status', 'approved')
            ->get()
            ->groupBy('inventory_item_id')
            ->map(function ($orders) {
                $item = optional($orders->first()->inventoryItem);
                $staff = optional($item->staff)->name ?? 'Unknown';
                $itemName = $item ? $item->item_name : 'Unknown';

                $totalQuantity = $orders->sum('quantity');
                $totalPaid = $orders->sum(function ($order) use ($item) {
                    return optional($item)->price_per_unit * $order->quantity;
                });

                return [
                    'item_name' => $itemName,
                    'staff' => $staff,
                    'quantity' => $totalQuantity,
                    'total_paid' => $totalPaid,
                ];
            })
            ->values();


        return view('event-organizer.dashboard', compact('incomePerEvent', 'monthlyIncome', 'mostOrderedItems'));
    }

    public function downloadReport(Request $request)
{
    $chart1 = $request->input('chart1'); // base64 of first chart
    $chart3 = $request->input('chart3'); // base64 of third chart

    // Your existing data
    $organizerId = auth()->id();

    $eventIncome = CustomEvent::with(['request'])
        ->where('organizer_id', $organizerId)
        ->withSum('payments', 'amount')
        ->get()
        ->map(fn($event) => [
            'title' => optional($event->request)->title ?? 'Untitled Event',
            'income' => $event->payments_sum_amount ?? 0,
        ]);

    $monthlyIncome = Payment::whereHas('customEvent', fn($q) => $q->where('organizer_id', $organizerId))
        ->where('payment_status', 'paid')
        ->get()
        ->groupBy(fn($payment) => \Carbon\Carbon::parse($payment->paid_at)->format('Y-m'))
        ->map(fn($group) => $group->sum('amount'));

    $topItems = EventInventoryOrder::with(['inventoryItem.staff'])
        ->whereHas('customEvent', fn($q) => $q->where('organizer_id', $organizerId))
        ->where('status', 'approved')
        ->get()
        ->groupBy('inventory_item_id')
        ->map(function ($orders) {
            $item = optional($orders->first()->inventoryItem);
            return [
                'item' => $item->item_name ?? 'Unknown',
                'staff' => optional($item->staff)->name ?? 'Unknown',
                'quantity' => $orders->sum('quantity'),
                'amount' => $orders->sum(fn($o) => optional($item)->price_per_unit * $o->quantity),
            ];
        });

    $pdf = Pdf::loadView('event-organizer.reports.dashboard_pdf', [
        'eventIncome' => $eventIncome,
        'monthlyIncome' => $monthlyIncome,
        'topItems' => $topItems,
        'chart1' => $chart1,
        'chart3' => $chart3
    ]);

    return $pdf->download('organizer_dashboard_report.pdf');
}
}
