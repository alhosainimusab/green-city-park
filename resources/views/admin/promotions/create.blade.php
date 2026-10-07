@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إضافة عرض' : 'Add Promotion')
@section('content')

<div style="margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'إضافة عرض جديد' : 'Add New Promotion' }}
        </h2>
    </div>
    <a href="{{ route('admin.promotions.index') }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
    </a>
</div>

<div class="dash-panel" style="max-width:720px;">
    <form action="{{ route('admin.promotions.store') }}" method="POST">
        @csrf

        {{-- Code + Names --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'كود الخصم *' : 'Promo Code *' }}</label>
                <input type="text" name="code" class="pk-input" value="{{ old('code') }}"
                       style="text-transform:uppercase;font-family:monospace;font-weight:700;letter-spacing:.08em;"
                       placeholder="e.g. SUMMER25" required>
                @error('code')<div style="color:#dc3545;font-size:.78rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'الاسم بالعربية *' : 'Name (Arabic) *' }}</label>
                <input type="text" name="name_ar" class="pk-input" value="{{ old('name_ar') }}" required dir="rtl">
            </div>
            <div class="col-md-4">
                <label class="pk-label">Name (English) *</label>
                <input type="text" name="name_en" class="pk-input" value="{{ old('name_en') }}" required>
            </div>
        </div>

        {{-- Discount type + value --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'نوع الخصم *' : 'Discount Type *' }}</label>
                <select name="discount_type" class="pk-input" id="discType" onchange="updateDiscLabel()">
                    <option value="percentage" {{ old('discount_type') === 'percentage' || !old('discount_type') ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? 'نسبة مئوية (%)' : 'Percentage (%)' }}
                    </option>
                    <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? 'قيمة ثابتة (ريال)' : 'Fixed Amount (YER)' }}
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="pk-label" id="discLabel">{{ app()->getLocale() === 'ar' ? 'قيمة الخصم (%) *' : 'Discount Value (%) *' }}</label>
                <input type="number" name="discount_value" class="pk-input" value="{{ old('discount_value') }}"
                       min="0" step="0.01" required placeholder="e.g. 20">
            </div>
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'الحد الأقصى للاستخدام' : 'Max Uses' }} <span style="color:#aaa;font-weight:400;">({{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }})</span></label>
                <input type="number" name="max_uses" class="pk-input" value="{{ old('max_uses') }}" min="1" placeholder="{{ app()->getLocale() === 'ar' ? 'غير محدود' : 'Unlimited' }}">
            </div>
        </div>

        {{-- Dates --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'تاريخ البداية *' : 'Valid From *' }}</label>
                <input type="date" name="valid_from" class="pk-input"
                       value="{{ old('valid_from', date('Y-m-d')) }}" required>
                <div style="font-size:.74rem;color:var(--green);margin-top:3px;">
                    <i class="fas fa-info-circle"></i>
                    {{ app()->getLocale() === 'ar' ? 'تم ضبطه على اليوم بشكل افتراضي — يجب أن يكون اليوم أو قبله لكي يعمل الكود فوراً' : 'Defaults to today — must be today or earlier for the code to work immediately' }}
                </div>
            </div>
            <div class="col-md-6">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'تاريخ الانتهاء *' : 'Valid Until *' }}</label>
                <input type="date" name="valid_until" class="pk-input"
                       value="{{ old('valid_until') }}" required>
            </div>
        </div>

        {{-- Active toggle --}}
        <div style="margin-bottom:20px;padding:14px;background:var(--cream-light);border-radius:12px;display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-weight:700;color:var(--navy);font-size:.9rem;">{{ app()->getLocale() === 'ar' ? 'تفعيل الكود' : 'Activate Code' }}</div>
                <div style="font-size:.78rem;color:#888;">{{ app()->getLocale() === 'ar' ? 'يجب تفعيله لكي يقبله النظام' : 'Must be active for the system to accept it' }}</div>
            </div>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="is_active" id="isActiveChk" value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       style="display:none;" onchange="updateToggle()">
                <div id="toggleTrack" style="width:44px;height:24px;border-radius:12px;background:var(--green);position:relative;transition:.2s;cursor:pointer;" onclick="document.getElementById('isActiveChk').click()">
                    <div id="toggleThumb" style="width:18px;height:18px;background:#fff;border-radius:50%;position:absolute;top:3px;left:23px;transition:.2s;"></div>
                </div>
                <span id="toggleLabel" style="font-size:.85rem;font-weight:700;color:var(--green);">{{ app()->getLocale() === 'ar' ? 'مفعّل' : 'Active' }}</span>
            </label>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-pk-primary" style="padding:11px 28px;">
                <i class="fas fa-save"></i>
                {{ app()->getLocale() === 'ar' ? 'حفظ العرض' : 'Save Promotion' }}
            </button>
            <a href="{{ route('admin.promotions.index') }}" style="padding:11px 20px;border:1px solid var(--border);border-radius:8px;color:#666;text-decoration:none;font-size:.9rem;">
                {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
            </a>
        </div>
    </form>
</div>

<script>
function updateDiscLabel() {
    const t = document.getElementById('discType').value;
    document.getElementById('discLabel').textContent =
        t === 'percentage'
            ? '{{ app()->getLocale() === 'ar' ? 'قيمة الخصم (%) *' : 'Discount Value (%) *' }}'
            : '{{ app()->getLocale() === 'ar' ? 'قيمة الخصم (ريال) *' : 'Discount Value (YER) *' }}';
}
function updateToggle() {
    const chk = document.getElementById('isActiveChk').checked;
    document.getElementById('toggleTrack').style.background = chk ? 'var(--green)' : '#ccc';
    document.getElementById('toggleThumb').style.left = chk ? '23px' : '3px';
    document.getElementById('toggleLabel').style.color = chk ? 'var(--green)' : '#999';
    document.getElementById('toggleLabel').textContent = chk
        ? '{{ app()->getLocale() === 'ar' ? 'مفعّل' : 'Active' }}'
        : '{{ app()->getLocale() === 'ar' ? 'غير مفعّل' : 'Inactive' }}';
}
</script>
@endsection
