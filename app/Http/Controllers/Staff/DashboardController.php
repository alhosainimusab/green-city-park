<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ride;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'today_bookings' => Booking::whereDate('visit_date', today())->count(),
            'active_rides' => Ride::where('status', 'active')->count(),
            'rides_maintenance' => Ride::where('status', 'maintenance')->count(),
        ];

        $pendingPayments = Payment::with('booking.user')
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        $todayTickets = Ticket::whereHas('booking', function ($q) {
            $q->whereDate('visit_date', today())->where('status', 'confirmed');
        })->take(10)->get();

        return view('staff.dashboard', compact('stats', 'pendingPayments', 'todayTickets'));
    }
}
