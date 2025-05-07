<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login()
    {
        return view('auth.login');
    }
    
    public function loginuser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->input('email'))->first();
        // dd($user,$request->input('email'));

        if ($user) {
            if (in_array($user->role, ['customer', 'event_organizer', 'inventory_staff', 'admin'])) {
                if (Auth::attempt($credentials)) {
                    switch ($user->role) {
                        case 'customer':
                            return redirect()->intended(route('customer.dashboard'));
                        case 'event_organizer':
                            return redirect()->intended(route('event_organizer.dashboard'));
                        case 'inventory_staff':
                            return redirect()->intended(route('inventory_staff.dashboard'));
                        case 'admin':
                            return redirect()->intended(route('admin.dashboard'));
                    }
                } else {
                    return redirect()->back()->with('fail', 'These credentials do not match our records.');
                }
            } else {
                return redirect()->back()->with('fail', 'No permission to log in.');
            }
        } else {
            return redirect()->back()->with('fail', 'User does not exist.');
        }

    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }
}
