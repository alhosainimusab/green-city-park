@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'لوحة الموظف' : 'Staff Dashboard')

@section('content')
<div class="pk-page-header">
    <div>
        <h1>{{ app()->getLocale() === 'ar' ? 'لوحة الموظف' : 'Staff Dashboard' }}</h1>
        <div class="subtitle">{{ app()->getLocale() === 'ar' ? 'إدارة العمليات والدفعات والألعاب' : 'Manage operations, payments, and ride status' }}</div>
    </div>
    <a href="{{ route('staff.tickets.scan') }}" class="btn-pk-primary">
        📷 {{ app()->getLocale() === 'ar' ? 'مسح تذكرة' : 'Scan Ticket' }}
    </a>
</div>

{{-- Metrics --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'مدفوعات معلقة' : 'Pending Payments' }}</div>
            <div class="mc-val">{{ $stats['pending_payments'] }}</div>
            <div class="mc-trend warn">{{ app()->getLocale() === 'ar' ? 'تحتاج تحقق' : 'Need verification' }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'زيارات اليوم' : "Today's Visits" }}</div>
            <div class="mc-val green">{{ $stats['today_bookings'] }}</div>
            <div class="mc-trend">{{ app()->getLocale() === 'ar' ? 'حجز اليوم' : 'bookings today' }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'ألعاب نشطة' : 'Active Rides' }}</div>
            <div class="mc-val green">{{ $stats['active_rides'] }}</div>
            <div class="mc-trend">{{ app()->getLocale() === 'ar' ? 'متاحة للزوار' : 'available' }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="metric-card">
            <div class="mc-lbl">{{ app()->getLocale() === 'ar' ? 'تحت الصيانة' : 'Maintenance' }}</div>
            <div class="mc-val navy">{{ $stats['rides_maintenance'] }}</div>
            <div class="mc-trend warn">{{ app()->getLocale() === 'ar' ? 'ألعاب متوقفة' : 'rides offline' }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Pending Payments --}}
    <div class="col-lg-6">
        <div class="dash-panel">
            <div class="dash-panel-header">
                💳 {{ app()->getLocale() === 'ar' ? 'مدفوعات معلقة للتحقق' : 'Pending Payments to Verify' }}
                <a href="{{ route('staff.payments.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} →</a>
            </div>
            @forelse($pendingPayments as $payment)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 14px;border-bottom:1px solid var(--border);">
                <div>
                    <div style="font-size:12px;font-weight:700;color:var(--text-dark);">{{ $payment->booking->user->name }}</div>
                    <div style="font-size:10px;color:var(--text-muted);">{{ __('messages.' . $payment->payment_method) }} · {{ $payment->reference_no }}</div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:12px;font-weight:700;color:var(--gold);">{{ number_format($payment->amount) }} YER</span>
                    <a href="{{ route('staff.payments.show', $payment->id) }}" class="btn-pk-sm btn-pk-gold">{{ app()->getLocale() === 'ar' ? 'تحقق' : 'Verify' }}</a>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:24px;color:var(--text-muted);font-size:12px;">
                ✓ {{ app()->getLocale() === 'ar' ? 'لا توجد مدفوعات معلقة' : 'No pending payments' }}
            </div>
            @endforelse
        </div>
    </div>

    {{-- Scan Ticket --}}
    <div class="col-lg-6">
        <div class="dash-panel">
            <div class="dash-panel-header">📷 {{ app()->getLocale() === 'ar' ? 'مسح التذاكر' : 'Ticket Scanner' }}</div>
            <div style="text-align:center;padding:30px 20px;">
                <div style="font-size:52px;margin-bottom:12px;">📷</div>
                <div style="font-size:13px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">
                    {{ app()->getLocale() === 'ar' ? 'مسح تذاكر الزوار' : 'Scan Visitor Tickets' }}
                </div>
                <div style="font-size:11px;color:var(--text-muted);margin-bottom:18px;line-height:1.6;">
                    {{ app()->getLocale() === 'ar' ? 'امسح رمز QR للتذكرة للتحقق من صحتها عند بوابة الدخول' : 'Scan ticket QR code to verify it at the entrance gate' }}
                </div>
                <a href="{{ route('staff.tickets.scan') }}" class="btn-pk-primary" style="padding:12px 28px;font-size:13px;">
                    📷 {{ app()->getLocale() === 'ar' ? 'فتح الماسح' : 'Open Scanner' }}
                </a>
            </div>
        </div>

        {{-- Ride Status Summary --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                🎡 {{ app()->getLocale() === 'ar' ? 'حالة الألعاب' : 'Ride Status' }}
                <a href="{{ route('staff.rides.index') }}" class="view-all">{{ app()->getLocale() === 'ar' ? 'إدارة الكل' : 'Manage all' }} →</a>
            </div>
            <div class="dash-panel-body">
                @foreach(\App\Models\Ride::take(6)->get() as $ride)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-size:11px;font-weight:600;color:var(--text-dark);">{{ $ride->name }}</div>
                        <div style="font-size:9px;color:var(--text-muted);">{{ $ride->category }}</div>
                    </div>
                    <span class="badge-{{ $ride->status === 'active' ? 'available' : ($ride->status === 'maintenance' ? 'maintenance' : 'busy') }}" style="font-size:9px;">
                        {{ $ride->status === 'active' ? ( app()->getLocale() === 'ar' ? 'متاح' : 'Active') : ($ride->status === 'maintenance' ? ( app()->getLocale() === 'ar' ? 'صيانة' : 'Maint.') : ( app()->getLocale() === 'ar' ? 'مشغول' : 'Busy')) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
