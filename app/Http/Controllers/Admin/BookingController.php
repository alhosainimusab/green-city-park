<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmedMail;
use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'payment', 'tickets', 'promotion']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        // Generate tickets
        $this->generateTickets($booking);

        // Notify user
        AppNotification::create([
            'user_id' => $booking->user_id,
            'title_ar' => 'تم تأكيد حجزك',
            'title_en' => 'Booking Confirmed',
            'body_ar' => 'تم تأكيد حجزك رقم #' . $booking->id . '. يمكنك الآن عرض تذاكرك.',
            'body_en' => 'Your booking #' . $booking->id . ' has been confirmed. You can now view your tickets.',
            'type' => 'success',
        ]);

        $booking->load('user', 'tickets');
        try { Mail::to($booking->user->email)->send(new BookingConfirmedMail($booking)); } catch (\Exception $e) {}

        return back()->with('success', __('messages.booking_confirmed'));
    }

    public function reject(Request $request, Booking $booking)
    {
        $booking->update(['status' => 'rejected']);

        AppNotification::create([
            'user_id' => $booking->user_id,
            'title_ar' => 'تم رفض حجزك',
            'title_en' => 'Booking Rejected',
            'body_ar' => 'عذراً، تم رفض حجزك رقم #' . $booking->id . '.',
            'body_en' => 'Sorry, your booking #' . $booking->id . ' has been rejected.',
            'type' => 'danger',
        ]);

        return back()->with('success', __('messages.booking_rejected'));
    }

    private function generateTickets(Booking $booking): void
    {
        if ($booking->tickets()->count() > 0) {
            return;
        }

        for ($i = 0; $i < $booking->paidQuantity(); $i++) {
            Ticket::create([
                'booking_id' => $booking->id,
                'qr_code' => 'GCP-' . strtoupper(Str::random(12)),
                'is_used' => false,
                'issued_at' => now(),
            ]);
        }
    }
}
