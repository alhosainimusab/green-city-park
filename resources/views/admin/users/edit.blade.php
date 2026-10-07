@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تعديل مستخدم' : 'Edit User')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-edit me-2"></i>{{ app()->getLocale() === 'ar' ? 'تعديل: ' : 'Edit: ' }}{{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.back') }}
    </a>
</div>
<div class="card" style="max-width:600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.name') }}</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.email') }}</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الدور' : 'Role' }}</label>
                <select name="role" class="form-select">
                    <option value="visitor" {{ old('role', $user->role) === 'visitor' ? 'selected' : '' }}>{{ __('messages.visitor') }}</option>
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>{{ __('messages.staff') }}</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>{{ __('messages.admin') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.language') }}</label>
                <select name="language" class="form-select">
                    <option value="ar" {{ old('language', $user->language) === 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="en" {{ old('language', $user->language) === 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.password') }} <span class="text-muted fw-normal">({{ app()->getLocale() === 'ar' ? 'اتركه فارغاً إذا لم تريد تغييره' : 'Leave blank to keep unchanged' }})</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">{{ __('messages.confirm_password') }}</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
            </button>
        </form>
    </div>
</div>
@endsection
