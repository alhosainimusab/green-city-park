<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $bookings = Booking::where('user_id', $user->id)
            ->with('payment')
            ->latest()
            ->take(5)
            ->get();

        $notifications = AppNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_bookings' => Booking::where('user_id', $user->id)->count(),
            'confirmed' => Booking::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'pending' => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        return view('visitor.dashboard', compact('bookings', 'notifications', 'stats'));
    }
}
