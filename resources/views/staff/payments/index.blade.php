@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'التحقق من المدفوعات' : 'Verify Payments')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'التحقق من المدفوعات' : 'Verify Payments' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">
            {{ app()->getLocale() === 'ar' ? 'راجع وتحقق من حوالات الزوار' : 'Review and verify visitor transfers' }}
        </p>
    </div>
    {{-- Filter --}}
    <form style="display:flex;gap:8px;align-items:center;">
        <select name="status" class="pk-input" style="width:auto;padding:8px 14px;">
            <option value="">{{ app()->getLocale() === 'ar' ? 'كل الحالات' : 'All Status' }}</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}</option>
            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'تم التحقق' : 'Verified' }}</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}</option>
        </select>
        <button type="submit" class="btn-pk-sm">
            <i class="fas fa-filter"></i>
            {{ app()->getLocale() === 'ar' ? 'فلتر' : 'Filter' }}
        </button>
    </form>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الزائر' : 'Visitor' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Method' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'رقم المرجع' : 'Reference' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'المبلغ' : 'Amount' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td style="color:#999;font-size:.85rem;">#{{ $payment->id }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--navy);">{{ $payment->booking->user->name }}</div>
                        <div style="font-size:.75rem;color:#888;">{{ $payment->booking->user->email }}</div>
                    </td>
                    <td>
                        {{ $payment->payment_method === 'exchange_transfer'
                            ? (app()->getLocale() === 'ar' ? 'تحويل' : 'Transfer')
                            : (app()->getLocale() === 'ar' ? 'بوابة' : 'Gate') }}
                    </td>
                    <td style="font-family:monospace;font-size:.85rem;color:var(--navy);">
                        {{ $payment->reference_no ?? '—' }}
                    </td>
                    <td style="font-weight:700;color:var(--navy);">
                        {{ number_format($payment->amount) }}
                        <span style="font-size:.75rem;color:#888;">{{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}</span>
                    </td>
                    <td>
                        <span class="badge-{{ $payment->status }}">
                            @if($payment->status === 'pending') {{ app()->getLocale() === 'ar' ? 'معلق' : 'Pending' }}
                            @elseif($payment->status === 'verified') {{ app()->getLocale() === 'ar' ? 'تم التحقق' : 'Verified' }}
                            @else {{ app()->getLocale() === 'ar' ? 'مرفوض' : 'Rejected' }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('staff.payments.show', $payment->id) }}" class="btn-pk-sm" title="{{ app()->getLocale() === 'ar' ? 'التفاصيل' : 'Details' }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($payment->status === 'pending')
                            <form action="{{ route('staff.payments.verify', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn-pk-sm" style="background:var(--green);border-color:var(--green);"
                                        title="{{ app()->getLocale() === 'ar' ? 'تحقق' : 'Verify' }}"
                                        onclick="return confirm('{{ app()->getLocale() === 'ar' ? 'التحقق من هذا الدفع؟' : 'Verify this payment?' }}')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('staff.payments.reject', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn-pk-sm" style="background:#dc3545;border-color:#dc3545;"
                                        title="{{ app()->getLocale() === 'ar' ? 'رفض' : 'Reject' }}"
                                        onclick="return confirm('{{ app()->getLocale() === 'ar' ? 'رفض هذا الدفع؟' : 'Reject this payment?' }}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:48px;color:#999;">
                        <i class="fas fa-check-circle" style="font-size:2rem;display:block;margin-bottom:12px;opacity:.3;"></i>
                        {{ app()->getLocale() === 'ar' ? 'لا توجد مدفوعات في الانتظار' : 'No payments pending' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div style="margin-top:16px;">{{ $payments->links() }}</div>
    @endif
</div>

@endsection
