<?php

namespace App\Http\Controllers\Admin;
use Throwable;

use Carbon\Carbon;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.event-types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'locations' => 'required|string',
            'starting_price' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'added_by' => 'nullable|exists:users,id',
        ]);

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('event-types', 'public');
            $validated['image_url'] = $path;
        }

        EventType::create($validated);

        flash()->success('Event type created successfully.');
        return redirect()->route('admin.event-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventType $eventType)
    {
        return view('admin.event-types.show', compact('eventType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventType $eventType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $eventType = EventType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'locations' => 'required|string',
            'starting_price' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'added_by' => 'nullable|exists:users,id',
        ]);

        if ($request->hasFile('image_url')) {
            if ($eventType->image_url && Storage::disk('public')->exists($eventType->image_url)) {
                Storage::disk('public')->delete($eventType->image_url);
            }
    
            // Store new image to public disk
            $path = $request->file('image_url')->store('event-types', 'public'); // ✅ Correct location
            $validated['image_url'] = $path; 
        }

        $eventType->update($validated);
        Log::info('Updated EventType:', $validated);

        flash()->success('Event type updated successfully.');
        return redirect()->back();
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType)
    {
        //
    }

    public function getEventTypes(Request $request)
    {
        try {
            $query = EventType::query()
                ->with('addedBy') 
                ->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->has('search.value')) {
                        $searchValue = $request->input('search.value');
                        $query->where(function ($subquery) use ($searchValue) {
                            $subquery->where('name', 'like', "%{$searchValue}%")
                                ->orWhere('description', 'like', "%{$searchValue}%")
                                ->orWhere('locations', 'like', "%{$searchValue}%")
                                ->orWhere('starting_price', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->addColumn('name', fn($eventType) => e($eventType->name))
                ->addColumn('description', fn($eventType) => e($eventType->description))
                ->addColumn('locations', fn($eventType) => e($eventType->locations))
                ->addColumn('starting_price', fn($eventType) => e($eventType->starting_price))
                ->addColumn('added_by', function ($eventType) {
                    if ($eventType->addedBy) {
                        $name = e($eventType->addedBy->name);
                        $role = str_contains($eventType->addedBy->role, '_')
                            ? ucwords(str_replace('_', ' ', $eventType->addedBy->role))
                            : ucfirst($eventType->addedBy->role);
                
                        return "<span class='fw-bold'>$name</span><br><small class='text-muted'>($role)</small>";
                    }
                    return 'Unknown';
                })
                ->addColumn('created_at', function ($eventType) {
                    return $eventType->created_at
                        ? Carbon::parse($eventType->created_at)->format('Y-m-d')
                        : 'N/A';
                })
                ->addColumn('actions', function ($eventType) {
                    return view('admin.event-types.components.actions', ['eventType' => $eventType])->render();
                })
                ->rawColumns(['added_by', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
