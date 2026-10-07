@extends('layouts.dashboard')
@section('title', $user->name)
@section('content')
<div class="page-header">
    <h1>{{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.back') }}
    </a>
</div>
<div class="card" style="max-width:500px;">
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th>{{ __('messages.name') }}</th><td>{{ $user->name }}</td></tr>
            <tr><th>{{ __('messages.email') }}</th><td>{{ $user->email }}</td></tr>
            <tr><th>{{ __('messages.phone') }}</th><td>{{ $user->phone ?? '-' }}</td></tr>
            <tr><th>{{ app()->getLocale() === 'ar' ? 'الدور' : 'Role' }}</th><td><span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'staff' ? 'bg-warning' : 'bg-success') }}">{{ __('messages.' . $user->role) }}</span></td></tr>
            <tr><th>{{ __('messages.language') }}</th><td>{{ strtoupper($user->language) }}</td></tr>
            <tr><th>{{ __('messages.date') }}</th><td>{{ $user->created_at->format('Y-m-d') }}</td></tr>
        </table>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary rounded-pill">
            <i class="fas fa-edit me-2"></i>{{ __('messages.edit') }}
        </a>
    </div>
</div>
@endsection
