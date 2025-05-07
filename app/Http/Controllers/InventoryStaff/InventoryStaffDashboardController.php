<?php

namespace App\Http\Controllers\InventoryStaff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class InventoryStaffDashboardController extends Controller
{
    public function index()
    {
        return view('inventory-staff.dashboard');
    }
}
