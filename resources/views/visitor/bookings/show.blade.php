@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تفاصيل الحجز' : 'Booking Details')
@section('content')

<div style="margin-bottom:20px;">
    <a href="{{ route('visitor.bookings.index') }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة للحجوزات' : 'Back to Bookings' }}
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="dash-panel" style="margin-bottom:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0;font-size:1.3rem;">
                    {{ app()->getLocale() === 'ar' ? 'حجز رقم' : 'Booking' }} #{{ $booking->id }}
                </h3>
                <span class="badge-{{ $booking->status }}">
                    @if($booking->status === 'pending') {{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}
                    @elseif($booking->status === 'confirmed') {{ app()->getLocale() === 'ar' ? 'مؤكد' : 'Confirmed' }}
                    @elseif($booking->status === 'rejected') {{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}
                    @else {{ app()->getLocale() === 'ar' ? 'ملغي' : 'Cancelled' }}
                    @endif
                </span>
            </div>

            <table style="width:100%;border-collapse:collapse;">
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;width:40%;">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</td>
                    <td style="padding:12px 0;color:var(--navy);font-weight:600;">{{ $booking->visit_date->format('d M Y, l') }}</td>
                </tr>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;vertical-align:top;">{{ app()->getLocale() === 'ar' ? 'التذاكر' : 'Tickets' }}</td>
                    <td style="padding:12px 0;color:var(--navy);">
                        @if($booking->hasBreakdown())
                            @if($booking->adult_qty > 0)
                            <div style="display:flex;justify-content:space-between;font-size:.88rem;margin-bottom:4px;">
                                <span>{{ app()->getLocale() === 'ar' ? 'بالغ' : 'Adult' }} × {{ $booking->adult_qty }}</span>
                                <span style="font-weight:600;">{{ number_format($booking->adult_qty * 1500) }} YER</span>
                            </div>
                            @endif
                            @if($booking->child_qty > 0)
                            <div style="display:flex;justify-content:space-between;font-size:.88rem;margin-bottom:4px;">
                                <span>{{ app()->getLocale() === 'ar' ? 'طفل' : 'Child' }} × {{ $booking->child_qty }}</span>
                                <span style="font-weight:600;">{{ number_format($booking->child_qty * 800) }} YER</span>
                            </div>
                            @endif
                            @if($booking->group_qty > 0)
                            <div style="display:flex;justify-content:space-between;font-size:.88rem;margin-bottom:4px;">
                                <span>{{ app()->getLocale() === 'ar' ? 'مجموعة' : 'Group' }} × {{ $booking->group_qty }}</span>
                                <span style="font-weight:600;">{{ number_format($booking->group_qty * 1200) }} YER</span>
                            </div>
                            @endif
                            @if($booking->infant_qty > 0)
                            <div style="display:flex;justify-content:space-between;font-size:.88rem;">
                                <span>{{ app()->getLocale() === 'ar' ? 'رضيع' : 'Infant' }} × {{ $booking->infant_qty }}</span>
                                <span style="font-weight:600;color:var(--green);">{{ app()->getLocale() === 'ar' ? 'مجاني' : 'Free' }}</span>
                            </div>
                            @endif
                        @else
                            <span style="font-weight:600;">{{ ucfirst($booking->ticket_type) }} × {{ $booking->quantity }}</span>
                        @endif
                    </td>
                </tr>
                @if($booking->discount_amount > 0)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'الخصم' : 'Discount' }}</td>
                    <td style="padding:12px 0;color:var(--green);font-weight:600;">
                        -{{ number_format($booking->discount_amount) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}
                        @if($booking->promotion)
                            <span style="font-size:.75rem;color:#888;">({{ $booking->promotion->code }})</span>
                        @endif
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding:12px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'المجموع' : 'Total' }}</td>
                    <td style="padding:12px 0;color:var(--gold);font-weight:800;font-size:1.2rem;">
                        {{ number_format($booking->total_price) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}
                    </td>
                </tr>
            </table>

            @if($booking->status === 'pending' && !$booking->payment)
            <div style="margin-top:20px;display:flex;gap:12px;flex-wrap:wrap;">
                <a href="{{ route('visitor.bookings.payment', $booking->id) }}" class="btn-pk-primary">
                    <i class="fas fa-money-bill-wave"></i>
                    {{ app()->getLocale() === 'ar' ? 'إتمام الدفع' : 'Complete Payment' }}
                </a>
                <form action="{{ route('visitor.bookings.cancel', $booking->id) }}" method="POST"
                      onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'إلغاء الحجز؟' : 'Cancel this booking?' }}')">
                    @csrf
                    <button style="padding:10px 20px;border:1px solid #dc3545;background:transparent;color:#dc3545;border-radius:8px;cursor:pointer;font-size:.9rem;">
                        {{ app()->getLocale() === 'ar' ? 'إلغاء الحجز' : 'Cancel Booking' }}
                    </button>
                </form>
            </div>
            @endif
        </div>

        @if($booking->payment)
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                <i class="fas fa-receipt" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'معلومات الدفع' : 'Payment Information' }}
            </h4>
            <table style="width:100%;border-collapse:collapse;">
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Method' }}</td>
                    <td style="padding:10px 0;color:var(--navy);font-weight:600;">
                        {{ $booking->payment->payment_method === 'exchange_transfer'
                            ? (app()->getLocale() === 'ar' ? 'تحويل عبر الصرافة' : 'Exchange Transfer')
                            : (app()->getLocale() === 'ar' ? 'دفع عند البوابة' : 'Cash at Gate') }}
                    </td>
                </tr>
                @if($booking->payment->reference_no)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'رقم المرجع' : 'Reference No.' }}</td>
                    <td style="padding:10px 0;font-family:monospace;color:var(--navy);font-weight:600;">{{ $booking->payment->reference_no }}</td>
                </tr>
                @endif
                <tr>
                    <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'حالة الدفع' : 'Status' }}</td>
                    <td style="padding:10px 0;">
                        <span class="badge-{{ $booking->payment->status }}">
                            @if($booking->payment->status === 'pending') {{ app()->getLocale() === 'ar' ? 'بانتظار التحقق' : 'Awaiting Verification' }}
                            @elseif($booking->payment->status === 'verified') {{ app()->getLocale() === 'ar' ? 'تم التحقق' : 'Verified' }}
                            @else {{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}
                            @endif
                        </span>
                    </td>
                </tr>
            </table>

            {{-- Resubmit form shown only when payment is rejected --}}
            @if($booking->payment->status === 'rejected')
            <div style="margin-top:20px;background:#fff8f8;border:1px solid #ffc9c9;border-radius:12px;padding:18px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:36px;height:36px;background:#dc354520;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-exclamation-triangle" style="color:#dc3545;font-size:.9rem;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;color:#dc3545;font-size:.95rem;">
                            {{ app()->getLocale() === 'ar' ? 'تم رفض الدفعة' : 'Payment Rejected' }}
                        </div>
                        <div style="font-size:.8rem;color:#888;">
                            {{ app()->getLocale() === 'ar' ? 'يرجى التحقق من رقم المرجع وإعادة الإرسال' : 'Please verify your reference number and resubmit' }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('visitor.bookings.resubmit', $booking->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:12px;">
                        <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'رقم مرجع التحويل الصحيح *' : 'Correct Transfer Reference Number *' }}</label>
                        <input type="text" name="reference_no" class="pk-input"
                               placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: TRF-20260615-XXXX' : 'e.g. TRF-20260615-XXXX' }}"
                               value="{{ old('reference_no', $booking->payment->reference_no) }}" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</label>
                        <select name="payment_method" class="pk-input">
                            <option value="exchange_transfer" {{ $booking->payment->payment_method === 'exchange_transfer' ? 'selected' : '' }}>
                                {{ __('messages.exchange_transfer') }}
                            </option>
                            <option value="cash_at_gate" {{ $booking->payment->payment_method === 'cash_at_gate' ? 'selected' : '' }}>
                                {{ __('messages.cash_at_gate') }}
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn-pk-primary" style="width:100%;justify-content:center;padding:11px;">
                        <i class="fas fa-paper-plane"></i>
                        {{ app()->getLocale() === 'ar' ? 'إعادة إرسال الدفعة' : 'Resubmit Payment' }}
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endif
    </div>

    <div class="col-lg-5">
        @if($booking->status === 'confirmed' && $booking->tickets->isNotEmpty())
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                <i class="fas fa-qrcode" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'تذاكر QR' : 'QR Tickets' }}
                <span style="font-size:.8rem;font-weight:400;color:#888;">({{ $booking->tickets->count() }})</span>
            </h4>
            @foreach($booking->tickets as $ticket)
            <div style="background:var(--cream-light);border:1px solid var(--border);border-radius:10px;padding:14px;margin-bottom:10px;display:flex;align-items:center;gap:14px;">
                <div style="width:44px;height:44px;background:{{ $ticket->is_used ? '#bbb' : 'var(--navy)' }};border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-qrcode" style="color:#fff;font-size:1.2rem;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:700;color:var(--navy);font-size:.85rem;">
                        {{ app()->getLocale() === 'ar' ? 'تذكرة' : 'Ticket' }} #{{ $ticket->id }}
                    </div>
                    <div style="font-family:monospace;font-size:.75rem;color:#999;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $ticket->qr_code }}</div>
                    <span class="{{ $ticket->is_used ? 'badge-cancelled' : 'badge-confirmed' }}" style="font-size:.7rem;">
                        {{ $ticket->is_used ? (app()->getLocale() === 'ar' ? 'مستخدمة' : 'Used') : (app()->getLocale() === 'ar' ? 'صالحة' : 'Valid') }}
                    </span>
                </div>
                @if(!$ticket->is_used)
                <a href="{{ route('visitor.tickets.show', $ticket->id) }}" class="btn-pk-sm">
                    <i class="fas fa-eye"></i>
                </a>
                @endif
            </div>
            @endforeach
        </div>
        @elseif($booking->status === 'pending')
        <div class="dash-panel" style="text-align:center;padding:40px 24px;">
            <i class="fas fa-hourglass-half" style="font-size:2.5rem;color:var(--gold);opacity:.5;display:block;margin-bottom:16px;"></i>
            <p style="color:#888;margin:0;font-size:.9rem;">
                {{ app()->getLocale() === 'ar' ? 'ستظهر تذاكر QR هنا بعد تأكيد الدفع' : 'QR tickets will appear here after payment is verified' }}
            </p>
        </div>
        @endif
    </div>
</div>

@endsection
