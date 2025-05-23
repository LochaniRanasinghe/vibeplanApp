<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function home()
    {
        $eventTypes = EventType::orderBy('created_at', 'desc')->get();
        return view('home', compact('eventTypes'));
    }

    public function about()
    {
        return view('about');
    }

    public function news()
    {
        return view('news');
    }
}
