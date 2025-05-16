<?php

namespace App\Http\Controllers\Admin;
use Throwable;

use Carbon\Carbon;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EventRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.event-requests.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event-requests.create');
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
        return view('admin.event-requests.show', compact('eventRequest'));  
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
            $query = EventRequest::with(['customer', 'eventType'])
                ->orderBy('created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('customer', function ($eventRequest) {
                    return $eventRequest->customer?->name ?? 'N/A';
                })
                ->addColumn('event_type', function ($eventRequest) {
                    return $eventRequest->eventType?->name ?? 'N/A';
                })
                ->addColumn('title', function ($eventRequest) {
                    return $eventRequest->title ?? 'N/A';
                })
                ->addColumn('location', function ($eventRequest) {
                    return $eventRequest->location ?? 'N/A';
                })
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
                ->addColumn('event_date', function ($eventType) {
                    return $eventType->event_date
                        ? Carbon::parse($eventType->event_date)->format('Y-m-d')
                        : 'N/A';
                })
                ->addColumn('created_at', function ($eventType) {
                    return $eventType->created_at
                        ? Carbon::parse($eventType->created_at)->format('Y-m-d')
                        : 'N/A';
                })
                ->addColumn('actions', function ($eventRequest) {
                    return view('admin.event-requests.components.actions', compact('eventRequest'))->render();
                })
                ->rawColumns(['status','actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
