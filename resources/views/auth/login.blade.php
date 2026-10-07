<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} — {{ __('messages.park_name') }}</title>
    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/park.css') }}">
</head>
<body>
<div class="auth-wrap">
    <div class="auth-box position-relative">

        <!-- Language switch -->
        <div class="auth-lang">
            <a href="{{ route('lang.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">ع</a>
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>

        <!-- Logo -->
        <div class="auth-logo">
            <div class="auth-icon">🌿</div>
            <h2>Green City Entertainment</h2>
            <p>حديقة جرين سيتي الترفيهية — مأرب</p>
        </div>

        @if($errors->any())
            <div class="pk-alert pk-alert-error">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.email') }}</label>
                <input id="em" type="email" name="email" class="pk-input" value="{{ old('email') }}" placeholder="your@email.com" required>
            </div>
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.password') }}</label>
                <div style="position:relative;">
                    <input id="pw" type="password" name="password" class="pk-input" placeholder="••••••••" required style="padding-right:40px;">
                    <button type="button" onclick="togglePw()" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>
            <div class="pk-form-group" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="remember" id="rem" style="accent-color:var(--gold);">
                <label for="rem" style="font-size:11px;color:var(--text-muted);cursor:pointer;">{{ __('messages.remember_me') }}</label>
            </div>
            <button type="submit" class="auth-btn">
                <i class="fas fa-sign-in-alt me-2"></i>{{ __('messages.login') }}
            </button>
        </form>

        <div class="auth-switch">
            {{ __('messages.no_account') }}
            <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
        </div>
        <div class="auth-back">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-1"></i>{{ __('messages.home') }}
            </a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePw() {
    const pw = document.getElementById('pw');
    const ic = document.getElementById('eye-icon');
    pw.type = pw.type === 'password' ? 'text' : 'password';
    ic.classList.toggle('fa-eye');
    ic.classList.toggle('fa-eye-slash');
}
</script>
</body>
</html>
