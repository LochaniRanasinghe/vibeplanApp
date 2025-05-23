<?php

namespace App\Http\Controllers\Customers;
use Carbon\Carbon;

use App\Models\Payment;
use App\Models\EventType;
use App\Models\CustomEvent;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerEventsController extends Controller
{
    public function index()
    {
        return view('customer.requested-events');
    }

    public function getEventRequests(Request $request)
    {
        try {
            $user = Auth::user();
    
            $query = EventRequest::with('eventType')
                ->where('customer_id', $user->id)
                ->where('status', '!=', 'approved')
                ->orderBy('created_at', 'desc');
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('event_id', fn($row) => $row->id ?? 'N/A')
                ->addColumn('event_type', fn($row) => $row->eventType->name ?? 'N/A')
                ->addColumn('title', fn($row) => $row->title ?? 'N/A')
                ->addColumn('guest_count', fn($row) => $row->guest_count ?? 'N/A')
                ->addColumn('location', fn($row) => $row->location ?? 'N/A')
                ->addColumn('date', fn($row) => $row->event_date ? Carbon::parse($row->event_date)->format('Y-m-d') : 'N/A')
                ->addColumn('status', fn($row) => $row->status)
                ->addColumn('actions', fn($row) => view('customer.components.requested-events-actions', ['row' => $row])->render())
                ->rawColumns(['actions'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch requested events.'], 500);
        }
    }

    public function viewInvoice(CustomEvent $custom_event)
    {
        // Authorize access (optional, depending on role)
        if (auth()->id() !== $custom_event->request->customer_id) {
            abort(403, 'Unauthorized');
        }

        return view('customer.custom-events.invoice', [
            'customEvent' => $custom_event,
            'eventRequest' => $custom_event->request,
            'organizer' => $custom_event->organizer,
            'eventType' => $custom_event->request->eventType
        ]);
    }

    public function uploadPayment(CustomEvent $custom_event)
    {
        // Only the customer who made the request can upload
        if (auth()->id() !== $custom_event->request->customer_id) {
            abort(403, 'Unauthorized');
        }

        return view('customer.custom-events.upload-payment', [
            'customEvent' => $custom_event,
            'eventRequest' => $custom_event->request,
            'totalAmount' => $custom_event->total_price
        ]);
    }

    public function storePayment(Request $request, CustomEvent $custom_event)
    {
        $request->validate([
            'payment_method' => 'required|string|in:bank_transfer,card,cash',
            'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        // Ensure correct customer is uploading
        if (auth()->id() !== $custom_event->request->customer_id) {
            abort(403, 'Unauthorized action.');
        }

        $slipPath = $request->file('payment_slip')->store('payment_slips', 'public');

        Payment::create([
            'customer_id' => auth()->id(),
            'custom_event_id' => $custom_event->id,
            'amount' => $custom_event->total_price,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'paid_at' => now(),
            'slip_path' => $slipPath,
        ]);

        return redirect()->route('customer.event-requests.index')->with('success', 'Payment submitted successfully!');
    }


    public function getCustomEvents(Request $request)
    {
        try {
            $user = Auth::user();

            $query = CustomEvent::with(['request.eventType', 'payments'])
                ->whereHas('request', fn($q) => $q->where('customer_id', $user->id))
                ->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('custom_event_id', fn($row) => $row->id)
                ->addColumn('event_type', fn($row) => $row->request->eventType->name ?? 'N/A')
                ->addColumn('title', fn($row) => $row->request->title ?? 'N/A')
                ->addColumn('guest_count', fn($row) => $row->request->guest_count ?? 'N/A')
                ->addColumn('location', fn($row) => $row->request->location ?? 'N/A')
                ->addColumn('finalized_date', fn($row) => $row->finalized_date ? Carbon::parse($row->finalized_date)->format('Y-m-d') : 'Pending')
                ->addColumn('total_price', fn($row) => 'Rs. ' . number_format($row->total_price))
                ->addColumn('status', fn($row) => $row->status)
                ->addColumn('payment_status', function ($row) {
                    return $row->payments->count() > 0 ? 'paid' : 'pending';
                })
                ->addColumn('actions', function ($row) {
                    $paymentStatus = $row->payments->count() > 0 ? 'paid' : 'pending';
                    return view('customer.components.custom-events-actions', [
                        'row' => $row,
                        'paymentStatus' => $paymentStatus
                    ])->render();
                })                                ->rawColumns(['actions'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch custom events.'], 500);
        }
    }


    
}
