@extends('layouts.app')
@section('title', __('messages.park_name') . ' — ' . __('messages.park_tagline'))

@section('content')

{{-- Hero --}}
<div class="pk-hero">
    <div class="pk-hero-inner">
        <div class="eyebrow">🏺 {{ app()->getLocale() === 'ar' ? 'مأرب، اليمن — أرض سبأ' : 'Marib, Yemen — Land of Saba' }} · مأرب، اليمن</div>
        <h1>
            {{ app()->getLocale() === 'ar' ? 'استمتع بسحر' : 'Experience the Magic of' }}
            <span>{{ app()->getLocale() === 'ar' ? 'جرين سيتي' : 'Green City' }}</span>
        </h1>
        <p class="subtitle">
            {{ app()->getLocale() === 'ar'
                ? 'أكبر وجهة ترفيهية في مأرب — 7 مناطق و50+ لعبة ومسرح سبأ الأيقوني. احجز زيارتك الآن.'
                : "Marib's largest entertainment destination — 7 zones, 50+ rides, and the iconic Sabaean Theatre. Book your visit online in minutes." }}
        </p>
        <div class="d-flex gap-3 flex-wrap">
            @if(auth()->check() && auth()->user()->role === 'visitor')
                <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن' : 'Book Tickets Now' }}</a>
            @elseif(!auth()->check())
                <a href="{{ route('register') }}" class="btn-pk-primary">🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن' : 'Book Tickets Now' }}</a>
                <a href="{{ route('login') }}" class="btn-pk-secondary">{{ __('messages.login') }}</a>
            @endif
        </div>
        <div class="hero-stats">
            <div><div class="stat-val">50+</div><div class="stat-lbl">{{ app()->getLocale() === 'ar' ? 'لعبة' : 'Rides' }}</div></div>
            <div><div class="stat-val">7</div><div class="stat-lbl">{{ app()->getLocale() === 'ar' ? 'منطقة' : 'Zones' }}</div></div>
            <div><div class="stat-val">600</div><div class="stat-lbl">{{ app()->getLocale() === 'ar' ? 'مقعد مسرح' : 'Theatre Seats' }}</div></div>
            <div><div class="stat-val">4.6★</div><div class="stat-lbl">{{ app()->getLocale() === 'ar' ? 'تقييم' : 'Rating' }}</div></div>
        </div>
    </div>
</div>

{{-- Three-column info cards --}}
<div class="pk-cards-grid">
    {{-- Live Ride Status --}}
    <div class="pk-card">
        <div class="pk-card-header">🎡 {{ app()->getLocale() === 'ar' ? 'حالة الألعاب الآن' : 'Live Ride Status' }}</div>
        <div class="pk-card-body">
            @forelse($rides->take(5) as $ride)
            <div class="ride-row">
                <div>
                    <div class="ride-name">{{ $ride->name }}</div>
                    <div class="ride-zone">{{ $ride->category }}</div>
                </div>
                <span class="badge-{{ $ride->status === 'active' ? 'available' : ($ride->status === 'maintenance' ? 'maintenance' : 'busy') }}">
                    {{ $ride->status === 'active' ? '● '.( app()->getLocale() === 'ar' ? 'متاح' : 'Available') : ($ride->status === 'maintenance' ? '🔧 '.( app()->getLocale() === 'ar' ? 'صيانة' : 'Maintenance') : '⏳ '.( app()->getLocale() === 'ar' ? 'مشغول' : 'Busy')) }}
                </span>
            </div>
            @empty
            <div style="text-align:center;color:var(--text-muted);font-size:12px;padding:14px 0;">{{ __('messages.no_data') }}</div>
            @endforelse
            <div style="margin-top:10px;">
                <a href="{{ route('rides') }}" class="btn-pk-outline" style="font-size:11px;padding:5px 14px;">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }} →</a>
            </div>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="pk-card">
        <div class="pk-card-header">🎭 {{ app()->getLocale() === 'ar' ? 'الفعاليات القادمة' : 'Upcoming Events' }}</div>
        <div class="pk-card-body">
            @forelse($events->take(4) as $event)
            <div class="event-item">
                <div class="event-name">{{ $event->title }}</div>
                <div class="event-meta">{{ $event->event_date->format('d M Y') }} · <span class="event-venue">{{ $event->location }}</span></div>
            </div>
            @empty
            <div style="text-align:center;color:var(--text-muted);font-size:12px;padding:14px 0;">{{ __('messages.no_data') }}</div>
            @endforelse
            <div style="margin-top:10px;">
                <a href="{{ route('events') }}" class="btn-pk-outline" style="font-size:11px;padding:5px 14px;">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }} →</a>
            </div>
        </div>
    </div>

    {{-- Active Promotion --}}
    <div class="pk-card">
        <div class="pk-card-header">🏷️ {{ app()->getLocale() === 'ar' ? 'عرض نشط' : 'Active Promotion' }}</div>
        <div class="pk-card-body">
            @php
                $activePromo = \App\Models\Promotion::where('is_active', true)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now())
                    ->first();
            @endphp
            @if($activePromo)
            <div class="promo-box">
                <div class="promo-pct">
                    {{ $activePromo->discount_type === 'percentage' ? $activePromo->discount_value . '% OFF' : number_format($activePromo->discount_value) . ' YER OFF' }}
                </div>
                <div class="promo-off">{{ app()->getLocale() === 'ar' ? 'على جميع أنواع التذاكر' : 'All ticket types' }}</div>
                <div class="promo-code">{{ $activePromo->code }}</div>
                <div class="promo-exp">{{ app()->getLocale() === 'ar' ? 'صالح حتى' : 'Valid until' }} {{ $activePromo->valid_until->format('d M Y') }}</div>
            </div>
            @else
            <div style="text-align:center;color:var(--text-muted);font-size:12px;padding:20px 0;">
                {{ app()->getLocale() === 'ar' ? 'لا توجد عروض نشطة حالياً' : 'No active promotions at the moment' }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Ticket Prices --}}
<div style="background:var(--white);padding:36px 32px;">
    <div style="text-align:center;margin-bottom:24px;">
        <div style="font-size:10px;color:var(--gold);letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;">🎫 {{ app()->getLocale() === 'ar' ? 'أسعار التذاكر' : 'Ticket Prices' }}</div>
        <h2 class="section-title">{{ app()->getLocale() === 'ar' ? 'اختر نوع تذكرتك' : 'Choose Your Ticket' }}</h2>
    </div>
    <div class="row g-3 justify-content-center" style="max-width:760px;margin:0 auto;">
        <div class="col-md-4">
            <div class="price-card">
                <div class="pc-icon">👨</div>
                <div class="pc-type">{{ __('messages.adult_ticket') }}</div>
                <div class="pc-price">1,500 {{ __('messages.yer') }}</div>
                <div class="pc-desc">{{ app()->getLocale() === 'ar' ? 'للبالغين (13 سنة فأكثر)' : 'For adults (ages 13+)' }}</div>
                <a href="{{ (auth()->check() && auth()->user()->role === 'visitor') ? route('visitor.bookings.create') : route('register') }}" class="btn-pk-primary" style="width:100%;display:block;text-align:center;">{{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="price-card" style="border-color:var(--gold);box-shadow:0 0 0 2px var(--gold);">
                <div class="pc-icon">👦</div>
                <div class="pc-type">{{ __('messages.child_ticket') }}</div>
                <div class="pc-price">800 {{ __('messages.yer') }}</div>
                <div class="pc-desc">{{ app()->getLocale() === 'ar' ? 'للأطفال (3-12 سنة)' : 'For children (ages 3-12)' }}</div>
                <a href="{{ (auth()->check() && auth()->user()->role === 'visitor') ? route('visitor.bookings.create') : route('register') }}" class="btn-pk-primary" style="width:100%;display:block;text-align:center;">{{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="price-card">
                <div class="pc-icon">👪</div>
                <div class="pc-type">{{ __('messages.group_ticket') }}</div>
                <div class="pc-price">1,200 {{ __('messages.yer') }}/{{ app()->getLocale() === 'ar' ? 'شخص' : 'person' }}</div>
                <div class="pc-desc">{{ app()->getLocale() === 'ar' ? 'للمجموعات (10 أشخاص فأكثر)' : 'For groups (10+ people)' }}</div>
                <a href="{{ (auth()->check() && auth()->user()->role === 'visitor') ? route('visitor.bookings.create') : route('register') }}" class="btn-pk-primary" style="width:100%;display:block;text-align:center;">{{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}</a>
            </div>
        </div>
    </div>
</div>

{{-- Rides section --}}
@if($rides->count())
<div style="background:var(--cream-light);padding:36px 32px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <div style="font-size:10px;color:var(--gold);letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">🎢 {{ app()->getLocale() === 'ar' ? 'الألعاب' : 'Attractions' }}</div>
            <h2 class="section-title" style="margin-bottom:0;">{{ app()->getLocale() === 'ar' ? 'ألعابنا' : 'Our Rides' }}</h2>
        </div>
        <a href="{{ route('rides') }}" class="btn-pk-outline">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}</a>
    </div>
    <div class="row g-3">
        @foreach($rides->take(6) as $ride)
        <div class="col-md-4 col-sm-6">
            <div class="ride-card">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:7px;">
                    <div class="rc-name">{{ $ride->name }}</div>
                    <span class="badge-{{ $ride->status === 'active' ? 'available' : ($ride->status === 'maintenance' ? 'maintenance' : 'busy') }}" style="font-size:9px;">
                        {{ $ride->status === 'active' ? ( app()->getLocale() === 'ar' ? 'متاح' : 'Active') : ($ride->status === 'maintenance' ? ( app()->getLocale() === 'ar' ? 'صيانة' : 'Maint.') : ( app()->getLocale() === 'ar' ? 'مشغول' : 'Busy')) }}
                    </span>
                </div>
                <div class="rc-desc">{{ Str::limit($ride->description, 70) }}</div>
                <div>
                    @if($ride->min_age) <span class="rc-tag">{{ app()->getLocale() === 'ar' ? 'العمر: ' : 'Age: ' }}{{ $ride->min_age }}+</span> @endif
                    @if($ride->min_height) <span class="rc-tag">{{ $ride->min_height }}cm+</span> @endif
                    @if($ride->capacity) <span class="rc-tag">{{ $ride->capacity }} {{ app()->getLocale() === 'ar' ? 'شخص' : 'pax' }}</span> @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Events section --}}
@if($events->count())
<div style="background:var(--white);padding:36px 32px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <div style="font-size:10px;color:var(--gold);letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">🎭 {{ app()->getLocale() === 'ar' ? 'الفعاليات' : 'Events' }}</div>
            <h2 class="section-title" style="margin-bottom:0;">{{ app()->getLocale() === 'ar' ? 'الفعاليات القادمة' : 'Upcoming Events' }}</h2>
        </div>
        <a href="{{ route('events') }}" class="btn-pk-outline">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}</a>
    </div>
    <div class="row g-3">
        @foreach($events->take(3) as $event)
        <div class="col-md-4">
            <div class="event-card">
                <div class="ec-top">
                    <div class="ec-icon">🎭</div>
                    <div class="ec-name">{{ $event->title }}</div>
                    <div class="ec-venue">📍 {{ $event->location }}</div>
                </div>
                <div class="ec-body">
                    <div class="ec-date">📅 {{ $event->event_date->format('d M Y') }} · {{ $event->start_time }}</div>
                    <div class="ec-desc">{{ Str::limit($event->description, 100) }}</div>
                    <div style="margin-top:12px;">
                        <a href="{{ (auth()->check() && auth()->user()->role === 'visitor') ? route('visitor.bookings.create') : route('register') }}" class="btn-pk-primary" style="font-size:11px;padding:6px 16px;">{{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- CTA --}}
@if(!auth()->check() || auth()->user()->role === 'visitor')
<div class="pk-cta">
    <h2>{{ app()->getLocale() === 'ar' ? 'لا تفوّت المتعة!' : "Don't Miss the Fun!" }}</h2>
    <p>{{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن واستمتع بيوم لا يُنسى في مدينة غرين سيتي الترفيهية' : 'Book your ticket now and enjoy an unforgettable day at Green City Entertainment Park' }}</p>
    <a href="{{ (auth()->check() && auth()->user()->role === 'visitor') ? route('visitor.bookings.create') : route('register') }}" class="btn-pk-primary">
        🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن' : 'Book Tickets Now' }}
    </a>
</div>
@endif

@endsection
