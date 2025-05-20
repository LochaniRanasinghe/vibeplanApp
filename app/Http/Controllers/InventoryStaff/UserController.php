<?php

namespace App\Http\Controllers\InventoryStaff;
use Throwable;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flasher\Laravel\Facade\Flasher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('inventory-staff.users.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string',
            'active_status' => 'required|in:1,0',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:customer,event_organizer,inventory_staff,inventory-staff',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        flash()->success('Profile Updated successfully.');
        return redirect()->route('inventory-staff.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    public function register()
    {
        return view('auth.register');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required|string',
            'phone_number' => 'required|string|max:10',
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        flash()->success('Profile Updated successfully.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
