@extends('layouts.app')
@section('title', app()->getLocale() === 'ar' ? 'الفعاليات والعروض' : 'Events & Shows')
@section('content')

<div style="background:var(--navy);padding:60px 20px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:relative;z-index:1;">
        <div style="font-size:.8rem;color:var(--gold-light);text-transform:uppercase;letter-spacing:.15em;margin-bottom:10px;">
            {{ app()->getLocale() === 'ar' ? 'جرين سيتي الترفيهية' : 'Green City Entertainment' }}
        </div>
        <h1 style="font-family:'Playfair Display',serif;color:#fff;font-size:2.2rem;margin:0 0 12px;">
            {{ app()->getLocale() === 'ar' ? 'الفعاليات والعروض' : 'Events & Shows' }}
        </h1>
        <p style="color:rgba(255,255,255,.6);max-width:480px;margin:0 auto;">
            {{ app()->getLocale() === 'ar' ? 'لا تفوت أحداثنا القادمة المثيرة' : "Don't miss our upcoming exciting events" }}
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @forelse($events as $event)
        <div class="col-md-6">
            <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:24px;box-shadow:0 2px 10px rgba(0,0,0,.05);display:flex;gap:20px;align-items:flex-start;">
                {{-- Date Box --}}
                <div style="background:var(--navy);border-radius:12px;padding:12px 14px;text-align:center;flex-shrink:0;min-width:60px;">
                    <div style="font-family:'Playfair Display',serif;color:var(--gold);font-size:1.8rem;font-weight:700;line-height:1;">{{ $event->event_date->format('d') }}</div>
                    <div style="color:rgba(255,255,255,.7);font-size:.75rem;text-transform:uppercase;margin-top:2px;">{{ $event->event_date->format('M') }}</div>
                    <div style="color:rgba(255,255,255,.4);font-size:.7rem;">{{ $event->event_date->format('Y') }}</div>
                </div>
                {{-- Content --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:8px;">
                        <h3 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.1rem;margin:0;">{{ $event->title }}</h3>
                        @if($event->event_date->isFuture())
                        <span class="badge-confirmed" style="font-size:.72rem;flex-shrink:0;">{{ app()->getLocale() === 'ar' ? 'قادم' : 'Upcoming' }}</span>
                        @endif
                    </div>
                    @if($event->description)
                    <p style="color:#777;font-size:.88rem;margin:0 0 10px;line-height:1.5;">{{ $event->description }}</p>
                    @endif
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        @if($event->location)
                        <span style="font-size:.8rem;color:#888;">
                            <i class="fas fa-map-marker-alt" style="color:var(--gold);margin-inline-end:4px;"></i>{{ $event->location }}
                        </span>
                        @endif
                        @if($event->start_time)
                        <span style="font-size:.8rem;color:#888;">
                            <i class="fas fa-clock" style="color:var(--gold);margin-inline-end:4px;"></i>{{ $event->start_time }}@if($event->end_time) – {{ $event->end_time }}@endif
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12" style="text-align:center;padding:60px;color:#bbb;">
            <i class="fas fa-calendar-times" style="font-size:3rem;opacity:.2;display:block;margin-bottom:16px;"></i>
            {{ app()->getLocale() === 'ar' ? 'لا توجد فعاليات قادمة' : 'No upcoming events' }}
        </div>
        @endforelse
    </div>
    @if($events->hasPages())
    <div style="margin-top:32px;text-align:center;">{{ $events->links() }}</div>
    @endif
</div>

@endsection
