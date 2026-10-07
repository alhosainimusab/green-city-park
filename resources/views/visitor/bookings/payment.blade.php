@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إرسال الدفع' : 'Submit Payment')
@section('content')

<div style="margin-bottom:20px;">
    <a href="{{ route('visitor.bookings.show', $booking->id) }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة للحجز' : 'Back to Booking' }}
    </a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="row g-4">
            {{-- Payment Form --}}
            <div class="col-md-7">
                <div class="dash-panel">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 6px;font-size:1.4rem;">
                        {{ app()->getLocale() === 'ar' ? 'إرسال تأكيد الدفع' : 'Submit Payment Confirmation' }}
                    </h3>
                    <p style="color:#888;margin-bottom:24px;font-size:.9rem;">
                        {{ app()->getLocale() === 'ar' ? 'أرسل رقم حوالتك لتأكيد الحجز' : 'Send your transfer reference to confirm your booking' }}
                    </p>

                    {{-- Bank Card --}}
                    <div style="background:linear-gradient(135deg,var(--navy),#2a3f52);color:#fff;border-radius:12px;padding:20px;margin-bottom:24px;">
                        <div style="font-size:.75rem;color:var(--gold-light);margin-bottom:6px;text-transform:uppercase;letter-spacing:.08em;">
                            {{ app()->getLocale() === 'ar' ? 'بيانات التحويل' : 'Transfer Details' }}
                        </div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.15rem;margin-bottom:2px;">محسن الخضر للصرافة</div>
                        <div style="font-size:.8rem;color:rgba(255,255,255,.6);margin-bottom:12px;">Mohsen Al-Khader Exchange</div>
                        <div style="font-family:monospace;font-size:1.4rem;color:var(--gold-light);letter-spacing:.1em;">967 77-123-4567</div>
                        <div style="font-size:.8rem;color:rgba(255,255,255,.5);margin-top:4px;">مدينة مأرب — اليمن</div>
                    </div>

                    <form action="{{ route('visitor.bookings.payment.submit', $booking->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom:18px;">
                            <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</label>
                            <select name="payment_method" class="pk-input" id="payMethod" onchange="toggleRef(this.value)">
                                <option value="exchange_transfer">{{ app()->getLocale() === 'ar' ? '🏦 تحويل عبر الصرافة' : '🏦 Exchange Transfer' }}</option>
                                <option value="cash_at_gate">{{ app()->getLocale() === 'ar' ? '💵 دفع عند البوابة' : '💵 Cash at Gate' }}</option>
                            </select>
                        </div>

                        <div id="refBlock" style="margin-bottom:18px;">
                            <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'رقم الحوالة / المرجع' : 'Transfer Reference No.' }}</label>
                            <input type="text" name="reference_no" class="pk-input"
                                   placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: TRF-20260615-0001' : 'e.g. TRF-20260615-0001' }}"
                                   value="{{ old('reference_no') }}">
                            @error('reference_no')
                                <div style="color:#dc3545;font-size:.8rem;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-pk-primary" style="width:100%;justify-content:center;padding:14px;font-size:1rem;">
                            <i class="fas fa-paper-plane"></i>
                            {{ app()->getLocale() === 'ar' ? 'إرسال تأكيد الدفع' : 'Submit Payment' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-md-5">
                <div class="dash-panel">
                    <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                        {{ app()->getLocale() === 'ar' ? 'ملخص الحجز' : 'Booking Summary' }}
                    </h4>
                    <table style="width:100%;border-collapse:collapse;font-size:.9rem;">
                        <tr style="border-bottom:1px solid var(--border);">
                            <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'رقم الحجز' : 'Booking ID' }}</td>
                            <td style="padding:10px 0;text-align:end;font-weight:600;">#{{ $booking->id }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border);">
                            <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</td>
                            <td style="padding:10px 0;text-align:end;font-weight:600;">{{ $booking->visit_date->format('d M Y') }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border);">
                            <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'التذاكر' : 'Tickets' }}</td>
                            <td style="padding:10px 0;text-align:end;font-weight:600;">{{ $booking->quantity }} × {{ number_format($booking->unit_price) }}</td>
                        </tr>
                        @if($booking->discount_amount > 0)
                        <tr style="border-bottom:1px solid var(--border);">
                            <td style="padding:10px 0;color:#888;">{{ app()->getLocale() === 'ar' ? 'خصم' : 'Discount' }}</td>
                            <td style="padding:10px 0;text-align:end;color:var(--green);font-weight:600;">-{{ number_format($booking->discount_amount) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="padding:14px 0;color:var(--navy);font-weight:700;">{{ app()->getLocale() === 'ar' ? 'المجموع' : 'Total' }}</td>
                            <td style="padding:14px 0;text-align:end;color:var(--gold);font-weight:800;font-size:1.1rem;">{{ number_format($booking->total_price) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}</td>
                        </tr>
                    </table>

                    <div style="margin-top:16px;padding:12px;background:#e8f5e9;border-radius:8px;border:1px solid #c8e6c9;font-size:.8rem;color:#2e7d32;">
                        <i class="fas fa-info-circle" style="margin-inline-end:6px;"></i>
                        {{ app()->getLocale() === 'ar' ? 'سيتم مراجعة الدفع وتأكيد حجزك خلال 24 ساعة' : 'Payment will be reviewed and booking confirmed within 24 hours' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRef(method) {
    document.getElementById('refBlock').style.display = method === 'exchange_transfer' ? 'block' : 'none';
}
</script>

@endsection
