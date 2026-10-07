@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إدارة الألعاب' : 'Manage Rides')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'الألعاب والمرافق' : 'Rides & Attractions' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">{{ $rides->total() }} {{ app()->getLocale() === 'ar' ? 'لعبة' : 'ride(s)' }}</p>
    </div>
    <a href="{{ route('admin.rides.create') }}" class="btn-pk-primary">
        <i class="fas fa-plus"></i>
        {{ app()->getLocale() === 'ar' ? 'إضافة لعبة' : 'Add Ride' }}
    </a>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() === 'ar' ? 'الاسم' : 'Name' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الفئة' : 'Category' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحد الأدنى للعمر' : 'Min Age' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الطاقة' : 'Capacity' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الازدحام' : 'Traffic' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الانتظار' : 'Wait' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rides as $ride)
                <tr>
                    <td>
                        <div style="font-weight:700;color:var(--navy);">{{ $ride->name }}</div>
                        @if($ride->description)
                        <div style="font-size:.75rem;color:#999;margin-top:2px;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $ride->description }}</div>
                        @endif
                    </td>
                    <td style="color:#666;">{{ $ride->category ?? '—' }}</td>
                    <td>{{ $ride->min_age > 0 ? $ride->min_age . '+' : '—' }}</td>
                    <td>{{ $ride->capacity }}</td>
                    <td>
                        <span class="badge-{{ $ride->status }}">
                            @if($ride->status === 'active') {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}
                            @elseif($ride->status === 'maintenance') {{ app()->getLocale() === 'ar' ? 'صيانة' : 'Maintenance' }}
                            @else {{ app()->getLocale() === 'ar' ? 'مغلق' : 'Closed' }}
                            @endif
                        </span>
                    </td>
                    <td>
                        @if($ride->traffic_level)
                            @php
                                $tc = match($ride->traffic_level) { 'low' => '#2D6A4F', 'medium' => '#C8922A', 'high' => '#dc3545', default => '#999' };
                                $tl = match($ride->traffic_level) { 'low' => (app()->getLocale()==='ar'?'منخفض':'Low'), 'medium' => (app()->getLocale()==='ar'?'متوسط':'Medium'), 'high' => (app()->getLocale()==='ar'?'مرتفع':'High'), default => '—' };
                            @endphp
                            <span style="display:inline-flex;align-items:center;gap:5px;font-size:.78rem;font-weight:600;color:{{ $tc }};">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $tc }};flex-shrink:0;"></span>
                                {{ $tl }}
                            </span>
                        @else
                            <span style="color:#ccc;font-size:.82rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($ride->wait_time !== null && $ride->status === 'active')
                            <span style="font-size:.82rem;color:#555;font-weight:600;">
                                <i class="fas fa-clock" style="color:#aaa;margin-inline-end:3px;font-size:.72rem;"></i>
                                {{ $ride->wait_time }} {{ app()->getLocale() === 'ar' ? 'د' : 'min' }}
                            </span>
                        @else
                            <span style="color:#ccc;font-size:.82rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.rides.edit', $ride->id) }}" class="btn-pk-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.rides.destroy', $ride->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'حذف هذه اللعبة؟' : 'Delete this ride?' }}')">
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
                    <td colspan="6" style="text-align:center;padding:48px;color:#999;">
                        <i class="fas fa-rocket" style="font-size:2rem;opacity:.2;display:block;margin-bottom:12px;"></i>
                        {{ app()->getLocale() === 'ar' ? 'لا توجد ألعاب' : 'No rides' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rides->hasPages())
    <div style="margin-top:16px;display:flex;align-items:center;justify-content:center;gap:4px;">
        @if($rides->onFirstPage())
            <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:#ccc;font-size:.82rem;">
                &lsaquo; {{ app()->getLocale() === 'ar' ? 'السابق' : 'Prev' }}
            </span>
        @else
            <a href="{{ $rides->previousPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--navy);font-size:.82rem;text-decoration:none;">
                &lsaquo; {{ app()->getLocale() === 'ar' ? 'السابق' : 'Prev' }}
            </a>
        @endif
        <span style="padding:6px 14px;font-size:.82rem;color:#888;">{{ $rides->currentPage() }} / {{ $rides->lastPage() }}</span>
        @if($rides->hasMorePages())
            <a href="{{ $rides->nextPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--navy);font-size:.82rem;text-decoration:none;">
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
