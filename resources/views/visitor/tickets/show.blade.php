@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تذكرة QR' : 'QR Ticket')
@section('content')

<div style="margin-bottom:20px;">
    <a href="{{ route('visitor.tickets.index') }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة للتذاكر' : 'Back to Tickets' }}
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-sm-10 col-md-6 col-lg-5">
        {{-- Ticket Card --}}
        <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 8px 32px rgba(27,43,58,.15);" id="ticketCard">
            {{-- Header --}}
            <div style="background:var(--navy);padding:24px;text-align:center;">
                <div style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--gold-light);margin-bottom:4px;">
                    Green City Entertainment
                </div>
                <div style="font-size:.85rem;color:rgba(255,255,255,.6);">حديقة جرين سيتي الترفيهية — مأرب</div>
            </div>

            {{-- QR Section --}}
            <div style="padding:32px;text-align:center;">
                <div style="background:#fff;border:3px solid var(--border);border-radius:16px;padding:16px;display:inline-block;margin-bottom:16px;box-shadow:inset 0 2px 8px rgba(0,0,0,.05);">
                    <div style="width:200px;height:200px;">{!! $qrSvg !!}</div>
                </div>

                <div style="font-family:monospace;font-size:.9rem;color:#888;letter-spacing:.12em;margin-bottom:20px;background:var(--cream-light);padding:8px 16px;border-radius:8px;display:inline-block;">
                    {{ $ticket->qr_code }}
                </div>

                {{-- Details Grid --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;text-align:start;margin-bottom:20px;">
                    <div style="background:var(--cream-light);padding:12px;border-radius:10px;">
                        <div style="font-size:.75rem;color:#888;margin-bottom:4px;">{{ app()->getLocale() === 'ar' ? 'نوع التذكرة' : 'Ticket Type' }}</div>
                        <div style="font-weight:700;color:var(--navy);font-size:.9rem;">{{ ucfirst($ticket->booking->ticket_type) }}</div>
                    </div>
                    <div style="background:var(--cream-light);padding:12px;border-radius:10px;">
                        <div style="font-size:.75rem;color:#888;margin-bottom:4px;">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit Date' }}</div>
                        <div style="font-weight:700;color:var(--navy);font-size:.9rem;">{{ $ticket->booking->visit_date->format('d M Y') }}</div>
                    </div>
                    <div style="background:var(--cream-light);padding:12px;border-radius:10px;">
                        <div style="font-size:.75rem;color:#888;margin-bottom:4px;">{{ app()->getLocale() === 'ar' ? 'صاحب التذكرة' : 'Holder' }}</div>
                        <div style="font-weight:700;color:var(--navy);font-size:.9rem;">{{ auth()->user()->name }}</div>
                    </div>
                    <div style="background:var(--cream-light);padding:12px;border-radius:10px;">
                        <div style="font-size:.75rem;color:#888;margin-bottom:4px;">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</div>
                        <span class="{{ $ticket->is_used ? 'badge-cancelled' : 'badge-confirmed' }}">
                            {{ $ticket->is_used ? (app()->getLocale() === 'ar' ? 'مستخدمة' : 'Used') : (app()->getLocale() === 'ar' ? 'صالحة' : 'Valid') }}
                        </span>
                    </div>
                </div>

                @if(!$ticket->is_used)
                <div style="background:#e8f5e9;border:1px solid #c8e6c9;border-radius:10px;padding:12px;margin-bottom:20px;font-size:.85rem;color:#2e7d32;text-align:start;">
                    <i class="fas fa-info-circle" style="margin-inline-end:6px;"></i>
                    {{ app()->getLocale() === 'ar' ? 'أبرز هذا الرمز عند بوابة الدخول للحديقة' : 'Show this QR code at the park entrance gate' }}
                </div>
                @endif

                <button onclick="window.print()" class="btn-pk-primary" style="width:100%;justify-content:center;padding:12px;">
                    <i class="fas fa-print"></i>
                    {{ app()->getLocale() === 'ar' ? 'طباعة التذكرة' : 'Print Ticket' }}
                </button>
            </div>

            {{-- Footer --}}
            <div style="background:var(--navy);padding:12px;text-align:center;">
                <div style="font-size:.75rem;color:rgba(255,255,255,.4);">
                    Ticket #{{ $ticket->id }} — {{ app()->getLocale() === 'ar' ? 'غير قابل للتحويل' : 'Non-transferable' }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .dash-nav, .dash-sidebar, [style*="margin-bottom:20px"] { display: none !important; }
    #ticketCard { box-shadow: none !important; }
}
</style>

@endsection
