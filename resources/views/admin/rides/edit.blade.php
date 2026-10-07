@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تعديل لعبة' : 'Edit Ride')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-edit me-2"></i>{{ app()->getLocale() === 'ar' ? 'تعديل: ' : 'Edit: ' }}{{ $ride->name }}</h1>
    <a href="{{ route('admin.rides.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.back') }}
    </a>
</div>
<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.rides.update', $ride->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الاسم بالعربية' : 'Name (Arabic)' }}</label>
                    <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $ride->name_ar) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الاسم بالإنجليزية' : 'Name (English)' }}</label>
                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $ride->name_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الوصف بالعربية' : 'Description (Arabic)' }}</label>
                    <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $ride->description_ar) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الوصف بالإنجليزية' : 'Description (English)' }}</label>
                    <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $ride->description_en) }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الفئة' : 'Category' }}</label>
                    <select name="category" class="form-select">
                        <option value="">-</option>
                        <option value="thrill" {{ old('category', $ride->category) === 'thrill' ? 'selected' : '' }}>Thrill</option>
                        <option value="family" {{ old('category', $ride->category) === 'family' ? 'selected' : '' }}>Family</option>
                        <option value="kids" {{ old('category', $ride->category) === 'kids' ? 'selected' : '' }}>Kids</option>
                        <option value="water" {{ old('category', $ride->category) === 'water' ? 'selected' : '' }}>Water</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الحد الأدنى للعمر' : 'Min Age' }}</label>
                    <input type="number" name="min_age" class="form-control" value="{{ old('min_age', $ride->min_age) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الحد الأدنى للطول (سم)' : 'Min Height (cm)' }}</label>
                    <input type="number" name="min_height" class="form-control" value="{{ old('min_height', $ride->min_height) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الطاقة الاستيعابية' : 'Capacity' }}</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $ride->capacity) }}" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ __('messages.status') }}</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $ride->status) === 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                        <option value="maintenance" {{ old('status', $ride->status) === 'maintenance' ? 'selected' : '' }}>{{ __('messages.maintenance') }}</option>
                        <option value="closed" {{ old('status', $ride->status) === 'closed' ? 'selected' : '' }}>{{ __('messages.closed') }}</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'سبب تغيير الحالة' : 'Reason for Status Change' }} <span class="text-muted fw-normal">({{ app()->getLocale() === 'ar' ? 'اختياري' : 'Optional' }})</span></label>
                    <input type="text" name="reason" class="form-control" value="{{ old('reason') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary rounded-pill fw-bold px-5">
                        <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
