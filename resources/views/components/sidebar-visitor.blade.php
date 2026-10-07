<div class="sl-logo">
    <span class="sl-en">Green City</span>
    <span class="sl-sub">Visitor Portal — بوابة الزوار</span>
</div>

<div class="ss-lbl">{{ app()->getLocale() === 'ar' ? 'حسابي' : 'My Account' }}</div>
<a class="si {{ request()->routeIs('visitor.dashboard') ? 'active' : '' }}" href="{{ route('visitor.dashboard') }}">
    <span class="si-ic"><i class="fas fa-home"></i></span>
    <span class="si-t">{{ __('messages.dashboard') }}</span>
</a>
<a class="si {{ request()->routeIs('visitor.bookings.*') ? 'active' : '' }}" href="{{ route('visitor.bookings.index') }}">
    <span class="si-ic"><i class="fas fa-calendar-check"></i></span>
    <span class="si-t">{{ __('messages.bookings') }}</span>
</a>
<a class="si {{ request()->routeIs('visitor.tickets.*') ? 'active' : '' }}" href="{{ route('visitor.tickets.index') }}">
    <span class="si-ic"><i class="fas fa-ticket-alt"></i></span>
    <span class="si-t">{{ __('messages.tickets') }}</span>
</a>
<a class="si {{ request()->routeIs('visitor.notifications.*') ? 'active' : '' }}" href="{{ route('visitor.notifications.index') }}">
    <span class="si-ic"><i class="fas fa-bell"></i></span>
    <span class="si-t">
        {{ __('messages.notifications') }}
        @php $unread = auth()->user() ? \App\Models\AppNotification::where('user_id', auth()->id())->where('is_read', false)->count() : 0; @endphp
        @if($unread > 0)
            <span style="background:#C0392B;color:#fff;border-radius:10px;padding:1px 6px;font-size:9px;margin-left:6px;">{{ $unread }}</span>
        @endif
    </span>
</a>

<div class="ss-lbl">{{ app()->getLocale() === 'ar' ? 'الخدمات' : 'Services' }}</div>
<a class="si" href="{{ route('visitor.bookings.create') }}" style="border-left:3px solid var(--gold);">
    <span class="si-ic" style="color:var(--gold-light);"><i class="fas fa-plus-circle"></i></span>
    <span class="si-t" style="color:var(--gold-light);font-weight:700;">{{ app()->getLocale() === 'ar' ? 'احجز تذكرة' : 'Book Ticket' }}</span>
</a>
<a class="si" href="{{ route('home') }}">
    <span class="si-ic"><i class="fas fa-globe"></i></span>
    <span class="si-t">{{ __('messages.home') }}</span>
</a>
