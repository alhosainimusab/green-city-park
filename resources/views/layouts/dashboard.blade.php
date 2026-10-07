<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.dashboard')) — {{ __('messages.park_name') }}</title>

    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/park.css') }}">
    @stack('head')
</head>
<body>

<!-- Dashboard Navbar -->
<nav class="dash-nav">
    <a class="brand" href="{{ route('home') }}">
        <div class="brand-icon">🌿</div>
        <div>
            <span class="brand-en">Green City</span>
            <span class="brand-sub">
                @if(auth()->user()->isAdmin())
                    Admin Portal — مدير النظام
                @elseif(auth()->user()->isStaff())
                    Staff Portal — بوابة الموظفين
                @else
                    Visitor Portal — بوابة الزوار
                @endif
            </span>
        </div>
    </a>

    <div class="nav-right">
        <!-- Language -->
        <div class="d-flex gap-1">
            <a href="{{ route('lang.switch', 'ar') }}"
               class="btn-nav-login" style="{{ app()->getLocale() === 'ar' ? 'background:var(--gold);color:var(--navy);' : '' }}">ع</a>
            <a href="{{ route('lang.switch', 'en') }}"
               class="btn-nav-login" style="{{ app()->getLocale() === 'en' ? 'background:var(--gold);color:var(--navy);' : '' }}">EN</a>
        </div>

        <!-- User pill -->
        <div class="dropdown">
            <div class="user-pill dropdown-toggle" data-bs-toggle="dropdown" style="cursor:pointer;">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" style="font-size:12px;">
                <li><span class="dropdown-item-text text-muted" style="font-size:10px;">{{ ucfirst(auth()->user()->role) }}</span></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('home') }}">
                        <i class="fas fa-globe me-2"></i>{{ __('messages.home') }}
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="dash-sidebar" id="dashSidebar">
    @if(auth()->user()->isAdmin())
        @include('components.sidebar-admin')
    @elseif(auth()->user()->isStaff())
        @include('components.sidebar-staff')
    @else
        @include('components.sidebar-visitor')
    @endif
</div>

<!-- Main Content -->
<div class="dash-main">
    <div class="dash-inner">
        @if(session('success'))
            <div class="pk-alert pk-alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="pk-alert pk-alert-error mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="pk-alert pk-alert-error mb-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
