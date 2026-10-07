@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إضافة مستخدم' : 'Add User')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-plus me-2"></i>{{ app()->getLocale() === 'ar' ? 'إضافة مستخدم جديد' : 'Add New User' }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.back') }}
    </a>
</div>
<div class="card" style="max-width:600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.name') }}</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.email') }}</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.phone') }}</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الدور' : 'Role' }}</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="visitor" {{ old('role', 'visitor') === 'visitor' ? 'selected' : '' }}>{{ __('messages.visitor') }}</option>
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>{{ __('messages.staff') }}</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>{{ __('messages.admin') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.language') }}</label>
                <select name="language" class="form-select">
                    <option value="ar" {{ old('language', 'ar') === 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="en" {{ old('language') === 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.password') }}</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">{{ __('messages.confirm_password') }}</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
            </button>
        </form>
    </div>
</div>
@endsection
