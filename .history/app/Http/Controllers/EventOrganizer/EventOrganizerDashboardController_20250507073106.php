<?php

namespace App\Http\Controllers\EventOrganizer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EventOrganizerDashboardController extends Controller
{
    public function index()
    {
        return view('event-organizer.dashboard');
    }
}
