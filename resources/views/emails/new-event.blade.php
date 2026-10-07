@extends('emails.layout')
@section('content')
<div class="greeting">🎪 New Event at Green City Park!</div>
<p class="text">
    We're excited to announce a new event. Mark your calendar and don't miss it!
</p>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    يسعدنا إعلانكم عن فعالية جديدة في مدينة جرين سيتي الترفيهية. لا تفوّتوها!
</p>

<div class="info-box">
    <div class="info-row">
        <span class="info-lbl">Event</span>
        <span class="info-val" style="font-size:16px;">{{ $event->title_en }}</span>
    </div>
    @if($event->title_ar)
    <div class="info-row" dir="rtl">
        <span class="info-val" style="font-size:15px;">{{ $event->title_ar }}</span>
    </div>
    @endif
    <div class="info-row">
        <span class="info-lbl">Date</span>
        <span class="info-val" style="color:#2D6A4F;">{{ \Carbon\Carbon::parse($event->event_date)->format('l, d M Y') }}</span>
    </div>
    @if($event->start_time)
    <div class="info-row">
        <span class="info-lbl">Time</span>
        <span class="info-val">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}{{ $event->end_time ? ' – ' . \Carbon\Carbon::parse($event->end_time)->format('h:i A') : '' }}</span>
    </div>
    @endif
    @if($event->location_en)
    <div class="info-row">
        <span class="info-lbl">Location</span>
        <span class="info-val">{{ $event->location_en }}</span>
    </div>
    @endif
    @if($event->description_en)
    <div class="info-row" style="flex-direction:column;gap:6px;">
        <span class="info-lbl">About</span>
        <span style="font-size:13px;color:#555;line-height:1.6;">{{ Str::limit($event->description_en, 200) }}</span>
    </div>
    @endif
</div>

<div style="text-align:center;">
    <a href="{{ url('/visitor/bookings/create') }}" class="btn">Book Tickets for This Event</a>
</div>

<hr class="divider">
<p class="text" style="font-size:12px;color:#aaa;text-align:center;">
    Green City Entertainment Park · Marib, Yemen · 9:00 AM – 10:00 PM
</p>
@endsection
