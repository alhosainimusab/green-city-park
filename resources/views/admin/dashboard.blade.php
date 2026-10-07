@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'لوحة الإدارة' : 'Admin Dashboard')

@section('content')
<div class="pk-page-header">
    <div>
        <h1>{{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard Overview' }}</h1>
        <div class="subtitle">{{ app()->getLocale() === 'ar' ? 'نظرة عامة على نظام الإدارة' : 'System-wide analytics and management' }}</div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
        <div class="user-avatar" style="width:34px;height:34px;font-size:14px;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div style="font-size:12px;font-weight:600;color:var(--text-dark);">{{ auth()->user()->name }}</div>
            <div style="font-size:10px;color:var(--text-muted);">Green City Park</div>
        </div>
    </div>
</div>

{{-- 4 Metrics --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'التذاكر المباعة' : 'Tickets Sold' }}</div>
            <div class="mc-val">{{ $stats['confirmed_bookings'] }}</div>
            <div class="mc-trend">↑ {{ app()->getLocale() === 'ar' ? 'هذا الأسبوع' : 'this week' }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'الإيرادات (ر.ي)' : 'Revenue (YER)' }}</div>
            <div class="mc-val">{{ number_format($stats['total_revenue'] / 1000, 0) }}K</div>
            <div class="mc-trend">↑ +8% {{ app()->getLocale() === 'ar' ? 'هذا الأسبوع' : 'this week' }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'الألعاب النشطة' : 'Active Rides' }}</div>
            <div class="mc-val green">{{ $stats['active_rides'] }}/{{ $stats['total_rides'] }}</div>
            <div class="mc-trend warn">{{ $stats['total_rides'] - $stats['active_rides'] }} {{ app()->getLocale() === 'ar' ? 'تحت الصيانة' : 'under maintenance' }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'الفعاليات القادمة' : 'Upcoming Events' }}</div>
            <div class="mc-val navy">{{ $stats['upcoming_events'] }}</div>
            @php $nextEvent = \App\Models\Event::where('is_active', true)->where('event_date', '>=', now())->orderBy('event_date')->first(); @endphp
            <div class="mc-trend">{{ $nextEvent ? 'Next: ' . $nextEvent->event_date->format('d M') : '—' }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Pending Payments --}}
    <div class="col-lg-7">
        <div class="dash-panel">
            <div class="dash-panel-header">
                {{ app()->getLocale() === 'ar' ? 'التحقق من الدفعات المعلقة' : 'Pending Payment Verification' }}
                <a href="{{ route('admin.bookings.index') }}?status=pending" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} →</a>
            </div>
            <div class="dash-panel-body">
                @forelse($recentBookings->where('status', 'pending')->take(5) as $booking)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-size:12px;font-weight:600;color:var(--text-dark);">{{ $booking->user->name }}</div>
                        <div style="font-size:9px;color:var(--text-muted);">{{ $booking->payment ? $booking->payment->reference_no : '—' }}</div>
                    </div>
                    <div style="font-size:12px;font-weight:700;color:var(--gold);margin:0 12px;">{{ number_format($booking->total_price) }} YER</div>
                    <div style="display:flex;gap:5px;">
                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-pk-sm btn-pk-green">✓ {{ app()->getLocale() === 'ar' ? 'تأكيد' : 'Confirm' }}</button>
                        </form>
                        <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-pk-sm btn-pk-red">✗ {{ app()->getLocale() === 'ar' ? 'رفض' : 'Reject' }}</button>
                        </form>
                    </div>
                </div>
                @empty
                <div style="text-align:center;color:var(--text-muted);font-size:12px;padding:16px 0;">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات معلقة' : 'No pending bookings' }}
                </div>
                @endforelse

                {{-- Broadcast notification --}}
                <div style="background:var(--cream-light);border-radius:7px;padding:11px;margin-top:12px;">
                    <div style="font-size:10px;font-weight:700;color:var(--text-dark);margin-bottom:7px;">🔔 {{ app()->getLocale() === 'ar' ? 'إرسال إشعار لجميع الزوار' : 'Broadcast Notification to All Visitors' }}</div>
                    <form action="{{ route('admin.notifications.store') }}" method="POST" style="display:flex;gap:7px;">
                        @csrf
                        <input type="hidden" name="title_en" value="Park Announcement">
                        <input type="hidden" name="title_ar" value="إعلان من الحديقة">
                        <input type="hidden" name="type" value="info">
                        <input type="hidden" name="target" value="all">
                        <input name="body_en" id="bc-msg-en" class="pk-input" style="flex:1;" placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل رسالة للزوار...' : 'Enter message for all visitors...' }}">
                        <input type="hidden" name="body_ar" id="bc-msg-ar" value="">
                        <button type="submit" class="btn-pk-sm btn-pk-gold" style="padding:6px 14px;white-space:nowrap;" onclick="document.getElementById('bc-msg-ar').value=document.getElementById('bc-msg-en').value;">
                            {{ app()->getLocale() === 'ar' ? 'إرسال' : 'Send' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Recent Bookings Table --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                {{ app()->getLocale() === 'ar' ? 'آخر الحجوزات' : 'Recent Bookings' }}
                <a href="{{ route('admin.bookings.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="pk-table">
                    <thead><tr>
                        <th>#</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'الزائر' : 'Visitor' }}</th>
                        <th>{{ __('messages.ticket_type') }}</th>
                        <th>{{ __('messages.total') }}</th>
                        <th>{{ __('messages.status') }}</th>
                    </tr></thead>
                    <tbody>
                        @forelse($recentBookings->take(8) as $booking)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $booking->id) }}" style="color:var(--gold);font-weight:700;">#{{ $booking->id }}</a></td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ __('messages.' . $booking->ticket_type . '_ticket') }}</td>
                            <td style="font-weight:700;">{{ number_format($booking->total_price) }}</td>
                            <td><span class="badge-{{ $booking->status }}">{{ __('messages.' . $booking->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:20px;">{{ __('messages.no_data') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right column --}}
    <div class="col-lg-5">
        {{-- Ride Status Management --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                {{ app()->getLocale() === 'ar' ? 'إدارة حالة الألعاب' : 'Ride Status Management' }}
                <a href="{{ route('admin.rides.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} →</a>
            </div>
            <div class="dash-panel-body">
                @foreach(\App\Models\Ride::take(5)->get() as $ride)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-size:11px;font-weight:600;color:var(--text-dark);">{{ $ride->name }}</div>
                        <div style="font-size:9px;color:var(--text-muted);">{{ $ride->category }}</div>
                    </div>
                    <span class="badge-{{ $ride->status === 'active' ? 'available' : ($ride->status === 'maintenance' ? 'maintenance' : 'busy') }}" style="font-size:9px;">
                        {{ $ride->status === 'active' ? ( app()->getLocale() === 'ar' ? 'متاح' : 'Available') : ($ride->status === 'maintenance' ? ( app()->getLocale() === 'ar' ? 'صيانة' : 'Maint.') : ( app()->getLocale() === 'ar' ? 'مشغول' : 'Busy')) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Ride Popularity --}}
        <div class="dash-panel">
            <div class="dash-panel-header">{{ app()->getLocale() === 'ar' ? 'شعبية الألعاب' : 'Ride Popularity' }}</div>
            <div class="dash-panel-body">
                @php
                    $topRides = \App\Models\Ride::withCount(['statusLogs as pop_count'])->take(5)->get()->sortByDesc('capacity');
                    $maxCap = $topRides->max('capacity') ?: 1;
                @endphp
                @foreach($topRides as $ride)
                <div style="margin-bottom:9px;">
                    <div style="display:flex;justify-content:space-between;font-size:10px;margin-bottom:3px;">
                        <span style="color:var(--text-muted);">{{ $ride->name }}</span>
                        <span style="color:var(--gold);font-weight:700;">{{ $ride->capacity }}</span>
                    </div>
                    <div class="pk-bar-bg">
                        <div class="pk-bar-fill" style="width:{{ $maxCap > 0 ? round($ride->capacity / $maxCap * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="dash-panel">
            <div class="dash-panel-header">{{ app()->getLocale() === 'ar' ? 'ملخص' : 'Quick Summary' }}</div>
            <div class="dash-panel-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div style="text-align:center;padding:10px;background:var(--cream-light);border-radius:8px;">
                        <div style="font-family:'Playfair Display',serif;font-size:18px;color:var(--gold);font-weight:700;">{{ $stats['total_visitors'] }}</div>
                        <div style="font-size:9px;color:var(--text-muted);text-transform:uppercase;margin-top:2px;">{{ app()->getLocale() === 'ar' ? 'إجمالي الزوار' : 'Total Visitors' }}</div>
                    </div>
                    <div style="text-align:center;padding:10px;background:var(--cream-light);border-radius:8px;">
                        <div style="font-family:'Playfair Display',serif;font-size:18px;color:var(--green);font-weight:700;">{{ $stats['total_bookings'] }}</div>
                        <div style="font-size:9px;color:var(--text-muted);text-transform:uppercase;margin-top:2px;">{{ app()->getLocale() === 'ar' ? 'إجمالي الحجوزات' : 'Total Bookings' }}</div>
                    </div>
                    <div style="text-align:center;padding:10px;background:var(--cream-light);border-radius:8px;">
                        <div style="font-family:'Playfair Display',serif;font-size:18px;color:var(--navy);font-weight:700;">{{ $stats['pending_bookings'] }}</div>
                        <div style="font-size:9px;color:var(--text-muted);text-transform:uppercase;margin-top:2px;">{{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}</div>
                    </div>
                    <div style="text-align:center;padding:10px;background:var(--cream-light);border-radius:8px;">
                        <div style="font-family:'Playfair Display',serif;font-size:18px;color:var(--gold);font-weight:700;">{{ \App\Models\Promotion::where('is_active', true)->count() }}</div>
                        <div style="font-size:9px;color:var(--text-muted);text-transform:uppercase;margin-top:2px;">{{ app()->getLocale() === 'ar' ? 'عروض نشطة' : 'Active Promos' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ticket Sales + Revenue --}}
<div class="row g-4 mt-1">
    <div class="col-md-4">
        <div class="dash-panel">
            <div class="dash-panel-header">{{ app()->getLocale() === 'ar' ? 'توزيع التذاكر' : 'Ticket Sales' }}</div>
            <div class="dash-panel-body">
                @foreach($ticketTypeStats as $stat)
                <div style="margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:4px;">
                        <span style="font-weight:600;">{{ __('messages.' . $stat->ticket_type . '_ticket') }}</span>
                        <span style="color:var(--text-muted);">{{ $stat->count }}</span>
                    </div>
                    @php $total = $ticketTypeStats->sum('count'); $pct = $total > 0 ? round($stat->count / $total * 100) : 0; @endphp
                    <div class="pk-bar-bg">
                        <div class="pk-bar-fill" style="width:{{ $pct }}%;background:{{ ['adult'=>'var(--green)','child'=>'var(--gold)','group'=>'var(--navy)'][$stat->ticket_type] ?? 'var(--border)' }};"></div>
                    </div>
                    <div style="font-size:10px;color:var(--text-muted);margin-top:2px;">{{ number_format($stat->revenue) }} {{ __('messages.yer') }}</div>
                </div>
                @endforeach
                @if($ticketTypeStats->isEmpty())
                <div style="text-align:center;color:var(--text-muted);padding:14px 0;font-size:12px;">{{ __('messages.no_data') }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="dash-panel">
            <div class="dash-panel-header">
                {{ app()->getLocale() === 'ar' ? 'آخر النشاطات' : 'Recent Activity' }}
                <a href="{{ route('admin.reports.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'التقارير الكاملة' : 'Full Reports' }} →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="pk-table">
                    <thead><tr>
                        <th>{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'الزائر' : 'Visitor' }}</th>
                        <th>{{ __('messages.quantity') }}</th>
                        <th>{{ __('messages.total') }} (YER)</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr></thead>
                    <tbody>
                        @forelse($recentBookings->take(6) as $b)
                        <tr>
                            <td>{{ $b->visit_date->format('d M Y') }}</td>
                            <td>{{ $b->user->name }}</td>
                            <td>{{ $b->quantity }}</td>
                            <td style="font-weight:700;color:var(--gold);">{{ number_format($b->total_price) }}</td>
                            <td><span class="badge-{{ $b->status }}">{{ __('messages.' . $b->status) }}</span></td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn-pk-sm btn-pk-outline-sm">{{ app()->getLocale() === 'ar' ? 'عرض' : 'View' }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:16px;">{{ __('messages.no_data') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
