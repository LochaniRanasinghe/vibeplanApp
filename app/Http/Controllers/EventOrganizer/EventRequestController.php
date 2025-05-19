<?php

namespace App\Http\Controllers\EventOrganizer;
use Throwable;
use Carbon\Carbon;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EventRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event-organizer.event-requests.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event-organizer.event-requests.create');
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
    public function show(EventRequest $eventRequest)
    {
        $eventRequest->load('customEvent');

        return view('event-organizer.event-requests.show', compact('eventRequest'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventRequest $eventRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventRequest $eventRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,completed,rejected',
        ]);
    
        $oldStatus = $eventRequest->status;
        $eventRequest->update(['status' => $validated['status']]);
        
        flash()->success('Event request status updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventRequest $eventRequest)
    {
        //
    }

    public function getEventRequests(Request $request)
    {
        try {
            $user = Auth::user(); 

            $query = EventRequest::with(['customer', 'eventType'])
                ->whereHas('eventType', function ($q) use ($user) {
                    $q->where('added_by', $user->id); 
                })
                ->orderBy('created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('customer', fn($eventRequest) => $eventRequest->customer?->name ?? 'N/A')
                ->addColumn('event_type', fn($eventRequest) => $eventRequest->eventType?->name ?? 'N/A')
                ->addColumn('title', fn($eventRequest) => $eventRequest->title ?? 'N/A')
                ->addColumn('location', fn($eventRequest) => $eventRequest->location ?? 'N/A')
                ->addColumn('status', function ($eventRequest) {
                    $status = strtolower($eventRequest->status);
                    $badgeClass = match ($status) {
                        'completed' => 'badge bg-success',
                        'approved'  => 'badge bg-primary',
                        'pending'   => 'badge bg-warning text-dark',
                        'rejected'  => 'badge bg-danger',
                        default     => 'badge bg-secondary',
                    };
                    return "<span class='{$badgeClass}'>" . ucfirst($status) . "</span>";
                })
                ->addColumn('event_date', fn($eventRequest) =>
                    $eventRequest->event_date
                        ? Carbon::parse($eventRequest->event_date)->format('Y-m-d')
                        : 'N/A'
                )
                ->addColumn('created_at', fn($eventRequest) =>
                    $eventRequest->created_at
                        ? Carbon::parse($eventRequest->created_at)->format('Y-m-d')
                        : 'N/A'
                )
                ->addColumn('actions', fn($eventRequest) =>
                    view('event-organizer.event-requests.components.actions', compact('eventRequest'))->render()
                )
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
