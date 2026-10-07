<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Promotion;
use App\Models\Ride;

class PublicController extends Controller
{
    public function home()
    {
        $rides = Ride::where('status', 'active')->take(6)->get();
        $events = Event::where('is_active', true)
            ->where('event_date', '>=', today())
            ->orderBy('event_date')
            ->take(4)
            ->get();
        $promotion = Promotion::where('is_active', true)
            ->where('valid_from', '<=', today())
            ->where('valid_until', '>=', today())
            ->latest()
            ->first();

        return view('public.home', compact('rides', 'events', 'promotion'));
    }

    public function rides()
    {
        $rides = Ride::where('status', 'active')->paginate(12);
        return view('public.rides', compact('rides'));
    }

    public function events()
    {
        $events = Event::where('is_active', true)
            ->where('event_date', '>=', today())
            ->orderBy('event_date')
            ->paginate(12);

        return view('public.events', compact('events'));
    }

    public function map()
    {
        return view('public.map');
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
