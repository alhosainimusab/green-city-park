@extends('emails.layout')
@section('content')
<div class="greeting">Action Required — Payment Rejected</div>
<p class="text">
    Hi <strong>{{ $booking->user->name }}</strong>, unfortunately we could not verify your payment for booking
    <span class="highlight">#{{ $booking->id }}</span>.
    This could be due to an incorrect reference number or the transfer not being found.
</p>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    عذراً، لم نتمكن من التحقق من دفعتك. يرجى التحقق من رقم المرجع وإعادة إرسال البيانات الصحيحة.
</p>

<div class="info-box" style="border-color:#ffc9c9;background:#fff8f8;">
    <div class="info-row"><span class="info-lbl">Booking #</span><span class="info-val">{{ $booking->id }}</span></div>
    <div class="info-row"><span class="info-lbl">Visit Date</span><span class="info-val">{{ $booking->visit_date->format('d M Y') }}</span></div>
    <div class="info-row"><span class="info-lbl">Amount</span><span class="info-val">{{ number_format($booking->total_price) }} YER</span></div>
    @if($booking->payment && $booking->payment->reference_no)
    <div class="info-row"><span class="info-lbl">Reference Submitted</span><span class="info-val" style="font-family:monospace;color:#dc3545;">{{ $booking->payment->reference_no }}</span></div>
    @endif
    <div class="info-row"><span class="info-lbl">Status</span><span class="info-val" style="color:#dc3545;">❌ Rejected</span></div>
</div>

<p class="text"><strong>What to do next:</strong></p>
<ol style="font-size:14px;color:#555;line-height:2;padding-inline-start:20px;">
    <li>Go to your booking page</li>
    <li>Enter the correct transfer reference number</li>
    <li>Click <strong>Resubmit Payment</strong></li>
</ol>

<div style="text-align:center;">
    <a href="{{ url('/visitor/bookings/' . $booking->id) }}" class="btn" style="background:#dc3545;">Resubmit Payment</a>
</div>

<hr class="divider">
<p class="text" style="font-size:12px;color:#aaa;">
    Need help? Contact us at info@greencitypark.ye or call +967 1 234 5678
</p>
@endsection
