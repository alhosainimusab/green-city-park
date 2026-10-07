@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تذاكري' : 'My Tickets')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'تذاكر QR' : 'QR Tickets' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">
            {{ app()->getLocale() === 'ar' ? 'تذاكرك المؤكدة جاهزة للمسح' : 'Your confirmed tickets ready for scanning' }}
        </p>
    </div>
    <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">
        <i class="fas fa-plus"></i>
        {{ app()->getLocale() === 'ar' ? 'حجز جديد' : 'New Booking' }}
    </a>
</div>

<div class="row g-4">
    @forelse($tickets as $ticket)
    <div class="col-md-4 col-sm-6">
        <div style="background:#fff;border:2px solid {{ $ticket->is_used ? '#ddd' : 'var(--gold)' }};border-radius:16px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);">
            {{-- Header --}}
            <div style="background:{{ $ticket->is_used ? '#888' : 'var(--navy)' }};padding:14px 18px;display:flex;align-items:center;gap:12px;">
                <i class="fas fa-qrcode" style="color:{{ $ticket->is_used ? '#ddd' : 'var(--gold)' }};font-size:1.4rem;"></i>
                <div>
                    <div style="color:#fff;font-weight:700;font-size:.9rem;">
                        {{ app()->getLocale() === 'ar' ? 'تذكرة' : 'Ticket' }} #{{ $ticket->id }}
                    </div>
                    <div style="color:rgba(255,255,255,.6);font-size:.75rem;">
                        {{ app()->getLocale() === 'ar' ? 'جرين سيتي الترفيهية' : 'Green City Entertainment' }}
                    </div>
                </div>
            </div>
            {{-- Body --}}
            <div style="padding:18px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                    <span style="color:#888;font-size:.85rem;">{{ app()->getLocale() === 'ar' ? 'نوع التذكرة' : 'Type' }}</span>
                    <strong style="color:var(--navy);font-size:.85rem;">
                        @if($ticket->booking->ticket_type === 'adult')
                            <i class="fas fa-user" style="color:var(--gold);"></i> {{ app()->getLocale() === 'ar' ? 'بالغ' : 'Adult' }}
                        @elseif($ticket->booking->ticket_type === 'child')
                            <i class="fas fa-child" style="color:var(--green);"></i> {{ app()->getLocale() === 'ar' ? 'طفل' : 'Child' }}
                        @else
                            <i class="fas fa-users" style="color:var(--navy);"></i> {{ app()->getLocale() === 'ar' ? 'مجموعة' : 'Group' }}
                        @endif
                    </strong>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                    <span style="color:#888;font-size:.85rem;">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</span>
                    <strong style="color:var(--navy);font-size:.85rem;">{{ $ticket->booking->visit_date->format('d M Y') }}</strong>
                </div>
                <div style="font-family:monospace;font-size:.75rem;color:#bbb;text-align:center;padding:8px 0;border-top:1px dashed var(--border);border-bottom:1px dashed var(--border);margin:12px 0;letter-spacing:.05em;">
                    {{ $ticket->qr_code }}
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span class="{{ $ticket->is_used ? 'badge-cancelled' : 'badge-confirmed' }}">
                        {{ $ticket->is_used ? (app()->getLocale() === 'ar' ? 'مستخدمة' : 'Used') : (app()->getLocale() === 'ar' ? 'صالحة' : 'Valid') }}
                    </span>
                    @if(!$ticket->is_used)
                    <a href="{{ route('visitor.tickets.show', $ticket->id) }}" class="btn-pk-primary" style="padding:8px 16px;font-size:.8rem;">
                        <i class="fas fa-qrcode"></i>
                        {{ app()->getLocale() === 'ar' ? 'عرض QR' : 'Show QR' }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12" style="text-align:center;padding:60px 20px;color:#999;">
        <i class="fas fa-ticket-alt" style="font-size:3rem;display:block;margin-bottom:16px;opacity:.2;"></i>
        <p style="margin-bottom:20px;">
            {{ app()->getLocale() === 'ar' ? 'لا توجد تذاكر مؤكدة بعد' : 'No confirmed tickets yet' }}
        </p>
        <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">
            {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن' : 'Book Your Ticket Now' }}
        </a>
    </div>
    @endforelse
</div>

@if($tickets->hasPages())
<div style="margin-top:24px;">{{ $tickets->links() }}</div>
@endif

@endsection
