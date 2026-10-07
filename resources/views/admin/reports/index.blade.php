@extends('layouts.dashboard')
@section('title', app()->getLocale() === 'ar' ? 'التقارير' : 'Reports')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Playfair Display',serif;color:var(--navy);font-size:1.6rem;margin:0;">
            {{ app()->getLocale() === 'ar' ? 'التقارير والإحصائيات' : 'Reports & Statistics' }}
        </h2>
        <p style="color:#666;margin:4px 0 0;font-size:.9rem;">{{ app()->getLocale() === 'ar' ? 'سنة' : 'Year' }} {{ $year }}</p>
    </div>
    <form style="display:flex;gap:8px;align-items:center;">
        <select name="year" class="pk-input" style="width:auto;padding:8px 14px;">
            @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn-pk-sm">
            <i class="fas fa-filter"></i>
            {{ app()->getLocale() === 'ar' ? 'عرض' : 'View' }}
        </button>
    </form>
</div>

{{-- Summary Metrics --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="mc-icon" style="background:rgba(200,146,42,.12);">
                <i class="fas fa-coins" style="color:var(--gold);"></i>
            </div>
            <div class="mc-value">{{ number_format($totalRevenue / 1000, 1) }}K</div>
            <div class="mc-label">{{ app()->getLocale() === 'ar' ? 'إجمالي الإيرادات' : 'Total Revenue' }} ({{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }})</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="mc-icon" style="background:rgba(27,43,58,.1);">
                <i class="fas fa-calendar-check" style="color:var(--navy);"></i>
            </div>
            <div class="mc-value">{{ $totalBookings }}</div>
            <div class="mc-label">{{ app()->getLocale() === 'ar' ? 'إجمالي الحجوزات' : 'Total Bookings' }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="mc-icon" style="background:rgba(45,106,79,.1);">
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
            </div>
            <div class="mc-value">{{ $confirmedBookings }}</div>
            <div class="mc-label">{{ app()->getLocale() === 'ar' ? 'حجوزات مؤكدة' : 'Confirmed Bookings' }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Revenue Chart --}}
    <div class="col-lg-8">
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 20px;font-size:1.1rem;">
                <i class="fas fa-chart-line" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'الإيرادات الشهرية' : 'Monthly Revenue' }} {{ $year }}
            </h4>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>

    {{-- Ticket Breakdown --}}
    <div class="col-lg-4">
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 20px;font-size:1.1rem;">
                <i class="fas fa-ticket-alt" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'مبيعات التذاكر' : 'Ticket Sales' }}
            </h4>
            @php $totalTickets = $ticketStats->sum('count'); @endphp
            @foreach($ticketStats as $stat)
            @php $pct = $totalTickets > 0 ? round($stat->count / $totalTickets * 100) : 0; @endphp
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:.88rem;">
                    <span style="font-weight:600;color:var(--navy);">
                        @if($stat->ticket_type === 'adult') {{ app()->getLocale() === 'ar' ? 'بالغ' : 'Adult' }}
                        @elseif($stat->ticket_type === 'child') {{ app()->getLocale() === 'ar' ? 'طفل' : 'Child' }}
                        @else {{ app()->getLocale() === 'ar' ? 'مجموعة' : 'Group' }}
                        @endif
                    </span>
                    <span style="color:#888;">{{ $stat->count }} ({{ $pct }}%)</span>
                </div>
                <div style="height:8px;background:var(--cream);border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ ['adult'=>'var(--gold)','child'=>'var(--green)','group'=>'var(--navy)'][$stat->ticket_type] ?? '#aaa' }};border-radius:4px;transition:width .4s;"></div>
                </div>
                <div style="font-size:.78rem;color:#999;margin-top:3px;">{{ number_format($stat->revenue) }} {{ app()->getLocale() === 'ar' ? 'ريال' : 'YER' }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Top Promotions --}}
    <div class="col-md-6">
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                <i class="fas fa-tags" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'أفضل العروض' : 'Top Promotions' }}
            </h4>
            <table class="pk-table">
                <thead>
                    <tr>
                        <th>{{ app()->getLocale() === 'ar' ? 'الكود' : 'Code' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'الاستخدامات' : 'Uses' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPromotions as $p)
                    <tr>
                        <td><span style="font-family:monospace;font-size:.85rem;background:var(--navy);color:var(--gold-light);padding:2px 8px;border-radius:4px;">{{ $p->code }}</span></td>
                        <td style="font-weight:700;color:var(--navy);">{{ $p->bookings_count }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" style="text-align:center;padding:24px;color:#999;">—</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ride Status --}}
    <div class="col-md-6">
        <div class="dash-panel">
            <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0 0 16px;font-size:1.1rem;">
                <i class="fas fa-rocket" style="color:var(--gold);margin-inline-end:8px;"></i>
                {{ app()->getLocale() === 'ar' ? 'حالة الألعاب' : 'Ride Status Summary' }}
            </h4>
            @foreach(['active' => [app()->getLocale() === 'ar' ? 'نشط' : 'Active', 'var(--green)'], 'maintenance' => [app()->getLocale() === 'ar' ? 'صيانة' : 'Maintenance', 'var(--gold)'], 'closed' => [app()->getLocale() === 'ar' ? 'مغلق' : 'Closed', '#dc3545']] as $status => $info)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--border);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:10px;height:10px;border-radius:50%;background:{{ $info[1] }};"></div>
                    <span style="color:#555;">{{ $info[0] }}</span>
                </div>
                <strong style="color:var(--navy);font-size:1.1rem;">{{ $rideStatusSummary[$status] ?? 0 }}</strong>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const months = {!! json_encode(array_map(fn($m) => date('M', mktime(0,0,0,$m,1)), range(1,12))) !!};
const revenue = {!! json_encode(array_values((array) $revenueData)) !!};
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: '{{ app()->getLocale() === "ar" ? "الإيرادات" : "Revenue" }}',
            data: revenue,
            backgroundColor: 'rgba(200,146,42,0.7)',
            borderColor: 'var(--gold)',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush

@endsection
