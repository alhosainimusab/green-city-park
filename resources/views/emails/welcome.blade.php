@extends('emails.layout')
@section('content')
<div class="greeting">Welcome, {{ $user->name }}! 🎉</div>
<p class="text">
    Thank you for joining <strong>Green City Entertainment Park</strong> in Marib, Yemen.
    Your account has been created successfully. You can now browse our rides, discover events, and book tickets online.
</p>
<div class="info-box">
    <div class="info-row"><span class="info-lbl">Name</span><span class="info-val">{{ $user->name }}</span></div>
    <div class="info-row"><span class="info-lbl">Email</span><span class="info-val">{{ $user->email }}</span></div>
    <div class="info-row"><span class="info-lbl">Park Hours</span><span class="info-val">9:00 AM – 10:00 PM</span></div>
    <div class="info-row"><span class="info-lbl">Location</span><span class="info-val">Marib, Yemen</span></div>
</div>
<p class="text" dir="rtl" style="font-family:Arial,sans-serif;">
    أهلاً وسهلاً <strong>{{ $user->name }}</strong>! تم إنشاء حسابك في مدينة <strong>جرين سيتي الترفيهية</strong> بنجاح. يمكنك الآن استكشاف الألعاب والفعاليات وحجز تذاكرك عبر الإنترنت.
</p>
<div style="text-align:center;">
    <a href="{{ url('/visitor/bookings/create') }}" class="btn">Book Your Tickets Now</a>
</div>
<hr class="divider">
<p class="text" style="font-size:12px;color:#aaa;text-align:center;">
    If you did not create this account, please ignore this email or contact us at info@greencitypark.ye
</p>
@endsection
