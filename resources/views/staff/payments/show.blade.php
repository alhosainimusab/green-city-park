@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تفاصيل الدفع' : 'Payment Details')
@section('content')

<div style="margin-bottom:20px;">
    <a href="{{ route('staff.payments.index') }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة للمدفوعات' : 'Back to Payments' }}
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="dash-panel">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0;font-size:1.3rem;">
                    {{ app()->getLocale() === 'ar' ? 'دفعة' : 'Payment' }} #{{ $payment->id }}
                </h3>
                <span class="badge-{{ $payment->status }}">
                    @if($payment->status === 'pending') {{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}
                    @elseif($payment->status === 'verified') {{ app()->getLocale() === 'ar' ? 'تم التحقق' : 'Verified' }}
                    @else {{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}
                    @endif
                </span>
            </div>

            <table style="width:100%;border-collapse:collapse;">
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;width:40%;">{{ app()->getLocale() === 'ar' ? 'الزائر' : 'Visitor' }}</td>
                    <td style="padding:12px 0;color:var(--navy);font-weight:600;">{{ $payment->booking->user->name }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Method' }}</td>
                    <td style="padding:12px 0;color:var(--navy);font-weight:600;">
                        {{ $payment->payment_method === 'exchange_transfer'
                            ? (app()->getLocale() === 'ar' ? 'تحويل عبر الصرافة' : 'Exchange Transfer')
                            : (app()->getLocale() === 'ar' ? 'دفع عند البوابة' : 'Cash at Gate') }}
                    </td>
                </tr>
                @if($payment->reference_no)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'رقم المرجع' : 'Reference No.' }}</td>
                    <td style="padding:12px 0;font-family:monospace;color:var(--navy);font-weight:700;font-size:1.05rem;">{{ $payment->reference_no }}</td>
                </tr>
                @endif
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'المبلغ' : 'Amount' }}</td>
                    <td style="padding:12px 0;color:var(--gold);font-weight:800;font-size:1.3rem;">
                        {{ number_format($payment->amount) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</td>
                    <td style="padding:12px 0;color:var(--navy);">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>

            @if($payment->status === 'pending')
            <div style="display:flex;gap:12px;margin-top:24px;">
                <form action="{{ route('staff.payments.verify', $payment->id) }}" method="POST" style="flex:1;">
                    @csrf
                    <button class="btn-pk-primary" style="width:100%;justify-content:center;background:var(--green);border-color:var(--green);">
                        <i class="fas fa-check"></i>
                        {{ app()->getLocale() === 'ar' ? 'تحقق من الدفع' : 'Verify Payment' }}
                    </button>
                </form>
                <form action="{{ route('staff.payments.reject', $payment->id) }}" method="POST" style="flex:1;"
                      onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'رفض هذا الدفع؟' : 'Reject this payment?' }}')">
                    @csrf
                    <button style="width:100%;padding:12px;border:1px solid #dc3545;background:transparent;color:#dc3545;border-radius:8px;cursor:pointer;font-size:.9rem;">
                        <i class="fas fa-times" style="margin-inline-end:6px;"></i>
                        {{ app()->getLocale() === 'ar' ? 'رفض' : 'Reject' }}
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                <i class="fas fa-calendar-check" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'تفاصيل الحجز' : 'Booking Details' }}
            </h4>
            <table style="width:100%;border-collapse:collapse;">
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'رقم الحجز' : 'Booking' }}</td>
                    <td style="padding:10px 0;color:var(--navy);font-weight:600;">#{{ $payment->booking->id }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</td>
                    <td style="padding:10px 0;color:var(--navy);font-weight:600;">{{ $payment->booking->visit_date->format('d M Y') }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'نوع التذكرة' : 'Ticket Type' }}</td>
                    <td style="padding:10px 0;color:var(--navy);font-weight:600;">{{ ucfirst($payment->booking->ticket_type) }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'الكمية' : 'Quantity' }}</td>
                    <td style="padding:10px 0;color:var(--navy);font-weight:600;">{{ $payment->booking->quantity }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'حالة الحجز' : 'Booking Status' }}</td>
                    <td style="padding:10px 0;">
                        <span class="badge-{{ $payment->booking->status }}">
                            {{ ucfirst($payment->booking->status) }}
                        </span>
                    </td>
                </tr>
            </table>

            @if($payment->booking->tickets->isNotEmpty())
            <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                <div style="font-size:.85rem;color:#888;margin-bottom:12px;">
                    <i class="fas fa-qrcode" style="margin-inline-end:4px;"></i>
                    {{ count($payment->booking->tickets) }} {{ app()->getLocale() === 'ar' ? 'تذكرة مرتبطة' : 'linked ticket(s)' }}
                </div>
                @foreach($payment->booking->tickets->take(3) as $ticket)
                <div style="font-family:monospace;font-size:.75rem;color:#bbb;background:var(--cream-light);padding:6px 10px;border-radius:6px;margin-bottom:6px;">
                    {{ $ticket->qr_code }}
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
