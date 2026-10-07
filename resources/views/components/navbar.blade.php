<nav class="pk-nav">
    <a class="brand" href="{{ route('home') }}">
        <div class="brand-icon">🌿</div>
        <div>
            <span class="brand-en">Green City Entertainment</span>
            <span class="brand-ar">حديقة جرين سيتي الترفيهية — مأرب</span>
        </div>
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}"   class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.home') }}</a>
        <a href="{{ route('rides') }}"  class="{{ request()->routeIs('rides') ? 'active' : '' }}">{{ __('messages.rides') }}</a>
        <a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'active' : '' }}">{{ __('messages.events') }}</a>
        <a href="{{ route('map') }}"    class="{{ request()->routeIs('map') ? 'active' : '' }}">{{ app()->getLocale() === 'ar' ? 'خريطة الحديقة' : 'Park Map' }}</a>
        <a href="{{ route('about') }}"  class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ app()->getLocale() === 'ar' ? 'عن الحديقة' : 'About' }}</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('messages.contact') }}</a>
    </div>

    <div class="nav-right">
        <a href="{{ route('lang.switch', 'ar') }}" class="btn-lang {{ app()->getLocale() === 'ar' ? '' : '' }}" style="{{ app()->getLocale() === 'ar' ? 'background:var(--gold);color:var(--navy);border-color:var(--gold);' : '' }}">AR</a>
        <a href="{{ route('lang.switch', 'en') }}" class="btn-lang" style="{{ app()->getLocale() === 'en' ? 'background:var(--gold);color:var(--navy);border-color:var(--gold);' : '' }}">EN</a>

        @auth
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isStaff() ? route('staff.dashboard') : route('visitor.dashboard')) }}"
               class="btn-nav-login">
                <i class="fas fa-tachometer-alt me-1"></i>{{ __('messages.dashboard') }}
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-nav-login">{{ __('messages.login') }}</a>
            <a href="{{ route('register') }}" class="btn-nav-book">
                🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك' : 'Book Tickets' }}
            </a>
        @endauth
    </div>
</nav>
