@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'مسح التذاكر' : 'Scan Tickets')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div style="margin-bottom:24px;text-align:center;">
            <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
                {{ app()->getLocale() === 'ar' ? 'فحص تذاكر الدخول' : 'Ticket Verification' }}
            </h2>
            <p style="color:#888;margin:6px 0 0;font-size:.9rem;">
                {{ app()->getLocale() === 'ar' ? 'أدخل رمز QR للتحقق من صلاحية التذكرة' : 'Enter the QR code to verify ticket validity' }}
            </p>
        </div>

        @if(session('scan_result'))
        @php $result = session('scan_result'); @endphp
        <div style="background:{{ $result['success'] ? '#e8f5e9' : '#ffebee' }};border:1px solid {{ $result['success'] ? '#c8e6c9' : '#ffcdd2' }};border-radius:16px;padding:20px 24px;margin-bottom:24px;display:flex;align-items:center;gap:16px;">
            <i class="fas fa-{{ $result['success'] ? 'check-circle' : 'times-circle' }}"
               style="font-size:2.5rem;color:{{ $result['success'] ? 'var(--green)' : '#dc3545' }};flex-shrink:0;"></i>
            <div>
                <div style="font-weight:700;font-size:1.1rem;color:{{ $result['success'] ? 'var(--green)' : '#dc3545' }};">
                    {{ $result['message'] }}
                </div>
                @if(isset($result['ticket']))
                <div style="font-size:.85rem;color:#666;margin-top:4px;">
                    {{ app()->getLocale() === 'ar' ? 'الزائر:' : 'Visitor:' }} {{ $result['ticket']->booking->user->name }}
                    · {{ ucfirst($result['ticket']->booking->ticket_type) }}
                    · {{ $result['ticket']->booking->visit_date->format('d M Y') }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="dash-panel">
            {{-- Scanner icon --}}
            <div style="text-align:center;margin-bottom:24px;">
                <div style="width:80px;height:80px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <i class="fas fa-qrcode" style="font-size:2rem;color:var(--gold);"></i>
                </div>
            </div>

            <form action="{{ route('staff.tickets.scan.submit') }}" method="POST">
                @csrf
                <div style="margin-bottom:20px;">
                    <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'رمز QR / كود التذكرة' : 'QR Code / Ticket Code' }}</label>
                    <input type="text" name="qr_code" class="pk-input"
                           placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: GCEP-XXXXXXXX' : 'e.g. GCEP-XXXXXXXX' }}"
                           style="font-family:monospace;font-size:1rem;letter-spacing:.1em;text-align:center;"
                           autofocus autocomplete="off">
                </div>

                <button type="submit" class="btn-pk-primary" style="width:100%;justify-content:center;padding:14px;font-size:1rem;">
                    <i class="fas fa-search"></i>
                    {{ app()->getLocale() === 'ar' ? 'فحص التذكرة' : 'Verify Ticket' }}
                </button>
            </form>

            <div style="margin-top:20px;padding:14px;background:var(--cream-light);border-radius:10px;text-align:center;font-size:.8rem;color:#888;">
                <i class="fas fa-info-circle" style="color:var(--gold);margin-inline-end:6px;"></i>
                {{ app()->getLocale() === 'ar' ? 'امسح الرمز باستخدام قارئ QR أو أدخله يدوياً' : 'Scan with a QR reader or enter the code manually' }}
            </div>
        </div>
    </div>
</div>

@endsection
