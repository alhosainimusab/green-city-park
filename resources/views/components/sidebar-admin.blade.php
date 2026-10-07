<div class="sl-logo">
    <span class="sl-en">Green City</span>
    <span class="sl-sub">Admin Portal — مدير النظام</span>
</div>

<div class="ss-lbl">Overview</div>
<a class="si {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
    <span class="si-ic"><i class="fas fa-chart-bar"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Analytics' }}</span>
</a>

<div class="ss-lbl">Management</div>
<a class="si {{ request()->routeIs('admin.rides.*') ? 'active' : '' }}" href="{{ route('admin.rides.index') }}">
    <span class="si-ic"><i class="fas fa-rocket"></i></span>
    <span class="si-t">{{ __('messages.rides') }}</span>
</a>
<a class="si {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
    <span class="si-ic"><i class="fas fa-theater-masks"></i></span>
    <span class="si-t">{{ __('messages.events') }}</span>
</a>
<a class="si {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">
    <span class="si-ic"><i class="fas fa-tags"></i></span>
    <span class="si-t">{{ __('messages.promotions') }}</span>
</a>
<a class="si {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
    <span class="si-ic"><i class="fas fa-calendar-check"></i></span>
    <span class="si-t">{{ __('messages.bookings') }}</span>
</a>
<a class="si {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
    <span class="si-ic"><i class="fas fa-users"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'حسابات الموظفين' : 'Staff Accounts' }}</span>
</a>

<a class="si {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">
    <span class="si-ic"><i class="fas fa-bell"></i></span>
    <span class="si-t">{{ __('messages.notifications') }}</span>
</a>

<div class="ss-lbl">Reports</div>
<a class="si {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
    <span class="si-ic"><i class="fas fa-chart-line"></i></span>
    <span class="si-t">{{ __('messages.reports') }}</span>
</a>

<div class="ss-lbl">Quick Access</div>
<a class="si {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">
    <span class="si-ic"><i class="fas fa-user-tie"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'بوابة الموظفين' : 'Staff Portal' }}</span>
</a>
<a class="si" href="{{ route('home') }}">
    <span class="si-ic"><i class="fas fa-globe"></i></span>
    <span class="si-t">{{ app()->getLocale() === 'ar' ? 'الموقع العام' : 'Public Site' }}</span>
</a>
