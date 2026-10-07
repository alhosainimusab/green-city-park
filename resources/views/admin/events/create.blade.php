@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إضافة فعالية' : 'Add Event')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-plus me-2"></i>{{ app()->getLocale() === 'ar' ? 'إضافة فعالية' : 'Add Event' }}</h1>
    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.back') }}
    </a>
</div>
<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-bold">العنوان بالعربية</label><input type="text" name="title_ar" class="form-control" value="{{ old('title_ar') }}" required></div>
                <div class="col-md-6"><label class="form-label fw-bold">Title (English)</label><input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required></div>
                <div class="col-md-6"><label class="form-label fw-bold">الوصف بالعربية</label><textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar') }}</textarea></div>
                <div class="col-md-6"><label class="form-label fw-bold">Description (English)</label><textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea></div>
                <div class="col-md-3"><label class="form-label fw-bold">{{ __('messages.date') }}</label><input type="date" name="event_date" class="form-control" value="{{ old('event_date') }}" required></div>
                <div class="col-md-3"><label class="form-label fw-bold">Start Time</label><input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}"></div>
                <div class="col-md-3"><label class="form-label fw-bold">End Time</label><input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}"></div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ __('messages.status') }}</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('messages.active') }}</label>
                    </div>
                </div>
                <div class="col-md-6"><label class="form-label fw-bold">الموقع بالعربية</label><input type="text" name="location_ar" class="form-control" value="{{ old('location_ar') }}"></div>
                <div class="col-md-6"><label class="form-label fw-bold">Location (English)</label><input type="text" name="location_en" class="form-control" value="{{ old('location_en') }}"></div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success rounded-pill fw-bold px-5">
                        <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
