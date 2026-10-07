@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إدارة الفعاليات' : 'Manage Events')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'الفعاليات والعروض' : 'Events & Shows' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">{{ $events->total() }} {{ app()->getLocale() === 'ar' ? 'فعالية' : 'event(s)' }}</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn-pk-primary">
        <i class="fas fa-plus"></i>
        {{ app()->getLocale() === 'ar' ? 'إضافة فعالية' : 'Add Event' }}
    </a>
</div>

<div class="dash-panel">
    <div class="table-responsive">
        <table class="pk-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Title' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الوقت' : 'Time' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الموقع' : 'Location' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr>
                    <td>
                        <div style="font-weight:700;color:var(--navy);">{{ $event->title }}</div>
                    </td>
                    <td>
                        <strong>{{ $event->event_date->format('d M Y') }}</strong>
                        @if($event->event_date->isFuture())
                            <span style="display:block;font-size:.72rem;color:var(--green);">{{ app()->getLocale() === 'ar' ? 'قادم' : 'Upcoming' }}</span>
                        @elseif($event->event_date->isToday())
                            <span style="display:block;font-size:.72rem;color:var(--gold);">{{ app()->getLocale() === 'ar' ? 'اليوم' : 'Today' }}</span>
                        @endif
                    </td>
                    <td>{{ $event->start_time ?? '—' }}</td>
                    <td style="color:#666;">{{ $event->location ?: '—' }}</td>
                    <td>
                        <span class="{{ $event->is_active ? 'badge-confirmed' : 'badge-cancelled' }}">
                            {{ $event->is_active ? (app()->getLocale() === 'ar' ? 'نشط' : 'Active') : (app()->getLocale() === 'ar' ? 'غير نشط' : 'Inactive') }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn-pk-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'حذف هذه الفعالية؟' : 'Delete this event?' }}')">
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
                        {{ app()->getLocale() === 'ar' ? 'لا توجد فعاليات' : 'No events' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
    <div style="margin-top:16px;">{{ $events->links() }}</div>
    @endif
</div>

@endsection
