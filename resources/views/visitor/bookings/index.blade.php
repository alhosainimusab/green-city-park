@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'حجوزاتي' : 'My Bookings')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'حجوزاتي' : 'My Bookings' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;">
            {{ app()->getLocale() === 'ar' ? 'إدارة جميع حجوزاتك' : 'Manage all your bookings' }}
        </p>
    </div>
    <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">
        <i class="fas fa-plus"></i>
        {{ app()->getLocale() === 'ar' ? 'حجز جديد' : 'New Booking' }}
    </a>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'نوع التذكرة' : 'Ticket Type' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الكمية' : 'Qty' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'المبلغ' : 'Amount' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الدفع' : 'Payment' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td style="color:#999;font-size:.85rem;">#{{ $booking->id }}</td>
                    <td>
                        <strong>{{ $booking->visit_date->format('d M Y') }}</strong>
                        @if($booking->visit_date->isToday())
                            <span style="display:block;font-size:.75rem;color:var(--gold);">
                                {{ app()->getLocale() === 'ar' ? 'اليوم' : 'Today' }}
                            </span>
                        @elseif($booking->visit_date->isFuture())
                            <span style="display:block;font-size:.75rem;color:var(--green);">
                                {{ app()->getLocale() === 'ar' ? 'قادم' : 'Upcoming' }}
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($booking->ticket_type === 'adult')
                            <i class="fas fa-user" style="color:var(--gold);"></i>
                            {{ app()->getLocale() === 'ar' ? 'بالغ' : 'Adult' }}
                        @elseif($booking->ticket_type === 'child')
                            <i class="fas fa-child" style="color:var(--green);"></i>
                            {{ app()->getLocale() === 'ar' ? 'طفل' : 'Child' }}
                        @else
                            <i class="fas fa-users" style="color:var(--navy);"></i>
                            {{ app()->getLocale() === 'ar' ? 'مجموعة' : 'Group' }}
                        @endif
                    </td>
                    <td>{{ $booking->quantity }}</td>
                    <td style="font-weight:700;color:var(--navy);">
                        {{ number_format($booking->total_price) }}
                        <span style="font-size:.75rem;font-weight:400;color:#888;">{{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}</span>
                        @if($booking->discount_amount > 0)
                            <span style="display:block;font-size:.75rem;color:var(--green);">
                                -{{ number_format($booking->discount_amount) }} {{ app()->getLocale() === 'ar' ? 'خصم' : 'disc.' }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-{{ $booking->status }}">
                            @if($booking->status === 'pending') {{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}
                            @elseif($booking->status === 'confirmed') {{ app()->getLocale() === 'ar' ? 'مؤكد' : 'Confirmed' }}
                            @elseif($booking->status === 'rejected') {{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}
                            @else {{ app()->getLocale() === 'ar' ? 'ملغي' : 'Cancelled' }}
                            @endif
                        </span>
                    </td>
                    <td>
                        @if($booking->payment)
                            <span class="badge-{{ $booking->payment->status }}">
                                @if($booking->payment->status === 'pending') {{ app()->getLocale() === 'ar' ? 'بانتظار التحقق' : 'Pending' }}
                                @elseif($booking->payment->status === 'verified') {{ app()->getLocale() === 'ar' ? 'تم التحقق' : 'Verified' }}
                                @else {{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}
                                @endif
                            </span>
                        @elseif($booking->status === 'pending')
                            <a href="{{ route('visitor.bookings.payment', $booking->id) }}" class="btn-pk-sm" style="background:var(--gold);color:#fff;">
                                {{ app()->getLocale() === 'ar' ? 'ادفع' : 'Pay' }}
                            </a>
                        @else
                            <span style="color:#ccc;">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('visitor.bookings.show', $booking->id) }}" class="btn-pk-sm" title="{{ app()->getLocale() === 'ar' ? 'التفاصيل' : 'Details' }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($booking->status === 'pending' && !$booking->payment)
                        <form action="{{ route('visitor.bookings.cancel', $booking->id) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من إلغاء الحجز؟' : 'Cancel this booking?' }}')">
                            @csrf
                            <button class="btn-pk-sm" style="background:#dc3545;border-color:#dc3545;" title="{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:48px;color:#999;">
                        <i class="fas fa-calendar-times" style="font-size:2.5rem;display:block;margin-bottom:12px;opacity:.3;"></i>
                        {{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات بعد' : 'No bookings yet' }}
                        <br>
                        <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary" style="margin-top:16px;display:inline-block;">
                            {{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div style="margin-top:16px;">{{ $bookings->links() }}</div>
    @endif
</div>

@endsection
