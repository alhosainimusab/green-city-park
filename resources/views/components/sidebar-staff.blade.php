<div class="sl-logo">
    <span class="sl-en">Green City</span>
    <span class="sl-sub">Staff Portal — بوابة الموظفين</span>
</div>

<div class="ss-lbl">{{ app()->getLocale() === 'ar' ? 'العمليات' : 'Operations' }}</div>
<a class="si {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">
    <span class="si-ic"><i class="fas fa-tachometer-alt"></i></span>
    <span class="si-t">{{ __('messages.dashboard') }}</span>
</a>
<a class="si {{ request()->routeIs('staff.payments.*') ? 'active' : '' }}" href="{{ route('staff.payments.index') }}">
    <span class="si-ic"><i class="fas fa-money-bill-wave"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'التحقق من الدفعات' : 'Verify Payments' }}</span>
</a>
<a class="si {{ request()->routeIs('staff.rides.*') ? 'active' : '' }}" href="{{ route('staff.rides.index') }}">
    <span class="si-ic"><i class="fas fa-rocket"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'حالة الألعاب' : 'Ride Status' }}</span>
</a>
<a class="si {{ request()->routeIs('staff.tickets.*') ? 'active' : '' }}" href="{{ route('staff.tickets.scan') }}">
    <span class="si-ic"><i class="fas fa-qrcode"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'مسح التذاكر' : 'Scan Tickets' }}</span>
</a>

<div class="ss-lbl">{{ app()->getLocale() === 'ar' ? 'أخرى' : 'Other' }}</div>
<a class="si" href="{{ route('home') }}">
    <span class="si-ic"><i class="fas fa-globe"></i></span>
    <span class="si-t">{{ __('messages.home') }}</span>
</a>
