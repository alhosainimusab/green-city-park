<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $year = request('year', date('Y'));

        $monthlyRevenue = Payment::where('status', 'verified')
            ->whereYear('created_at', $year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        $revenueData = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueData[$m] = $monthlyRevenue[$m] ?? 0;
        }

        $ticketStats = Booking::where('status', 'confirmed')
            ->select('ticket_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('ticket_type')
            ->get();

        $topPromotions = Promotion::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        $rideStatusSummary = Ride::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $totalRevenue = Payment::where('status', 'verified')->whereYear('created_at', $year)->sum('amount');
        $totalBookings = Booking::whereYear('created_at', $year)->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->whereYear('created_at', $year)->count();

        return view('admin.reports.index', compact(
            'revenueData', 'ticketStats', 'topPromotions', 'rideStatusSummary',
            'totalRevenue', 'totalBookings', 'confirmedBookings', 'year'
        ));
    }
}
