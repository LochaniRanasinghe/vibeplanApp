<?php

namespace App\Http\Controllers\Customers;
use App\Http\Controllers\Controller;

use App\Models\EventType;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRequestController extends Controller
{
    public function show(EventType $eventType)
    {
        $eventType->load('addedBy');
    
        $locations = explode(',', $eventType->locations);
    
        return view('customer.show_order', compact('eventType', 'locations'));
    }
    

    public function create(EventType $eventType)
    {
        $locations = explode(',', $eventType->locations);
        return view('customer.place_order', compact('eventType', 'locations'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'event_type_id' => 'required|exists:event_types,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'guest_count' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
        ]);

        EventRequest::create([
            'customer_id' => Auth::id(),
            'event_type_id' => $request->event_type_id,
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'guest_count' => $request->guest_count,
            'location' => $request->location,
            'status' => 'pending', 
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Your event request has been submitted successfully!');
    }
}
