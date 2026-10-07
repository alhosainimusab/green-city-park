@extends('emails.layout')
@section('content')
<div class="greeting">Payment Received — Under Review</div>
<p class="text">
    Hi <strong>{{ $booking->user->name }}</strong>, we've received your payment details for booking <span class="highlight">#{{ $booking->id }}</span>.
    Our team will verify it shortly. You'll receive a confirmation email once verified.
</p>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    مرحباً <strong>{{ $booking->user->name }}</strong>، استلمنا بيانات دفعتك للحجز رقم <strong>#{{ $booking->id }}</strong>. سيقوم فريقنا بالتحقق منها قريباً.
</p>

<div class="info-box">
    <div class="info-row"><span class="info-lbl">Booking #</span><span class="info-val">{{ $booking->id }}</span></div>
    <div class="info-row"><span class="info-lbl">Visit Date</span><span class="info-val">{{ $booking->visit_date->format('d M Y') }}</span></div>
    <div class="info-row"><span class="info-lbl">Amount</span><span class="info-val" style="color:#C8922A;">{{ number_format($booking->total_price) }} YER</span></div>
    @if($booking->payment && $booking->payment->reference_no)
    <div class="info-row"><span class="info-lbl">Reference No.</span><span class="info-val" style="font-family:monospace;">{{ $booking->payment->reference_no }}</span></div>
    @endif
    <div class="info-row"><span class="info-lbl">Status</span><span class="info-val" style="color:#C8922A;">Awaiting Verification</span></div>
</div>

<div style="text-align:center;">
    <a href="{{ url('/visitor/bookings/' . $booking->id) }}" class="btn">View Booking</a>
</div>
@endsection
