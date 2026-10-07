@extends('layouts.app')
@section('title', app()->getLocale() === 'ar' ? 'الألعاب والمرافق' : 'Rides & Attractions')
@section('content')

{{-- Page Hero --}}
<div style="background:var(--navy);padding:60px 20px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:url('data:image/svg+xml,%3Csvg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23C8922A\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 20.83l2.83-2.83 1.41 1.41L1.41 22.24H0v-1.41zM0 3.06l2.83-2.83 1.41 1.41L1.41 4.47H0V3.06zm15.54 35.53l2.83-2.83 1.41 1.41-2.83 2.83h-1.41v-1.41z\"%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E') repeat;opacity:.4;"></div>
    <div style="position:relative;z-index:1;">
        <div style="font-size:.8rem;color:var(--gold-light);text-transform:uppercase;letter-spacing:.15em;margin-bottom:10px;">
            {{ app()->getLocale() === 'ar' ? 'جرين سيتي الترفيهية' : 'Green City Entertainment' }}
        </div>
        <h1 style="font-family:'Playfair Display',serif;color:#fff;font-size:2.2rem;margin:0 0 12px;">
            {{ app()->getLocale() === 'ar' ? 'الألعاب والمرافق' : 'Rides & Attractions' }}
        </h1>
        <p style="color:rgba(255,255,255,.6);max-width:480px;margin:0 auto;">
            {{ app()->getLocale() === 'ar' ? 'استكشف تشكيلة مثيرة من الألعاب لجميع الأعمار' : 'Explore our exciting range of rides for all ages' }}
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @forelse($rides as $ride)
        <div class="col-md-6 col-lg-4">
            <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);height:100%;">
                <div style="height:5px;background:{{ $ride->status === 'active' ? 'var(--green)' : ($ride->status === 'maintenance' ? 'var(--gold)' : '#dc3545') }};"></div>
                <div style="padding:20px;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:10px;">
                        <h3 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.15rem;margin:0;">{{ $ride->name }}</h3>
                        <span class="badge-{{ $ride->status }}" style="flex-shrink:0;font-size:.72rem;">
                            @if($ride->status === 'active') {{ app()->getLocale() === 'ar' ? 'متاح' : 'Open' }}
                            @elseif($ride->status === 'maintenance') {{ app()->getLocale() === 'ar' ? 'صيانة' : 'Maintenance' }}
                            @else {{ app()->getLocale() === 'ar' ? 'مغلق' : 'Closed' }}
                            @endif
                        </span>
                    </div>
                    @if($ride->category)
                    <span style="font-size:.75rem;background:var(--cream);padding:3px 10px;border-radius:12px;color:#666;margin-bottom:10px;display:inline-block;">
                        {{ $ride->category }}
                    </span>
                    @endif
                    <p style="color:#777;font-size:.88rem;line-height:1.6;margin:10px 0 16px;">{{ $ride->description }}</p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
                        @if($ride->min_age > 0)
                        <span style="font-size:.78rem;background:rgba(45,106,79,.1);color:var(--green);padding:3px 10px;border-radius:10px;border:1px solid rgba(45,106,79,.2);">
                            <i class="fas fa-child"></i> {{ $ride->min_age }}+
                        </span>
                        @endif
                        @if($ride->min_height)
                        <span style="font-size:.78rem;background:rgba(200,146,42,.1);color:#a06a00;padding:3px 10px;border-radius:10px;border:1px solid rgba(200,146,42,.2);">
                            <i class="fas fa-ruler-vertical"></i> {{ $ride->min_height }}cm+
                        </span>
                        @endif
                        <span style="font-size:.78rem;background:rgba(27,43,58,.08);color:var(--navy);padding:3px 10px;border-radius:10px;border:1px solid rgba(27,43,58,.12);">
                            <i class="fas fa-users"></i> {{ $ride->capacity }}
                        </span>
                    </div>

                    {{-- Traffic & Wait Time --}}
                    @if($ride->status === 'active' && $ride->traffic_level)
                        @php
                            $tColor = match($ride->traffic_level) { 'low' => '#2D6A4F', 'medium' => '#C8922A', 'high' => '#dc3545', default => '#999' };
                            $tBg    = match($ride->traffic_level) { 'low' => 'rgba(45,106,79,.08)', 'medium' => 'rgba(200,146,42,.08)', 'high' => 'rgba(220,53,69,.08)', default => '#f5f5f5' };
                            $tBorder= match($ride->traffic_level) { 'low' => 'rgba(45,106,79,.2)', 'medium' => 'rgba(200,146,42,.2)', 'high' => 'rgba(220,53,69,.2)', default => '#ddd' };
                            $tLabel = match($ride->traffic_level) { 'low' => (app()->getLocale()==='ar'?'ازدحام منخفض':'Low Traffic'), 'medium' => (app()->getLocale()==='ar'?'ازدحام متوسط':'Medium Traffic'), 'high' => (app()->getLocale()==='ar'?'ازدحام مرتفع':'High Traffic'), default => '' };
                        @endphp
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <span style="display:inline-flex;align-items:center;gap:6px;font-size:.78rem;background:{{ $tBg }};color:{{ $tColor }};padding:4px 10px;border-radius:10px;border:1px solid {{ $tBorder }};font-weight:600;">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $tColor }};flex-shrink:0;"></span>
                                {{ $tLabel }}
                            </span>
                            @if($ride->wait_time !== null)
                            <span style="display:inline-flex;align-items:center;gap:5px;font-size:.78rem;background:#f5f5f5;color:#555;padding:4px 10px;border-radius:10px;border:1px solid #e0e0e0;">
                                <i class="fas fa-clock" style="font-size:.7rem;color:#888;"></i>
                                {{ app()->getLocale() === 'ar' ? 'انتظار ~' . $ride->wait_time . ' د' : '~' . $ride->wait_time . ' min wait' }}
                            </span>
                            @endif
                        </div>
                    @elseif($ride->status !== 'active')
                        <span style="font-size:.78rem;color:#bbb;font-style:italic;">
                            <i class="fas fa-ban" style="margin-inline-end:4px;"></i>
                            {{ $ride->status === 'maintenance' ? (app()->getLocale()==='ar'?'تحت الصيانة':'Under maintenance') : (app()->getLocale()==='ar'?'مغلق حالياً':'Currently closed') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12" style="text-align:center;padding:60px;color:#bbb;">
            <i class="fas fa-rocket" style="font-size:3rem;opacity:.2;display:block;margin-bottom:16px;"></i>
            {{ app()->getLocale() === 'ar' ? 'لا توجد ألعاب متاحة' : 'No rides available' }}
        </div>
        @endforelse
    </div>
    @if($rides->hasPages())
    <div style="margin-top:32px;text-align:center;">{{ $rides->links() }}</div>
    @endif

    {{-- Book CTA --}}
    <div style="margin-top:60px;background:var(--navy);border-radius:20px;padding:48px;text-align:center;">
        <h2 style="font-family:'Playfair Display',serif;color:#fff;margin:0 0 12px;">
            {{ app()->getLocale() === 'ar' ? 'مستعد للمغامرة؟' : 'Ready for Adventure?' }}
        </h2>
        <p style="color:rgba(255,255,255,.6);margin-bottom:24px;">
            {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن واستمتع بجميع الألعاب' : 'Book your ticket now and enjoy all the rides' }}
        </p>
        @auth
        <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">
            {{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}
        </a>
        @else
        <a href="{{ route('login') }}" class="btn-pk-primary">
            {{ app()->getLocale() === 'ar' ? 'سجل دخولك واحجز' : 'Login & Book' }}
        </a>
        @endauth
    </div>
</div>

@endsection
