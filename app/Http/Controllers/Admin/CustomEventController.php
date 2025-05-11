<?php

namespace App\Http\Controllers\Admin;
use Throwable;

use App\Models\CustomEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CustomEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.scheduled-events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.scheduled-events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomEvent $customEvent)
    {
        $customEvent->load([
            'request.customer',
            'request.eventType.addedBy',
            'inventoryOrders.inventoryItem.staff'
        ]);
        return view('admin.scheduled-events.show', compact('customEvent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomEvent $customEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, CustomEvent $customEvent)
    {
        $validated = $request->validate([
            'finalized_date' => 'nullable|date',
            'total_price'    => 'required|numeric|min:0',
            'notes'          => 'nullable|string|max:1000',
            'status'         => 'required|in:inprogress,confirmed,cancelled',
        ]);

        $customEvent->update($validated);

        flash()->success('Scheduled event updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomEvent $customEvent)
    {
        //
    }

    public function getCustomEvents(Request $request)
    {
        try {
            $query = CustomEvent::with(['request.customer', 'organizer'])
                ->select('custom_events.*')
                ->orderBy('custom_events.created_at', 'desc');


            return DataTables::eloquent($query)
                ->addColumn('id', fn($event) => $event->id)
                ->addColumn('event_request', fn($event) => $event->request?->title ?? 'N/A')
                ->addColumn('customer', fn($event) => $event->request?->customer?->name ?? 'N/A')
                ->addColumn('organizer', fn($event) => $event->organizer?->name ?? 'N/A')
                ->addColumn('finalized_date', fn($event) => $event->finalized_date ? \Carbon\Carbon::parse($event->finalized_date)->format('Y-m-d') : 'N/A')
                ->addColumn('total_price', fn($event) => '$' . number_format($event->total_price, 2))
                ->addColumn('status', function ($event) {
                    $status = strtolower($event->status);
                
                    $badgeClass = match ($status) {
                        'inprogress' => 'badge bg-primary text-white',
                        'confirmed'  => 'badge bg-success',
                        'cancelled'  => 'badge bg-danger',
                        default      => 'badge bg-secondary',
                    };
                
                    return "<span class='{$badgeClass}'>" . ucfirst($status) . "</span>";
                })
                ->addColumn('actions', function ($event) {
                    return view('admin.scheduled-events.components.actions', compact('event'))->render();
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
