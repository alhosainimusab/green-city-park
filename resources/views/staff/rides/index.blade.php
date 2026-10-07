@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'حالة الألعاب' : 'Ride Status')
@section('content')

<div style="margin-bottom:24px;">
    <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
        {{ app()->getLocale() === 'ar' ? 'إدارة حالة الألعاب' : 'Ride Status Management' }}
    </h2>
    <p style="color:#666;margin:4px 0 0;font-size:.9rem;">
        {{ app()->getLocale() === 'ar' ? 'راقب وحدّث حالة الألعاب والازدحام في الوقت الحقيقي' : 'Monitor and update ride statuses and traffic in real time' }}
    </p>
</div>

<div class="row g-4">
    @forelse($rides as $ride)
    <div class="col-md-6 col-lg-4">
        <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.05);">
            {{-- Status bar --}}
            <div style="height:5px;background:{{ $ride->status === 'active' ? 'var(--green)' : ($ride->status === 'maintenance' ? 'var(--gold)' : '#dc3545') }};"></div>
            <div style="padding:18px;">
                {{-- Name + Status badge --}}
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:12px;">
                    <div>
                        <div style="font-weight:700;color:var(--navy);font-size:1rem;">{{ $ride->name }}</div>
                        <div style="font-size:.8rem;color:#888;margin-top:2px;">{{ $ride->category ?? '—' }} · {{ app()->getLocale() === 'ar' ? 'سعة' : 'Cap.' }} {{ $ride->capacity }}</div>
                    </div>
                    <span class="badge-{{ $ride->status }}">
                        @if($ride->status === 'active') {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}
                        @elseif($ride->status === 'maintenance') {{ app()->getLocale() === 'ar' ? 'صيانة' : 'Maintenance' }}
                        @else {{ app()->getLocale() === 'ar' ? 'مغلق' : 'Closed' }}
                        @endif
                    </span>
                </div>

                {{-- Traffic + Wait time row --}}
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding:10px 12px;background:var(--cream-light);border-radius:10px;">
                    @if($ride->status === 'active' && $ride->traffic_level)
                        @php
                            $trafficColor = match($ride->traffic_level) {
                                'low'    => '#2D6A4F',
                                'medium' => '#C8922A',
                                'high'   => '#dc3545',
                                default  => '#999',
                            };
                            $trafficLabel = match($ride->traffic_level) {
                                'low'    => app()->getLocale() === 'ar' ? 'منخفض' : 'Low',
                                'medium' => app()->getLocale() === 'ar' ? 'متوسط' : 'Medium',
                                'high'   => app()->getLocale() === 'ar' ? 'مرتفع' : 'High',
                                default  => '—',
                            };
                            $trafficIcon = match($ride->traffic_level) {
                                'low'    => 'fa-signal',
                                'medium' => 'fa-signal',
                                'high'   => 'fa-signal',
                                default  => 'fa-signal',
                            };
                        @endphp
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $trafficColor }};display:inline-block;flex-shrink:0;"></span>
                            <span style="font-size:.8rem;font-weight:600;color:{{ $trafficColor }};">
                                {{ app()->getLocale() === 'ar' ? 'الازدحام:' : 'Traffic:' }} {{ $trafficLabel }}
                            </span>
                        </div>
                        <div style="width:1px;height:16px;background:var(--border);"></div>
                        @if($ride->wait_time !== null)
                        <div style="display:flex;align-items:center;gap:5px;">
                            <i class="fas fa-clock" style="font-size:.75rem;color:#888;"></i>
                            <span style="font-size:.8rem;color:#555;font-weight:600;">
                                {{ $ride->wait_time }} {{ app()->getLocale() === 'ar' ? 'د انتظار' : 'min wait' }}
                            </span>
                        </div>
                        @endif
                    @else
                        <div style="font-size:.8rem;color:#bbb;font-style:italic;">
                            <i class="fas fa-minus-circle" style="margin-inline-end:4px;"></i>
                            {{ app()->getLocale() === 'ar' ? 'لا توجد بيانات ازدحام' : 'No traffic data' }}
                        </div>
                    @endif
                </div>

                @if($ride->min_height)
                <div style="font-size:.8rem;color:#999;margin-bottom:14px;">
                    <i class="fas fa-ruler-vertical" style="color:var(--gold);margin-inline-end:4px;"></i>
                    {{ app()->getLocale() === 'ar' ? 'الحد الأدنى للطول:' : 'Min height:' }} {{ $ride->min_height }} cm
                </div>
                @endif

                <button type="button" class="btn-pk-sm" style="width:100%;justify-content:center;"
                        data-bs-toggle="modal" data-bs-target="#modal{{ $ride->id }}">
                    <i class="fas fa-edit"></i>
                    {{ app()->getLocale() === 'ar' ? 'تحديث الحالة' : 'Update Status' }}
                </button>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modal{{ $ride->id }}" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 8px 32px rgba(0,0,0,.15);">
                <div style="background:var(--navy);padding:16px 20px;border-radius:16px 16px 0 0;display:flex;align-items:center;justify-content:space-between;">
                    <div style="color:#fff;font-weight:700;font-size:.95rem;">{{ $ride->name }}</div>
                    <button type="button" data-bs-dismiss="modal" style="background:none;border:none;color:rgba(255,255,255,.6);font-size:1.2rem;cursor:pointer;">&times;</button>
                </div>
                <form action="{{ route('staff.rides.status', $ride->id) }}" method="POST" style="padding:20px;">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'الحالة الجديدة' : 'New Status' }}</label>
                        <select name="status" class="pk-input" id="statusSelect{{ $ride->id }}"
                                onchange="toggleTrafficFields({{ $ride->id }}, this.value)">
                            <option value="active"      {{ $ride->status === 'active'      ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? '✅ نشط' : '✅ Active' }}</option>
                            <option value="maintenance" {{ $ride->status === 'maintenance' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? '🔧 صيانة' : '🔧 Maintenance' }}</option>
                            <option value="closed"      {{ $ride->status === 'closed'      ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? '🚫 مغلق' : '🚫 Closed' }}</option>
                        </select>
                    </div>

                    {{-- Traffic fields — shown only when status = active --}}
                    <div id="trafficFields{{ $ride->id }}" style="{{ $ride->status !== 'active' ? 'display:none;' : '' }}">
                        <div style="margin-bottom:14px;">
                            <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'مستوى الازدحام' : 'Traffic Level' }}</label>
                            <select name="traffic_level" class="pk-input">
                                <option value="">— {{ app()->getLocale() === 'ar' ? 'غير محدد' : 'Not set' }} —</option>
                                <option value="low"    {{ $ride->traffic_level === 'low'    ? 'selected' : '' }}>🟢 {{ app()->getLocale() === 'ar' ? 'منخفض' : 'Low' }}</option>
                                <option value="medium" {{ $ride->traffic_level === 'medium' ? 'selected' : '' }}>🟡 {{ app()->getLocale() === 'ar' ? 'متوسط' : 'Medium' }}</option>
                                <option value="high"   {{ $ride->traffic_level === 'high'   ? 'selected' : '' }}>🔴 {{ app()->getLocale() === 'ar' ? 'مرتفع' : 'High' }}</option>
                            </select>
                        </div>
                        <div style="margin-bottom:14px;">
                            <label class="pk-label">
                                {{ app()->getLocale() === 'ar' ? 'وقت الانتظار التقريبي (دقيقة)' : 'Approx. Wait Time (minutes)' }}
                            </label>
                            <input type="number" name="wait_time" class="pk-input"
                                   value="{{ $ride->wait_time }}" min="0" max="999" placeholder="e.g. 15">
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="pk-label">
                            {{ app()->getLocale() === 'ar' ? 'السبب' : 'Reason' }}
                            <span style="font-weight:400;color:#aaa;">({{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }})</span>
                        </label>
                        <textarea name="reason" class="pk-input" rows="2" style="resize:none;"></textarea>
                    </div>
                    <div style="display:flex;gap:8px;">
                        <button type="button" data-bs-dismiss="modal"
                                style="flex:1;padding:10px;border:1px solid var(--border);background:transparent;color:#666;border-radius:8px;cursor:pointer;font-size:.9rem;">
                            {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                        </button>
                        <button type="submit" class="btn-pk-primary" style="flex:2;justify-content:center;padding:10px;">
                            <i class="fas fa-save"></i>
                            {{ app()->getLocale() === 'ar' ? 'حفظ' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12" style="text-align:center;padding:60px;color:#999;">
        <i class="fas fa-rocket" style="font-size:3rem;opacity:.2;display:block;margin-bottom:16px;"></i>
        {{ app()->getLocale() === 'ar' ? 'لا توجد ألعاب' : 'No rides found' }}
    </div>
    @endforelse
</div>

@if($rides->hasPages())
<div style="margin-top:24px;">{{ $rides->links() }}</div>
@endif

<script>
function toggleTrafficFields(rideId, status) {
    const fields = document.getElementById('trafficFields' + rideId);
    if (fields) {
        fields.style.display = status === 'active' ? '' : 'none';
    }
}
</script>

@endsection
