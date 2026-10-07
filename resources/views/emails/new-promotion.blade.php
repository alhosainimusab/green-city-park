@extends('emails.layout')
@section('content')
<div class="greeting">🎉 Exclusive Offer Just for You!</div>
<p class="text">
    We have a special promotion available at <strong>Green City Entertainment Park</strong>. Don't miss out!
</p>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    لدينا عرض حصري في مدينة <strong>جرين سيتي الترفيهية</strong>. لا تفوّته!
</p>

<div style="text-align:center;margin:24px 0;">
    <div style="display:inline-block;background:#1B2B3A;padding:16px 32px;border-radius:12px;">
        <div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:6px;letter-spacing:.1em;text-transform:uppercase;">Promo Code</div>
        <div style="font-family:monospace;font-size:28px;font-weight:800;color:#F0C96B;letter-spacing:.15em;">{{ $promotion->code }}</div>
    </div>
</div>

<div class="info-box">
    <div class="info-row"><span class="info-lbl">Offer</span><span class="info-val">{{ $promotion->name_en }}</span></div>
    <div class="info-row">
        <span class="info-lbl">Discount</span>
        <span class="info-val" style="color:#C8922A;font-size:16px;">
            @if($promotion->discount_type === 'percentage')
                {{ $promotion->discount_value }}% OFF
            @else
                {{ number_format($promotion->discount_value) }} YER OFF
            @endif
        </span>
    </div>
    <div class="info-row"><span class="info-lbl">Valid From</span><span class="info-val">{{ $promotion->valid_from->format('d M Y') }}</span></div>
    <div class="info-row"><span class="info-lbl">Valid Until</span><span class="info-val">{{ $promotion->valid_until->format('d M Y') }}</span></div>
    @if($promotion->max_uses)
    <div class="info-row"><span class="info-lbl">Limited To</span><span class="info-val">{{ $promotion->max_uses }} uses</span></div>
    @endif
</div>

<p class="text" style="text-align:center;color:#888;font-size:12px;">
    Enter the code <strong style="color:#C8922A;">{{ $promotion->code }}</strong> during checkout to apply the discount.
</p>

<div style="text-align:center;">
    <a href="{{ url('/visitor/bookings/create') }}" class="btn">Book Tickets Now</a>
</div>
@endsection
