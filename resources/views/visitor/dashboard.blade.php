@extends('layouts.dashboard')
@section('title', __('messages.dashboard'))

@section('content')
<div class="pk-page-header">
    <div>
        <h1>{{ app()->getLocale() === 'ar' ? 'مرحباً، ' . auth()->user()->name : 'Welcome, ' . auth()->user()->name }}</h1>
        <div class="subtitle">{{ app()->getLocale() === 'ar' ? 'بوابة الزائر — حديقة جرين سيتي الترفيهية' : 'Visitor Portal — Green City Entertainment Park' }}</div>
    </div>
    <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">
        🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرة جديدة' : 'Book New Ticket' }}
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ __('messages.total_bookings') }}</div>
            <div class="mc-val">{{ $stats['total_bookings'] }}</div>
            <div class="mc-trend">{{ app()->getLocale() === 'ar' ? 'إجمالي حجوزاتي' : 'Total my bookings' }}</div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ __('messages.confirmed_bookings') }}</div>
            <div class="mc-val green">{{ $stats['confirmed'] }}</div>
            <div class="mc-trend">{{ app()->getLocale() === 'ar' ? 'حجوزات مؤكدة' : 'Confirmed bookings' }}</div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}</div>
            <div class="mc-val navy">{{ $stats['pending'] }}</div>
            <div class="mc-trend warn">{{ app()->getLocale() === 'ar' ? 'في انتظار التأكيد' : 'Awaiting confirmation' }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Notifications --}}
    <div class="col-lg-5">
        @if($notifications->count())
        <div class="dash-panel">
            <div class="dash-panel-header">
                🔔 {{ __('messages.notifications') }}
                <a href="{{ route('visitor.notifications.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }} →</a>
            </div>
            <div class="dash-panel-body">
                @foreach($notifications->take(5) as $notif)
                <div class="notif-item">
                    <strong>{{ app()->getLocale() === 'ar' ? $notif->title_ar : $notif->title_en }}</strong>
                    <div>{{ app()->getLocale() === 'ar' ? $notif->body_ar : $notif->body_en }}</div>
                    <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Active Promotion --}}
        <div class="dash-panel">
            <div class="dash-panel-header">🏷️ {{ app()->getLocale() === 'ar' ? 'عروض نشطة' : 'Active Promotions' }}</div>
            <div class="dash-panel-body">
                @php
                    $promos = \App\Models\Promotion::where('is_active', true)->where('valid_until', '>=', now())->get();
                @endphp
                @forelse($promos as $promo)
                <div class="promo-box" style="margin-bottom:8px;">
                    <div class="promo-pct" style="font-size:20px;">{{ $promo->discount_type === 'percentage' ? $promo->discount_value . '% OFF' : number_format($promo->discount_value) . ' YER OFF' }}</div>
                    <div class="promo-code">{{ $promo->code }}</div>
                    <div class="promo-exp">{{ app()->getLocale() === 'ar' ? 'صالح حتى' : 'Until' }} {{ $promo->valid_until->format('d M Y') }}</div>
                </div>
                @empty
                <div style="text-align:center;color:var(--text-muted);font-size:12px;padding:12px 0;">{{ __('messages.no_data') }}</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="col-lg-7">
        <div class="dash-panel">
            <div class="dash-panel-header">
                📅 {{ __('messages.bookings') }}
                <a href="{{ route('visitor.bookings.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }} →</a>
            </div>
            @forelse($bookings as $booking)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 14px;border-bottom:1px solid var(--border);">
                <div>
                    <div style="font-size:12px;font-weight:700;color:var(--text-dark);">
                        #{{ $booking->id }} — {{ __('messages.' . $booking->ticket_type . '_ticket') }}
                    </div>
                    <div style="font-size:10px;color:var(--text-muted);">
                        📅 {{ $booking->visit_date->format('d M Y') }} · {{ $booking->quantity }} {{ app()->getLocale() === 'ar' ? 'تذاكر' : 'tickets' }}
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:12px;font-weight:700;color:var(--gold);">{{ number_format($booking->total_price) }} {{ __('messages.yer') }}</div>
                    <span class="badge-{{ $booking->status }}">{{ __('messages.' . $booking->status) }}</span>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:30px;color:var(--text-muted);">
                <div style="font-size:32px;margin-bottom:8px;">🎫</div>
                <div style="font-size:13px;margin-bottom:10px;">{{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات بعد' : 'No bookings yet' }}</div>
                <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary" style="font-size:12px;padding:8px 20px;">{{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الأولى' : 'Book Your First Ticket' }}</a>
            </div>
            @endforelse
        </div>

        {{-- My Tickets --}}
        @php
            $myTickets = \App\Models\Ticket::whereHas('booking', fn($q) => $q->where('user_id', auth()->id()))->with('booking')->latest()->take(4)->get();
        @endphp
        @if($myTickets->count())
        <div class="dash-panel">
            <div class="dash-panel-header">
                🎟️ {{ __('messages.tickets') }}
                <a href="{{ route('visitor.tickets.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }} →</a>
            </div>
            <div class="dash-panel-body">
                <div class="row g-2">
                    @foreach($myTickets as $ticket)
                    <div class="col-md-6">
                        <div style="border:2px solid {{ $ticket->is_used ? 'var(--border)' : 'var(--gold)' }};border-radius:8px;padding:10px;text-align:center;background:{{ $ticket->is_used ? 'var(--cream-light)' : 'var(--gold-pale)' }};">
                            <div style="font-family:monospace;font-size:11px;font-weight:700;color:var(--navy);">{{ $ticket->qr_code }}</div>
                            <div style="font-size:10px;color:var(--text-muted);margin-top:3px;">{{ $ticket->booking->visit_date->format('d M Y') }}</div>
                            <span class="{{ $ticket->is_used ? 'badge-cancelled' : 'badge-confirmed' }}" style="margin-top:5px;display:inline-block;">
                                {{ $ticket->is_used ? ( app()->getLocale() === 'ar' ? 'مستخدمة' : 'Used') : ( app()->getLocale() === 'ar' ? 'صالحة' : 'Valid') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
