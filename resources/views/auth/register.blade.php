<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.register') }} — {{ __('messages.park_name') }}</title>
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

        <div class="auth-lang">
            <a href="{{ route('lang.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">ع</a>
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>

        <div class="auth-logo">
            <div class="auth-icon">🌿</div>
            <h2>{{ app()->getLocale() === 'ar' ? 'إنشاء حساب' : 'Create Account' }}</h2>
            <p>{{ app()->getLocale() === 'ar' ? 'انضم إلى حديقة جرين سيتي الترفيهية' : 'Join Green City Entertainment Park' }}</p>
        </div>

        @if($errors->any())
            <div class="pk-alert pk-alert-error">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.name') }}</label>
                <input type="text" name="name" class="pk-input" value="{{ old('name') }}" placeholder="{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }}" required>
            </div>
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.email') }}</label>
                <input type="email" name="email" class="pk-input" value="{{ old('email') }}" placeholder="your@email.com" required>
            </div>
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.phone') }} <span style="color:var(--text-muted);font-size:9px;">({{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }})</span></label>
                <input type="text" name="phone" class="pk-input" value="{{ old('phone') }}" placeholder="+967 7XX XXX XXX">
            </div>
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.password') }}</label>
                <input type="password" name="password" class="pk-input" placeholder="••••••••" required>
            </div>
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.confirm_password') }}</label>
                <input type="password" name="password_confirmation" class="pk-input" placeholder="••••••••" required>
            </div>
            <div class="pk-form-group">
                <label class="pk-label">{{ __('messages.language') }}</label>
                <select name="language" class="pk-input">
                    <option value="ar" {{ old('language', 'ar') === 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="en" {{ old('language') === 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
            <button type="submit" class="auth-btn">
                <i class="fas fa-user-plus me-2"></i>{{ __('messages.register') }}
            </button>
        </form>

        <div class="auth-switch">
            {{ __('messages.have_account') }}
            <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
        </div>
        <div class="auth-back">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-1"></i>{{ __('messages.home') }}
            </a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
