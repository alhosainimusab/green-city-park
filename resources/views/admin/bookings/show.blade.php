@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تفاصيل الحجز' : 'Booking Details')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <a href="{{ route('admin.bookings.index') }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة للحجوزات' : 'Back to Bookings' }}
    </a>
    @if($booking->status === 'pending')
    <div style="display:flex;gap:10px;">
        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
            @csrf
            <button class="btn-pk-primary" style="background:var(--green);border-color:var(--green);">
                <i class="fas fa-check"></i>
                {{ app()->getLocale() === 'ar' ? 'تأكيد الحجز' : 'Confirm Booking' }}
            </button>
        </form>
        <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST"
              onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'رفض هذا الحجز؟' : 'Reject?' }}')">
            @csrf
            <button style="padding:10px 20px;border:1px solid #dc3545;background:transparent;color:#dc3545;border-radius:8px;cursor:pointer;">
                {{ app()->getLocale() === 'ar' ? 'رفض' : 'Reject' }}
            </button>
        </form>
    </div>
    @endif
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="dash-panel">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
                <h3 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0;font-size:1.2rem;">
                    {{ app()->getLocale() === 'ar' ? 'حجز' : 'Booking' }} #{{ $booking->id }}
                </h3>
                <span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </div>

            <table style="width:100%;border-collapse:collapse;font-size:.9rem;">
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;width:40%;">{{ app()->getLocale() === 'ar' ? 'الزائر' : 'Visitor' }}</td>
                    <td style="padding:10px 0;font-weight:600;color:var(--navy);">{{ $booking->user->name }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}</td>
                    <td style="padding:10px 0;color:#666;">{{ $booking->user->email }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</td>
                    <td style="padding:10px 0;font-weight:600;color:var(--navy);">{{ $booking->visit_date->format('d M Y') }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'نوع التذكرة' : 'Ticket Type' }}</td>
                    <td style="padding:10px 0;font-weight:600;color:var(--navy);">{{ ucfirst($booking->ticket_type) }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'الكمية' : 'Quantity' }}</td>
                    <td style="padding:10px 0;font-weight:600;color:var(--navy);">{{ $booking->quantity }}</td>
                </tr>
                @if($booking->discount_amount > 0)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'الخصم' : 'Discount' }}</td>
                    <td style="padding:10px 0;color:var(--green);font-weight:600;">-{{ number_format($booking->discount_amount) }}</td>
                </tr>
                @endif
                <tr>
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'المجموع' : 'Total' }}</td>
                    <td style="padding:10px 0;color:var(--gold);font-weight:800;font-size:1.2rem;">{{ number_format($booking->total_price) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dash-panel" style="margin-bottom:16px;">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                <i class="fas fa-receipt" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'الدفع' : 'Payment' }}
            </h4>
            @if($booking->payment)
            <table style="width:100%;border-collapse:collapse;font-size:.9rem;">
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'الطريقة' : 'Method' }}</td>
                    <td style="padding:10px 0;font-weight:600;color:var(--navy);">
                        {{ $booking->payment->payment_method === 'exchange_transfer' ? 'Transfer' : 'Cash at Gate' }}
                    </td>
                </tr>
                @if($booking->payment->reference_no)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">Reference</td>
                    <td style="padding:10px 0;font-family:monospace;font-weight:700;color:var(--navy);">{{ $booking->payment->reference_no }}</td>
                </tr>
                @endif
                <tr>
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</td>
                    <td style="padding:10px 0;"><span class="badge-{{ $booking->payment->status }}">{{ ucfirst($booking->payment->status) }}</span></td>
                </tr>
            </table>
            @else
            <p style="color:#bbb;font-size:.9rem;">{{ app()->getLocale() === 'ar' ? 'لم يتم الدفع بعد' : 'No payment submitted' }}</p>
            @endif
        </div>

        @if($booking->tickets->count())
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 12px;font-size:1.1rem;">
                <i class="fas fa-qrcode" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'التذاكر' : 'Tickets' }} ({{ $booking->tickets->count() }})
            </h4>
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:8px;">
                @foreach($booking->tickets as $ticket)
                <div style="background:{{ $ticket->is_used ? '#f5f5f5' : 'var(--cream-light)' }};border:1px solid {{ $ticket->is_used ? '#ddd' : 'var(--border)' }};border-radius:8px;padding:10px;text-align:center;">
                    <div style="font-family:monospace;font-size:.72rem;color:#999;margin-bottom:4px;">{{ $ticket->qr_code }}</div>
                    <span class="{{ $ticket->is_used ? 'badge-cancelled' : 'badge-confirmed' }}" style="font-size:.7rem;">
                        {{ $ticket->is_used ? (app()->getLocale() === 'ar' ? 'مستخدمة' : 'Used') : (app()->getLocale() === 'ar' ? 'صالحة' : 'Valid') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
