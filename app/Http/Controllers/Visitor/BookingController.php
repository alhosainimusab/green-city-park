<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Mail\PaymentSubmittedMail;
use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('payment', 'tickets')
            ->latest()
            ->paginate(10);

        return view('visitor.bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('visitor.bookings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'adult_qty'  => 'required|integer|min:0|max:50',
            'child_qty'  => 'required|integer|min:0|max:50',
            'group_qty'  => 'required|integer|min:0|max:200',
            'infant_qty' => 'required|integer|min:0|max:20',
            'promo_code' => 'nullable|string',
        ]);

        $adultQty  = (int)$data['adult_qty'];
        $childQty  = (int)$data['child_qty'];
        $groupQty  = (int)$data['group_qty'];
        $infantQty = (int)$data['infant_qty'];
        $paidQty   = $adultQty + $childQty + $groupQty;

        if ($paidQty < 1) {
            return back()
                ->withErrors(['tickets' => app()->getLocale() === 'ar'
                    ? 'يجب إضافة تذكرة واحدة مدفوعة على الأقل.'
                    : 'Please add at least one paid ticket.'])
                ->withInput();
        }

        if ($groupQty > 0 && $groupQty < 10) {
            return back()
                ->withErrors(['group_qty' => app()->getLocale() === 'ar'
                    ? 'تذاكر المجموعة تتطلب 10 أشخاص على الأقل.'
                    : 'Group tickets require a minimum of 10 persons.'])
                ->withInput();
        }

        $subtotal = ($adultQty * 1500) + ($childQty * 800) + ($groupQty * 1200);
        $totalQty = $paidQty + $infantQty;

        // Determine legacy ticket_type field
        $types = [];
        if ($adultQty > 0)  $types[] = 'adult';
        if ($childQty > 0)  $types[] = 'child';
        if ($groupQty > 0)  $types[] = 'group';
        $ticketType = count($types) === 1 ? $types[0] : 'mixed';
        $unitPrice  = count($types) === 1 ? Booking::ticketPrice($ticketType) : 0;

        $discountAmount = 0;
        $promoId = null;

        if (!empty($data['promo_code'])) {
            $promo = Promotion::where('code', strtoupper($data['promo_code']))->first();
            if ($promo && $promo->isValid()) {
                $discountAmount = $promo->calculateDiscount($subtotal);
                $promoId = $promo->id;
            } else {
                return back()->withErrors(['promo_code' => __('messages.invalid_promo')])->withInput();
            }
        }

        $totalPrice = $subtotal - $discountAmount;

        $booking = Booking::create([
            'user_id'         => auth()->id(),
            'visit_date'      => $data['visit_date'],
            'ticket_type'     => $ticketType,
            'quantity'        => $totalQty,
            'adult_qty'       => $adultQty,
            'child_qty'       => $childQty,
            'group_qty'       => $groupQty,
            'infant_qty'      => $infantQty,
            'unit_price'      => $unitPrice,
            'total_price'     => $totalPrice,
            'discount_amount' => $discountAmount,
            'promo_id'        => $promoId,
            'status'          => 'pending',
        ]);

        if ($promoId) {
            Promotion::find($promoId)->increment('used_count');
        }

        return redirect()->route('visitor.bookings.payment', $booking->id)
            ->with('success', __('messages.booking_created'));
    }

    public function show(Booking $booking)
    {
        $this->authorizeBooking($booking);
        $booking->load('payment', 'tickets', 'promotion');
        return view('visitor.bookings.show', compact('booking'));
    }

    public function paymentForm(Booking $booking)
    {
        $this->authorizeBooking($booking);
        if ($booking->payment) {
            return redirect()->route('visitor.bookings.show', $booking->id);
        }
        return view('visitor.bookings.payment', compact('booking'));
    }

    public function submitPayment(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

        $data = $request->validate([
            'payment_method' => 'required|in:exchange_transfer,cash_at_gate',
            'reference_no'   => 'required_if:payment_method,exchange_transfer|nullable|string|max:100',
        ]);

        Payment::create([
            'booking_id'     => $booking->id,
            'reference_no'   => $data['reference_no'] ?? null,
            'amount'         => $booking->total_price,
            'payment_method' => $data['payment_method'],
            'status'         => 'pending',
            'payment_date'   => now(),
        ]);

        AppNotification::create([
            'user_id'  => $booking->user_id,
            'title_ar' => 'تم استلام طلب الدفع',
            'title_en' => 'Payment Submitted',
            'body_ar'  => 'تم استلام طلب الدفع للحجز رقم #' . $booking->id . '. في انتظار التحقق.',
            'body_en'  => 'Payment submitted for booking #' . $booking->id . '. Awaiting verification.',
            'type'     => 'info',
        ]);

        $booking->load('payment');
        try { Mail::to(auth()->user()->email)->send(new PaymentSubmittedMail($booking)); } catch (\Exception $e) {}

        return redirect()->route('visitor.bookings.show', $booking->id)
            ->with('success', __('messages.payment_submitted'));
    }

    public function resubmitPayment(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

        $payment = $booking->payment;

        if (!$payment || $payment->status !== 'rejected') {
            return back()->with('error', app()->getLocale() === 'ar'
                ? 'لا يمكن إعادة إرسال هذه الدفعة'
                : 'This payment cannot be resubmitted.');
        }

        $data = $request->validate([
            'reference_no'   => 'required|string|max:100',
            'payment_method' => 'required|in:exchange_transfer,cash_at_gate',
        ]);

        $payment->update([
            'reference_no'   => $data['reference_no'],
            'payment_method' => $data['payment_method'],
            'status'         => 'pending',
            'verified_by'    => null,
            'payment_date'   => now(),
        ]);

        AppNotification::create([
            'user_id'  => $booking->user_id,
            'title_ar' => 'تم إعادة إرسال بيانات الدفع',
            'title_en' => 'Payment Resubmitted',
            'body_ar'  => 'تم إعادة إرسال بيانات الدفع للحجز رقم #' . $booking->id . '. في انتظار التحقق من قِبل الموظف.',
            'body_en'  => 'Your payment for booking #' . $booking->id . ' has been resubmitted. Awaiting staff verification.',
            'type'     => 'info',
        ]);

        return back()->with('success', app()->getLocale() === 'ar'
            ? 'تم إعادة إرسال بيانات الدفع بنجاح، في انتظار التحقق'
            : 'Payment resubmitted successfully. Awaiting verification.');
    }

    public function cancel(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (!in_array($booking->status, ['pending'])) {
            return back()->with('error', __('messages.cannot_cancel'));
        }

        $booking->update(['status' => 'cancelled']);
        return redirect()->route('visitor.bookings.index')
            ->with('success', __('messages.booking_cancelled'));
    }

    private function authorizeBooking(Booking $booking): void
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
