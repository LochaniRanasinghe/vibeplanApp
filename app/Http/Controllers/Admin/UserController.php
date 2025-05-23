<?php

namespace App\Http\Controllers\Admin;
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
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
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
            'role' => 'required|string|in:customer,event_organizer,inventory_staff,admin',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        flash()->success('User registered successfully.');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registeruser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed', 
            'role' => 'required|in:customer,event_organizer,inventory_staff,admin',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'active_status' => '1', 
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
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
            'role' => 'required|in:customer,event_organizer,inventory_staff,admin',
            'active_status' => 'required|in:1,0',
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        flash()->success('User Updated successfully.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getEventOrganizers(Request $request)
    {
        return $this->getUsersByRole($request, 'event_organizer');
    }

    public function getInventoryStaff(Request $request)
    {
        return $this->getUsersByRole($request, 'inventory_staff');
    }

    public function getCustomers(Request $request)
    {
        return $this->getUsersByRole($request, 'customer');
    }

    private function getUsersByRole(Request $request, string $role)
    {
        try {
            $query = User::query()
            ->where('role', $role)
            ->whereIn('active_status', ['1', '0'])
            ->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->has('search.value')) {
                        $searchValue = $request->input('search.value');
                        $query->where(function ($subquery) use ($searchValue) {
                            $subquery->where('name', 'like', "%{$searchValue}%")
                                ->orWhere('email', 'like', "%{$searchValue}%")
                                ->orWhere('phone_number', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->addColumn('name', function ($user) {
                    return e($user->name);
                })
                ->addColumn('phone_number', function ($user) {
                    return e($user->phone_number);
                })
                ->addColumn('email', function ($user) {
                    return e($user->email);
                })
                ->addColumn('address', function ($user) {
                    return e($user->address);
                })
                ->addColumn('active_status', function ($user) {
                    if ($user->active_status == '1') {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactive</span>';
                    }
                })
                ->addColumn('role', function ($user) {
                    $role = $user->role;
                
                    if (str_contains($role, '_')) {
                        return e(ucwords(str_replace('_', ' ', $role)));
                    }
                
                    return e(ucfirst($role));
                })                
                ->addColumn('created_at', function ($user) {
                    return $user->created_at 
                        ? Carbon::parse($user->created_at)->format('Y-m-d') 
                        : 'N/A';
                })                             
                ->addColumn('actions', function ($user) {
                    return view('admin.users.components.actions', ['user' => $user])->render();
                })
                ->rawColumns(['actions','active_status'])
                ->make(true);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
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

        if ($user) {
            if ($user->active_status !== '1') {
                return redirect()->back()->with('fail', 'Your account is not active.');
            }

            if (in_array($user->role, ['customer', 'event_organizer', 'inventory_staff', 'admin'])) {
                if (Auth::attempt($credentials)) {
                    switch ($user->role) {
                        case 'customer':
                            return redirect()->intended(route('customer.event-requests.index'))->with('success', 'Login successful.');
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
