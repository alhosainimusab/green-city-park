@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'إرسال الإشعارات' : 'Send Notifications')
@section('content')

<div style="margin-bottom:24px;">
    <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
        {{ app()->getLocale() === 'ar' ? 'إدارة الإشعارات' : 'Notification Center' }}
    </h2>
    <p style="color:#666;margin:4px 0 0;font-size:.9rem;">
        {{ app()->getLocale() === 'ar' ? 'أرسل إشعارات للزوار بشكل فردي أو جماعي' : 'Send notifications to individual visitors or broadcast to all' }}
    </p>
</div>

<div class="row g-4">

    {{-- ===== SEND FORM ===== --}}
    <div class="col-lg-5">
        <div class="dash-panel" style="position:sticky;top:80px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <div style="width:36px;height:36px;background:var(--navy);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-paper-plane" style="color:var(--gold);font-size:.85rem;"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:var(--navy);">{{ app()->getLocale() === 'ar' ? 'إشعار جديد' : 'New Notification' }}</div>
                    <div style="font-size:.78rem;color:#888;">{{ app()->getLocale() === 'ar' ? 'يصل فوراً لقائمة إشعارات المستخدم' : 'Delivered instantly to user\'s notification list' }}</div>
                </div>
            </div>

            <form action="{{ route('admin.notifications.store') }}" method="POST" id="notifForm">
                @csrf

                {{-- Type --}}
                <div style="margin-bottom:14px;">
                    <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'نوع الإشعار' : 'Notification Type' }}</label>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                        @foreach(['info' => ['#0d6efd','fa-info-circle', app()->getLocale()==='ar'?'معلومة':'Info'],
                                  'success' => ['var(--green)','fa-check-circle', app()->getLocale()==='ar'?'نجاح':'Success'],
                                  'danger' => ['#dc3545','fa-exclamation-circle', app()->getLocale()==='ar'?'تحذير':'Alert']] as $val => $cfg)
                        <label style="cursor:pointer;">
                            <input type="radio" name="type" value="{{ $val }}" {{ old('type','info') === $val ? 'checked' : '' }} style="display:none;" class="type-radio">
                            <div class="type-pill" data-color="{{ $cfg[0] }}" style="text-align:center;padding:8px 4px;border-radius:10px;border:2px solid {{ old('type','info') === $val ? $cfg[0] : 'var(--border)' }};font-size:.78rem;font-weight:600;color:{{ old('type','info') === $val ? $cfg[0] : '#888' }};transition:.2s;">
                                <i class="fas {{ $cfg[1] }}" style="display:block;font-size:1.1rem;margin-bottom:3px;"></i>
                                {{ $cfg[2] }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Target --}}
                <div style="margin-bottom:14px;">
                    <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'المستهدف' : 'Target' }}</label>
                    <div style="display:flex;gap:8px;">
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="target" value="all" {{ old('target','all') === 'all' ? 'checked' : '' }}
                                   onchange="toggleUserSelect(this.value)" style="display:none;">
                            <div class="target-pill {{ old('target','all')==='all'?'target-active':'' }}"
                                 style="text-align:center;padding:9px;border-radius:10px;border:2px solid {{ old('target','all')==='all'?'var(--gold)':'var(--border)' }};font-size:.82rem;font-weight:600;color:{{ old('target','all')==='all'?'var(--gold)':'#888' }};transition:.2s;">
                                <i class="fas fa-users" style="margin-inline-end:5px;"></i>
                                {{ app()->getLocale() === 'ar' ? 'جميع الزوار' : 'All Visitors' }}
                            </div>
                        </label>
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="target" value="user" {{ old('target')==='user' ? 'checked' : '' }}
                                   onchange="toggleUserSelect(this.value)" style="display:none;">
                            <div class="target-pill {{ old('target')==='user'?'target-active':'' }}"
                                 style="text-align:center;padding:9px;border-radius:10px;border:2px solid {{ old('target')==='user'?'var(--gold)':'var(--border)' }};font-size:.82rem;font-weight:600;color:{{ old('target')==='user'?'var(--gold)':'#888' }};transition:.2s;">
                                <i class="fas fa-user" style="margin-inline-end:5px;"></i>
                                {{ app()->getLocale() === 'ar' ? 'زائر معين' : 'Specific Visitor' }}
                            </div>
                        </label>
                    </div>
                </div>

                {{-- User select (hidden unless target=user) --}}
                <div id="userSelectWrap" style="margin-bottom:14px;{{ old('target') !== 'user' ? 'display:none;' : '' }}">
                    <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'اختر الزائر' : 'Select Visitor' }}</label>
                    <select name="user_id" class="pk-input">
                        <option value="">— {{ app()->getLocale() === 'ar' ? 'اختر' : 'Choose' }} —</option>
                        @foreach($visitors as $v)
                        <option value="{{ $v->id }}" {{ old('user_id') == $v->id ? 'selected' : '' }}>
                            {{ $v->name }} ({{ $v->email }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- English content --}}
                <div style="background:var(--cream-light);border-radius:12px;padding:14px;margin-bottom:12px;">
                    <div style="font-size:.75rem;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">
                        🇬🇧 English
                    </div>
                    <div style="margin-bottom:10px;">
                        <label class="pk-label">{{ 'Title' }}</label>
                        <input type="text" name="title_en" class="pk-input" value="{{ old('title_en') }}"
                               placeholder="e.g. Park Update" maxlength="200">
                    </div>
                    <div>
                        <label class="pk-label">{{ 'Message' }}</label>
                        <textarea name="body_en" class="pk-input" rows="3" maxlength="1000"
                                  placeholder="Notification message..." style="resize:none;">{{ old('body_en') }}</textarea>
                    </div>
                </div>

                {{-- Arabic content --}}
                <div style="background:var(--cream-light);border-radius:12px;padding:14px;margin-bottom:16px;" dir="rtl">
                    <div style="font-size:.75rem;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;" dir="ltr">
                        🇾🇪 Arabic
                    </div>
                    <div style="margin-bottom:10px;">
                        <label class="pk-label">{{ 'العنوان' }}</label>
                        <input type="text" name="title_ar" class="pk-input" value="{{ old('title_ar') }}"
                               placeholder="مثال: تحديث من الحديقة" maxlength="200">
                    </div>
                    <div>
                        <label class="pk-label">{{ 'الرسالة' }}</label>
                        <textarea name="body_ar" class="pk-input" rows="3" maxlength="1000"
                                  placeholder="نص الإشعار..." style="resize:none;">{{ old('body_ar') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn-pk-primary" style="width:100%;justify-content:center;padding:12px;">
                    <i class="fas fa-paper-plane"></i>
                    {{ app()->getLocale() === 'ar' ? 'إرسال الإشعار' : 'Send Notification' }}
                </button>
            </form>
        </div>
    </div>

    {{-- ===== SENT NOTIFICATIONS LIST ===== --}}
    <div class="col-lg-7">
        <div class="dash-panel">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div style="font-weight:700;color:var(--navy);font-size:1rem;">
                    {{ app()->getLocale() === 'ar' ? 'الإشعارات المُرسلة' : 'Sent Notifications' }}
                </div>
                <span style="font-size:.78rem;background:var(--cream);padding:3px 10px;border-radius:20px;color:#666;">
                    {{ $notifications->total() }} {{ app()->getLocale() === 'ar' ? 'إشعار' : 'total' }}
                </span>
            </div>

            @forelse($notifications as $n)
            @php
                $typeColor = match($n->type) {
                    'success' => 'var(--green)',
                    'danger'  => '#dc3545',
                    default   => '#0d6efd',
                };
                $typeIcon = match($n->type) {
                    'success' => 'fa-check-circle',
                    'danger'  => 'fa-exclamation-circle',
                    default   => 'fa-info-circle',
                };
                $typeBg = match($n->type) {
                    'success' => 'rgba(45,106,79,.08)',
                    'danger'  => 'rgba(220,53,69,.08)',
                    default   => 'rgba(13,110,253,.08)',
                };
            @endphp
            <div style="display:flex;gap:12px;align-items:flex-start;padding:14px 0;border-bottom:1px solid var(--border);">
                {{-- Type dot --}}
                <div style="width:36px;height:36px;border-radius:10px;background:{{ $typeBg }};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                    <i class="fas {{ $typeIcon }}" style="color:{{ $typeColor }};font-size:.9rem;"></i>
                </div>

                {{-- Content --}}
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:700;color:var(--navy);font-size:.9rem;margin-bottom:2px;">{{ $n->title }}</div>
                    <div style="font-size:.82rem;color:#666;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $n->body }}</div>
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        <span style="font-size:.74rem;color:#999;">
                            <i class="fas fa-user" style="margin-inline-end:3px;"></i>
                            {{ $n->user->name ?? '—' }}
                        </span>
                        <span style="color:#ccc;">·</span>
                        <span style="font-size:.74rem;color:#999;">
                            <i class="fas fa-clock" style="margin-inline-end:3px;"></i>
                            {{ $n->created_at->diffForHumans() }}
                        </span>
                        @if($n->is_read)
                        <span style="font-size:.72rem;background:#e8f5e9;color:#2D6A4F;padding:1px 8px;border-radius:10px;">
                            <i class="fas fa-eye" style="margin-inline-end:3px;"></i>{{ app()->getLocale() === 'ar' ? 'مقروء' : 'Read' }}
                        </span>
                        @else
                        <span style="font-size:.72rem;background:#fff3e0;color:#C8922A;padding:1px 8px;border-radius:10px;">
                            <i class="fas fa-envelope" style="margin-inline-end:3px;"></i>{{ app()->getLocale() === 'ar' ? 'غير مقروء' : 'Unread' }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Delete --}}
                <form action="{{ route('admin.notifications.destroy', $n->id) }}" method="POST"
                      onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'حذف هذا الإشعار؟' : 'Delete this notification?' }}')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:#dc3545;cursor:pointer;opacity:.6;padding:4px 6px;border-radius:6px;font-size:.8rem;"
                            title="{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}"
                            onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=.6">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            @empty
            <div style="text-align:center;padding:40px;color:#bbb;">
                <i class="fas fa-bell-slash" style="font-size:2.5rem;opacity:.3;display:block;margin-bottom:12px;"></i>
                {{ app()->getLocale() === 'ar' ? 'لم يتم إرسال أي إشعارات بعد' : 'No notifications sent yet' }}
            </div>
            @endforelse

            @if($notifications->hasPages())
            <div style="margin-top:16px;display:flex;align-items:center;justify-content:center;gap:4px;">
                {{-- Previous --}}
                @if($notifications->onFirstPage())
                    <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:#ccc;font-size:.82rem;cursor:default;">
                        &lsaquo; {{ app()->getLocale() === 'ar' ? 'السابق' : 'Prev' }}
                    </span>
                @else
                    <a href="{{ $notifications->previousPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--navy);font-size:.82rem;text-decoration:none;">
                        &lsaquo; {{ app()->getLocale() === 'ar' ? 'السابق' : 'Prev' }}
                    </a>
                @endif

                {{-- Page info --}}
                <span style="padding:6px 14px;font-size:.82rem;color:#888;">
                    {{ $notifications->currentPage() }} / {{ $notifications->lastPage() }}
                </span>

                {{-- Next --}}
                @if($notifications->hasMorePages())
                    <a href="{{ $notifications->nextPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--navy);font-size:.82rem;text-decoration:none;">
                        {{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }} &rsaquo;
                    </a>
                @else
                    <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:#ccc;font-size:.82rem;cursor:default;">
                        {{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }} &rsaquo;
                    </span>
                @endif
            </div>
            @endif
        </div>
    </div>

</div>

<script>
function toggleUserSelect(val) {
    document.getElementById('userSelectWrap').style.display = val === 'user' ? '' : 'none';
    // update target pill styles
    document.querySelectorAll('.target-pill').forEach(p => {
        const radio = p.closest('label').querySelector('input');
        const active = radio.value === val;
        p.style.borderColor = active ? 'var(--gold)' : 'var(--border)';
        p.style.color = active ? 'var(--gold)' : '#888';
    });
}

// Type radio visual feedback
document.querySelectorAll('.type-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.type-pill').forEach(p => {
            const r = p.closest('label').querySelector('.type-radio');
            const c = p.dataset.color;
            p.style.borderColor = r.checked ? c : 'var(--border)';
            p.style.color = r.checked ? c : '#888';
        });
    });
});
</script>

@endsection
