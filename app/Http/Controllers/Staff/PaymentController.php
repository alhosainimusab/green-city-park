<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentVerifiedMail;
use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('booking.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15);
        return view('staff.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('booking.user', 'booking.tickets');
        return view('staff.payments.show', compact('payment'));
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
        ]);

        $booking = $payment->booking;
        $booking->update(['status' => 'confirmed']);

        // Generate tickets if not already done
        if ($booking->tickets()->count() === 0) {
            for ($i = 0; $i < $booking->paidQuantity(); $i++) {
                Ticket::create([
                    'booking_id' => $booking->id,
                    'qr_code' => 'GCP-' . strtoupper(Str::random(12)),
                    'is_used' => false,
                    'issued_at' => now(),
                ]);
            }
        }

        AppNotification::create([
            'user_id' => $booking->user_id,
            'title_ar' => 'تم التحقق من الدفع',
            'title_en' => 'Payment Verified',
            'body_ar' => 'تم التحقق من دفعتك وتأكيد حجزك رقم #' . $booking->id . '.',
            'body_en' => 'Your payment has been verified and booking #' . $booking->id . ' is confirmed.',
            'type' => 'success',
        ]);

        $booking->load('user');
        try { Mail::to($booking->user->email)->send(new PaymentVerifiedMail($booking)); } catch (\Exception $e) {}

        return back()->with('success', __('messages.payment_verified'));
    }

    public function reject(Payment $payment)
    {
        $payment->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
        ]);

        AppNotification::create([
            'user_id'  => $payment->booking->user_id,
            'title_ar' => 'تم رفض الدفعة',
            'title_en' => 'Payment Rejected',
            'body_ar'  => 'عذراً، تم رفض دفعتك للحجز رقم #' . $payment->booking_id . '. يرجى التحقق من رقم المرجع وإعادة إرساله من صفحة تفاصيل الحجز.',
            'body_en'  => 'Sorry, your payment for booking #' . $payment->booking_id . ' was rejected. Please check your reference number and resubmit from the booking details page.',
            'type'     => 'danger',
        ]);

        $rejectedBooking = $payment->booking->load('user');
        try { Mail::to($rejectedBooking->user->email)->send(new PaymentRejectedMail($rejectedBooking)); } catch (\Exception $e) {}

        return back()->with('success', __('messages.payment_rejected'));
    }
}
