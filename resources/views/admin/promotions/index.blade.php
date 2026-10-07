@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إدارة العروض' : 'Manage Promotions')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'العروض والخصومات' : 'Promotions & Discounts' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">{{ $promotions->total() }} {{ app()->getLocale() === 'ar' ? 'كود خصم' : 'promo code(s)' }}</p>
    </div>
    <a href="{{ route('admin.promotions.create') }}" class="btn-pk-primary">
        <i class="fas fa-plus"></i>
        {{ app()->getLocale() === 'ar' ? 'إضافة عرض' : 'Add Promotion' }}
    </a>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() === 'ar' ? 'الكود' : 'Code' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الاسم' : 'Name' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الخصم' : 'Discount' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الصلاحية' : 'Valid Until' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الاستخدامات' : 'Uses' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promo)
                <tr>
                    <td>
                        <span style="font-family:monospace;font-size:.9rem;font-weight:700;background:var(--navy);color:var(--gold-light);padding:4px 10px;border-radius:6px;">
                            {{ $promo->code }}
                        </span>
                    </td>
                    <td style="font-weight:600;color:var(--navy);">{{ $promo->name }}</td>
                    <td style="font-weight:700;color:var(--gold);">
                        @if($promo->discount_type === 'percentage')
                            {{ $promo->discount_value }}%
                        @else
                            {{ number_format($promo->discount_value) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}
                        @endif
                    </td>
                    <td style="font-size:.85rem;">
                        <div>{{ $promo->valid_from->format('d M Y') }}</div>
                        <div style="color:#888;">→ {{ $promo->valid_until->format('d M Y') }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $promo->used_count }}</div>
                        <div style="font-size:.75rem;color:#888;">{{ app()->getLocale() === 'ar' ? 'من' : 'of' }} {{ $promo->max_uses ?? '∞' }}</div>
                    </td>
                    <td>
                        <span class="{{ $promo->is_active && $promo->isValid() ? 'badge-confirmed' : 'badge-cancelled' }}">
                            {{ $promo->is_active && $promo->isValid()
                                ? (app()->getLocale() === 'ar' ? 'نشط' : 'Active')
                                : (app()->getLocale() === 'ar' ? 'منتهي' : 'Inactive') }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn-pk-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'حذف هذا العرض؟' : 'Delete?' }}')">
                                @csrf @method('DELETE')
                                <button class="btn-pk-sm" style="background:#dc3545;border-color:#dc3545;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:48px;color:#999;">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد عروض' : 'No promotions' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($promotions->hasPages())
    <div style="margin-top:16px;display:flex;align-items:center;justify-content:center;gap:4px;">
        @if($promotions->onFirstPage())
            <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:#ccc;font-size:.82rem;">
                &lsaquo; {{ app()->getLocale() === 'ar' ? 'السابق' : 'Prev' }}
            </span>
        @else
            <a href="{{ $promotions->previousPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--navy);font-size:.82rem;text-decoration:none;">
                &lsaquo; {{ app()->getLocale() === 'ar' ? 'السابق' : 'Prev' }}
            </a>
        @endif
        <span style="padding:6px 14px;font-size:.82rem;color:#888;">{{ $promotions->currentPage() }} / {{ $promotions->lastPage() }}</span>
        @if($promotions->hasMorePages())
            <a href="{{ $promotions->nextPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--navy);font-size:.82rem;text-decoration:none;">
                {{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }} &rsaquo;
            </a>
        @else
            <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:#ccc;font-size:.82rem;">
                {{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }} &rsaquo;
            </span>
        @endif
    </div>
    @endif
</div>

@endsection
