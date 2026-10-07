@extends('emails.layout')
@section('content')
<div class="greeting">Your Booking is Confirmed! ✅</div>
<p class="text">
    Great news, <strong>{{ $booking->user->name }}</strong>! Your booking has been confirmed and your QR tickets are ready.
    Please present them at the park entrance gate.
</p>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    تهانينا! تم تأكيد حجزك وتذاكر QR الخاصة بك جاهزة. قدّمها عند بوابة الدخول للحديقة.
</p>

<div class="info-box">
    <div class="info-row"><span class="info-lbl">Booking #</span><span class="info-val">{{ $booking->id }}</span></div>
    <div class="info-row"><span class="info-lbl">Visit Date</span><span class="info-val">{{ $booking->visit_date->format('l, d M Y') }}</span></div>
    @if($booking->hasBreakdown())
        @if($booking->adult_qty > 0)
        <div class="info-row"><span class="info-lbl">Adult × {{ $booking->adult_qty }}</span><span class="info-val">{{ number_format($booking->adult_qty * 1500) }} YER</span></div>
        @endif
        @if($booking->child_qty > 0)
        <div class="info-row"><span class="info-lbl">Child × {{ $booking->child_qty }}</span><span class="info-val">{{ number_format($booking->child_qty * 800) }} YER</span></div>
        @endif
        @if($booking->group_qty > 0)
        <div class="info-row"><span class="info-lbl">Group × {{ $booking->group_qty }}</span><span class="info-val">{{ number_format($booking->group_qty * 1200) }} YER</span></div>
        @endif
        @if($booking->infant_qty > 0)
        <div class="info-row"><span class="info-lbl">Infant × {{ $booking->infant_qty }}</span><span class="info-val" style="color:#2D6A4F;">Free</span></div>
        @endif
    @else
        <div class="info-row"><span class="info-lbl">Ticket Type</span><span class="info-val">{{ ucfirst($booking->ticket_type) }} × {{ $booking->quantity }}</span></div>
    @endif
    @if($booking->discount_amount > 0)
    <div class="info-row"><span class="info-lbl">Discount</span><span class="info-val" style="color:#2D6A4F;">-{{ number_format($booking->discount_amount) }} YER</span></div>
    @endif
    <div class="info-row"><span class="info-lbl">Total Paid</span><span class="info-val" style="color:#C8922A;font-size:16px;">{{ number_format($booking->total_price) }} YER</span></div>
    <div class="info-row"><span class="info-lbl">QR Tickets</span><span class="info-val">{{ $booking->tickets->count() }} ticket(s)</span></div>
</div>

<div style="text-align:center;">
    <a href="{{ url('/visitor/bookings/' . $booking->id) }}" class="btn">View QR Tickets</a>
</div>

<hr class="divider">
<p class="text" style="font-size:12px;color:#aaa;">
    Park Hours: 9:00 AM – 10:00 PM &nbsp;·&nbsp; Location: Marib, Yemen &nbsp;·&nbsp; +967 1 234 5678
</p>
@endsection
