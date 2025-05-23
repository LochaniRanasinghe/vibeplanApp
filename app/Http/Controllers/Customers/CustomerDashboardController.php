<?php

namespace App\Http\Controllers\Customers;
use App\Models\EventType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('customer.customer-profile', compact('user'));
    }

    public function bookevents()
    {
        $eventTypes = EventType::orderBy('created_at', 'desc')->get();
        return view('customer.book-events', compact('eventTypes'));
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Handle password update
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'nullable|string|min:8|confirmed',
            ]);
        
            $validated['password'] = bcrypt($request->password);
        }     

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_photos', 'public');
            $validated['profile_image'] = $path;
        }

        // Update user information
        $user->update($validated);

        flash()->success('Profile Updated successfully.');
        return redirect()->back();
    }

}
