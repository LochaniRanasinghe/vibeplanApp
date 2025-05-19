<?php

namespace App\Http\Controllers\EventOrganizer;
use Throwable;
use Carbon\Carbon;
use App\Models\CustomEvent;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event-organizer.scheduled-events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event-organizer.scheduled-events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_request_id' => 'required|exists:event_requests,id',
            'finalized_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if (CustomEvent::where('event_request_id', $request->event_request_id)->exists()) {
            return redirect()->back()->with('error', 'A custom event already exists for this request.');
        }

        $customEvent = CustomEvent::create([
            'event_request_id' => $request->event_request_id,
            'organizer_id' => auth()->id(), 
            'finalized_date' => $request->finalized_date,
            'total_price' => $request->total_price,
            'notes' => $request->notes,
            'status' => 'inprogress',
        ]);

        // Update the related event request status
        $eventRequest = EventRequest::find($request->event_request_id);
        $eventRequest->status = 'approved'; 
        $eventRequest->save();

        return redirect()
            ->route('event_organizer.event-requests.show', $request->event_request_id)
            ->with('success', 'Custom event created successfully.');
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
        return view('event-organizer.scheduled-events.show', compact('customEvent'));
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
            $user = Auth::user();

            $query = CustomEvent::with(['request.customer', 'organizer'])
                ->where('organizer_id', $user->id) 
                ->select('custom_events.*')
                ->orderBy('custom_events.created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('id', fn($event) => $event->id)
                ->addColumn('event_request', fn($event) => $event->request?->title ?? 'N/A')
                ->addColumn('customer', fn($event) => $event->request?->customer?->name ?? 'N/A')
                ->addColumn('organizer', fn($event) => $event->organizer?->name ?? 'N/A')
                ->addColumn('finalized_date', fn($event) =>
                    $event->finalized_date
                        ? Carbon::parse($event->finalized_date)->format('Y-m-d')
                        : 'N/A'
                )
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
                    return view('event-organizer.scheduled-events.components.actions', compact('event'))->render();
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
