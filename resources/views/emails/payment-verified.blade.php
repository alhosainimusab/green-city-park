@extends('emails.layout')
@section('content')
<div class="greeting">Payment Verified — See You at the Park! 🎢</div>
<p class="text">
    Great news, <strong>{{ $booking->user->name }}</strong>! Your payment for booking <span class="highlight">#{{ $booking->id }}</span> has been verified.
    Your QR tickets are now ready. Show them at the entrance gate on your visit day.
</p>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    تم التحقق من دفعتك وتذاكر QR الخاصة بك جاهزة الآن. أبرزها عند بوابة الدخول يوم زيارتك.
</p>

<div class="info-box">
    <div class="info-row"><span class="info-lbl">Booking #</span><span class="info-val">{{ $booking->id }}</span></div>
    <div class="info-row"><span class="info-lbl">Visit Date</span><span class="info-val" style="color:#2D6A4F;font-size:15px;">{{ $booking->visit_date->format('l, d M Y') }}</span></div>
    <div class="info-row"><span class="info-lbl">Total</span><span class="info-val" style="color:#C8922A;">{{ number_format($booking->total_price) }} YER</span></div>
    <div class="info-row"><span class="info-lbl">Tickets</span><span class="info-val">{{ $booking->paidQuantity() }} QR ticket(s)</span></div>
    <div class="info-row"><span class="info-lbl">Status</span><span class="info-val" style="color:#2D6A4F;">✅ Confirmed</span></div>
</div>

<div style="text-align:center;">
    <a href="{{ url('/visitor/tickets') }}" class="btn">View My QR Tickets</a>
</div>

<hr class="divider">
<p class="text" style="font-size:12px;color:#aaa;">
    Park Hours: 9:00 AM – 10:00 PM &nbsp;·&nbsp; Marib, Yemen &nbsp;·&nbsp; +967 1 234 5678
</p>
@endsection
