<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_visitors' => User::where('role', 'visitor')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_bookings' => Booking::count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'verified')->sum('amount'),
            'active_rides' => Ride::where('status', 'active')->count(),
            'total_rides' => Ride::count(),
            'rides_maintenance' => Ride::where('status', 'maintenance')->count(),
            'active_promotions' => Promotion::where('is_active', true)->count(),
            'upcoming_events' => Event::where('is_active', true)->where('event_date', '>=', now())->count(),
        ];

        $recentBookings = Booking::with(['user', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        $monthlyRevenue = Payment::where('status', 'verified')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        $ticketTypeStats = Booking::where('status', 'confirmed')
            ->select('ticket_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('ticket_type')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'monthlyRevenue', 'ticketTypeStats'));
    }
}
