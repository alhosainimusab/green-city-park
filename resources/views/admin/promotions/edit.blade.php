@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'تعديل عرض' : 'Edit Promotion')
@section('content')

<div style="margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'تعديل العرض:' : 'Edit Promotion:' }}
            <span style="font-family:monospace;color:var(--gold);">{{ $promotion->code }}</span>
        </h2>
    </div>
    <a href="{{ route('admin.promotions.index') }}" style="color:var(--gold);text-decoration:none;font-size:.9rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
    </a>
</div>

{{-- Date warning if promo is not yet started --}}
@if($promotion->valid_from->isFuture())
<div style="background:#fff8e1;border:1px solid #ffe082;border-radius:12px;padding:14px 18px;margin-bottom:20px;max-width:720px;display:flex;align-items:center;gap:10px;">
    <i class="fas fa-exclamation-triangle" style="color:#C8922A;font-size:1.1rem;"></i>
    <div style="font-size:.88rem;color:#b45309;">
        <strong>{{ app()->getLocale() === 'ar' ? 'هذا الكود لم يبدأ بعد.' : 'This code has not started yet.' }}</strong>
        {{ app()->getLocale() === 'ar'
            ? ' تاريخ البداية (' . $promotion->valid_from->format('d M Y') . ') لم يصل بعد. غيّره إلى اليوم أو قبله لكي يعمل فوراً.'
            : ' The start date (' . $promotion->valid_from->format('d M Y') . ') is in the future. Change it to today or earlier to make it work immediately.' }}
    </div>
</div>
@endif

<div class="dash-panel" style="max-width:720px;">
    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST">
        @csrf @method('PUT')

        {{-- Code + Names --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'كود الخصم *' : 'Promo Code *' }}</label>
                <input type="text" name="code" class="pk-input" value="{{ old('code', $promotion->code) }}"
                       style="text-transform:uppercase;font-family:monospace;font-weight:700;letter-spacing:.08em;" required>
                @error('code')<div style="color:#dc3545;font-size:.78rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'الاسم بالعربية *' : 'Name (Arabic) *' }}</label>
                <input type="text" name="name_ar" class="pk-input" value="{{ old('name_ar', $promotion->name_ar) }}" required dir="rtl">
            </div>
            <div class="col-md-4">
                <label class="pk-label">Name (English) *</label>
                <input type="text" name="name_en" class="pk-input" value="{{ old('name_en', $promotion->name_en) }}" required>
            </div>
        </div>

        {{-- Discount type + value --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'نوع الخصم *' : 'Discount Type *' }}</label>
                <select name="discount_type" class="pk-input" id="discType" onchange="updateDiscLabel()">
                    <option value="percentage" {{ old('discount_type', $promotion->discount_type) === 'percentage' ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? 'نسبة مئوية (%)' : 'Percentage (%)' }}
                    </option>
                    <option value="fixed" {{ old('discount_type', $promotion->discount_type) === 'fixed' ? 'selected' : '' }}>
                        {{ app()->getLocale() === 'ar' ? 'قيمة ثابتة (ريال)' : 'Fixed Amount (YER)' }}
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="pk-label" id="discLabel">
                    {{ old('discount_type', $promotion->discount_type) === 'percentage'
                        ? (app()->getLocale() === 'ar' ? 'قيمة الخصم (%) *' : 'Discount Value (%) *')
                        : (app()->getLocale() === 'ar' ? 'قيمة الخصم (ريال) *' : 'Discount Value (YER) *') }}
                </label>
                <input type="number" name="discount_value" class="pk-input"
                       value="{{ old('discount_value', $promotion->discount_value) }}" min="0" step="0.01" required>
            </div>
            <div class="col-md-4">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'الحد الأقصى للاستخدام' : 'Max Uses' }} <span style="color:#aaa;font-weight:400;">({{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }})</span></label>
                <input type="number" name="max_uses" class="pk-input"
                       value="{{ old('max_uses', $promotion->max_uses) }}" min="1">
            </div>
        </div>

        {{-- Dates --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'تاريخ البداية *' : 'Valid From *' }}</label>
                <input type="date" name="valid_from" class="pk-input"
                       value="{{ old('valid_from', $promotion->valid_from->format('Y-m-d')) }}" required>
                <div style="font-size:.74rem;color:#888;margin-top:3px;">
                    {{ app()->getLocale() === 'ar' ? 'يجب أن يكون اليوم أو قبله لكي يعمل الكود' : 'Must be today or earlier for the code to work' }}
                </div>
            </div>
            <div class="col-md-6">
                <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'تاريخ الانتهاء *' : 'Valid Until *' }}</label>
                <input type="date" name="valid_until" class="pk-input"
                       value="{{ old('valid_until', $promotion->valid_until->format('Y-m-d')) }}" required>
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
                       {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}
                       style="display:none;" onchange="updateToggle()">
                @php $isOn = old('is_active', $promotion->is_active); @endphp
                <div id="toggleTrack" style="width:44px;height:24px;border-radius:12px;background:{{ $isOn ? 'var(--green)' : '#ccc' }};position:relative;transition:.2s;cursor:pointer;" onclick="document.getElementById('isActiveChk').click()">
                    <div id="toggleThumb" style="width:18px;height:18px;background:#fff;border-radius:50%;position:absolute;top:3px;left:{{ $isOn ? '23' : '3' }}px;transition:.2s;"></div>
                </div>
                <span id="toggleLabel" style="font-size:.85rem;font-weight:700;color:{{ $isOn ? 'var(--green)' : '#999' }};">
                    {{ $isOn ? (app()->getLocale() === 'ar' ? 'مفعّل' : 'Active') : (app()->getLocale() === 'ar' ? 'غير مفعّل' : 'Inactive') }}
                </span>
            </label>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-pk-primary" style="padding:11px 28px;">
                <i class="fas fa-save"></i>
                {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}
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
