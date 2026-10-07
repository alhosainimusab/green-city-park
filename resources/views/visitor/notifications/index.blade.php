@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">
            {{ app()->getLocale() === 'ar' ? 'آخر التحديثات والرسائل' : 'Latest updates and messages' }}
        </p>
    </div>
    @if($notifications->total() > 0)
    <span style="background:var(--cream);border:1px solid var(--border);padding:6px 14px;border-radius:20px;font-size:.85rem;color:#666;">
        {{ $notifications->total() }} {{ app()->getLocale() === 'ar' ? 'إشعار' : 'notification(s)' }}
    </span>
    @endif
</div>

<div class="dash-panel" style="padding:0;overflow:hidden;">
    @forelse($notifications as $notif)
    @php
        $iconColor = match($notif->type) {
            'success' => '#2D6A4F',
            'danger'  => '#dc3545',
            default   => 'var(--gold)',
        };
        $iconClass = match($notif->type) {
            'success' => 'fa-check-circle',
            'danger'  => 'fa-exclamation-circle',
            default   => 'fa-bell',
        };
    @endphp
    <div style="display:flex;align-items:flex-start;gap:16px;padding:18px 22px;border-bottom:1px solid var(--border);background:{{ !$notif->is_read ? 'rgba(200,146,42,.04)' : '#fff' }};">
        <div style="width:40px;height:40px;border-radius:50%;background:{{ !$notif->is_read ? 'rgba(200,146,42,.12)' : 'var(--cream)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
            <i class="fas {{ $iconClass }}" style="color:{{ $iconColor }};font-size:1rem;"></i>
        </div>
        <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                <div style="font-weight:{{ !$notif->is_read ? '700' : '600' }};color:var(--navy);font-size:.95rem;">
                    {{ $notif->title }}
                </div>
                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                    @if(!$notif->is_read)
                        <span style="width:8px;height:8px;background:var(--gold);border-radius:50%;display:inline-block;"></span>
                        <span style="font-size:.75rem;color:var(--gold);font-weight:600;">{{ app()->getLocale() === 'ar' ? 'جديد' : 'New' }}</span>
                    @endif
                    <span style="font-size:.75rem;color:#bbb;">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @if($notif->body)
            <div style="color:#666;font-size:.88rem;margin-top:4px;line-height:1.5;">{{ $notif->body }}</div>
            @endif
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px 20px;color:#bbb;">
        <i class="fas fa-bell-slash" style="font-size:3rem;display:block;margin-bottom:16px;opacity:.3;"></i>
        <p>{{ app()->getLocale() === 'ar' ? 'لا توجد إشعارات' : 'No notifications yet' }}</p>
    </div>
    @endforelse
</div>

@if($notifications->hasPages())
<div style="margin-top:16px;">{{ $notifications->links() }}</div>
@endif

@endsection
