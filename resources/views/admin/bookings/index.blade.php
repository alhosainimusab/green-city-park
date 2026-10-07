@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إدارة الحجوزات' : 'Manage Bookings')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'جميع الحجوزات' : 'All Bookings' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">{{ $bookings->total() }} {{ app()->getLocale() === 'ar' ? 'حجز' : 'booking(s)' }}</p>
    </div>
    {{-- Filters --}}
    <form style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <input type="text" name="search" class="pk-input" style="width:160px;padding:8px 12px;"
               placeholder="{{ app()->getLocale() === 'ar' ? 'بحث...' : 'Search...' }}" value="{{ request('search') }}">
        <select name="status" class="pk-input" style="width:auto;padding:8px 12px;">
            <option value="">{{ app()->getLocale() === 'ar' ? 'كل الحالات' : 'All' }}</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مؤكد' : 'Confirmed' }}</option>
            <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'ملغي' : 'Cancelled' }}</option>
        </select>
        <button type="submit" class="btn-pk-sm">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الزائر' : 'Visitor' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'نوع التذكرة' : 'Type' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'كمية' : 'Qty' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'المجموع' : 'Total' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td style="color:#999;font-size:.85rem;">#{{ $booking->id }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--navy);">{{ $booking->user->name }}</div>
                        <div style="font-size:.75rem;color:#888;">{{ $booking->user->email }}</div>
                    </td>
                    <td>{{ $booking->visit_date->format('d M Y') }}</td>
                    <td>{{ ucfirst($booking->ticket_type) }}</td>
                    <td>{{ $booking->quantity }}</td>
                    <td style="font-weight:700;color:var(--navy);">
                        {{ number_format($booking->total_price) }}
                        <span style="font-size:.75rem;color:#888;">{{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}</span>
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
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn-pk-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn-pk-sm" style="background:var(--green);border-color:var(--green);" title="{{ app()->getLocale() === 'ar' ? 'تأكيد' : 'Confirm' }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'رفض هذا الحجز؟' : 'Reject?' }}')">
                                @csrf
                                <button class="btn-pk-sm" style="background:#dc3545;border-color:#dc3545;" title="{{ app()->getLocale() === 'ar' ? 'رفض' : 'Reject' }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:48px;color:#999;">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات' : 'No bookings' }}
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
