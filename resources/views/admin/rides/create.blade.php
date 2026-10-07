@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إضافة لعبة' : 'Add Ride')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-plus me-2"></i>{{ app()->getLocale() === 'ar' ? 'إضافة لعبة جديدة' : 'Add New Ride' }}</h1>
    <a href="{{ route('admin.rides.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.back') }}
    </a>
</div>
<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.rides.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الاسم بالعربية' : 'Name (Arabic)' }}</label>
                    <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الاسم بالإنجليزية' : 'Name (English)' }}</label>
                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الوصف بالعربية' : 'Description (Arabic)' }}</label>
                    <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الوصف بالإنجليزية' : 'Description (English)' }}</label>
                    <textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الفئة' : 'Category' }}</label>
                    <select name="category" class="form-select">
                        <option value="">-</option>
                        <option value="thrill">Thrill</option>
                        <option value="family">Family</option>
                        <option value="kids">Kids</option>
                        <option value="water">Water</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الحد الأدنى للعمر' : 'Min Age' }}</label>
                    <input type="number" name="min_age" class="form-control" value="{{ old('min_age', 0) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الحد الأدنى للطول (سم)' : 'Min Height (cm)' }}</label>
                    <input type="number" name="min_height" class="form-control" value="{{ old('min_height') }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ app()->getLocale() === 'ar' ? 'الطاقة الاستيعابية' : 'Capacity' }}</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', 20) }}" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ __('messages.status') }}</label>
                    <select name="status" class="form-select" required>
                        <option value="active">{{ __('messages.active') }}</option>
                        <option value="maintenance">{{ __('messages.maintenance') }}</option>
                        <option value="closed">{{ __('messages.closed') }}</option>
                    </select>
                </div>
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
