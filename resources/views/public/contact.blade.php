@extends('layouts.app')
@section('title', __('messages.contact'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="fw-bold mb-4" style="color:#1a7a4a;"><i class="fas fa-phone me-2"></i>{{ __('messages.contact') }}</h1>
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <i class="fas fa-phone-alt fa-2x text-success me-3"></i>
                        <div>
                            <div class="fw-bold">{{ app()->getLocale() === 'ar' ? 'الهاتف' : 'Phone' }}</div>
                            <div>{{ __('messages.contact_phone') }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <i class="fas fa-envelope fa-2x text-success me-3"></i>
                        <div>
                            <div class="fw-bold">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}</div>
                            <div>{{ __('messages.contact_email') }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <i class="fas fa-map-marker-alt fa-2x text-success me-3"></i>
                        <div>
                            <div class="fw-bold">{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Location' }}</div>
                            <div>{{ __('messages.park_location') }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="fas fa-clock fa-2x text-success me-3"></i>
                        <div>
                            <div class="fw-bold">{{ app()->getLocale() === 'ar' ? 'ساعات العمل' : 'Working Hours' }}</div>
                            <div>{{ __('messages.park_hours') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
