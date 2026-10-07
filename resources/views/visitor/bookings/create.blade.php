@extends('layouts.app')
@section('title', app()->getLocale() === 'ar' ? 'احجز تذكرتك' : 'Book Tickets')

@section('content')

{{-- Mini navbar override for booking page --}}
<div style="background:var(--white);border-bottom:1px solid var(--border);padding:9px 22px;display:flex;align-items:center;gap:6px;font-size:12px;position:sticky;top:56px;z-index:100;">
    <a href="{{ route('home') }}" style="color:var(--gold);font-weight:700;text-decoration:none;">{{ app()->getLocale() === 'ar' ? 'احجز التذاكر' : 'Book Tickets' }}</a>
    <span style="color:var(--border);">›</span>
    <span style="color:var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'اختر التاريخ والتذاكر' : 'Select date & tickets' }}</span>
    <span style="color:var(--border);">›</span>
    <span style="color:var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'الدفع' : 'Payment' }}</span>
    <span style="color:var(--border);">›</span>
    <span style="color:var(--text-muted);">{{ app()->getLocale() === 'ar' ? 'التأكيد' : 'Confirmation' }}</span>
</div>

<form action="{{ route('visitor.bookings.store') }}" method="POST" id="bookingForm">
@csrf
<input type="hidden" name="visit_date"  id="selected_date">
<input type="hidden" name="adult_qty"   id="adult_qty_inp"  value="0">
<input type="hidden" name="child_qty"   id="child_qty_inp"  value="0">
<input type="hidden" name="group_qty"   id="group_qty_inp"  value="0">
<input type="hidden" name="infant_qty"  id="infant_qty_inp" value="0">

<div class="booking-layout">
    {{-- Left: Steps --}}
    <div class="booking-left">

        @if($errors->any())
        <div class="pk-alert pk-alert-error mb-3">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif

        {{-- Step 1: Date --}}
        <div class="step-block">
            <div class="step-header">
                <div class="step-num">1</div>
                <div class="step-title">{{ app()->getLocale() === 'ar' ? 'اختر تاريخ الزيارة' : 'Select Visit Date' }}</div>
            </div>
            <div class="cal-wrap">
                <div class="cal-header">
                    <span class="cal-month" id="calMonthLabel"></span>
                    <div>
                        <button type="button" class="cal-nav-btn" onclick="calPrev()">‹</button>
                        <button type="button" class="cal-nav-btn" onclick="calNext()">›</button>
                    </div>
                </div>
                <div class="cal-grid" id="calGrid"></div>
            </div>
        </div>

        {{-- Step 2: Tickets --}}
        <div class="step-block">
            <div class="step-header">
                <div class="step-num">2</div>
                <div class="step-title">{{ app()->getLocale() === 'ar' ? 'اختر التذاكر' : 'Select Tickets' }}</div>
            </div>

            {{-- Adult --}}
            <div class="ticket-opt" style="display:flex;align-items:center;gap:12px;cursor:default;" id="row-adult">
                <div style="flex:1;">
                    <div class="t-name">{{ app()->getLocale() === 'ar' ? 'بالغ' : 'Adult' }}</div>
                    <div class="t-desc">{{ app()->getLocale() === 'ar' ? '13 سنة فأكثر' : 'Ages 13 and above' }}</div>
                </div>
                <div class="t-price" style="min-width:90px;text-align:end;">1,500 YER</div>
                <div class="qty-control" style="margin:0;">
                    <button type="button" class="qty-btn" onclick="changeQty('adult',-1)">−</button>
                    <span class="qty-val" id="qty-adult">0</span>
                    <button type="button" class="qty-btn" onclick="changeQty('adult',1)">+</button>
                </div>
            </div>

            {{-- Child --}}
            <div class="ticket-opt" style="display:flex;align-items:center;gap:12px;cursor:default;" id="row-child">
                <div style="flex:1;">
                    <div class="t-name">{{ app()->getLocale() === 'ar' ? 'طفل' : 'Child' }}</div>
                    <div class="t-desc">{{ app()->getLocale() === 'ar' ? '3–12 سنة' : 'Ages 3–12' }}</div>
                </div>
                <div class="t-price" style="min-width:90px;text-align:end;">800 YER</div>
                <div class="qty-control" style="margin:0;">
                    <button type="button" class="qty-btn" onclick="changeQty('child',-1)">−</button>
                    <span class="qty-val" id="qty-child">0</span>
                    <button type="button" class="qty-btn" onclick="changeQty('child',1)">+</button>
                </div>
            </div>

            {{-- Infant --}}
            <div class="ticket-opt" style="display:flex;align-items:center;gap:12px;cursor:default;border:1px dashed rgba(45,106,79,.3);background:rgba(45,106,79,.03);" id="row-infant">
                <div style="flex:1;">
                    <div class="t-name" style="color:var(--green);">{{ app()->getLocale() === 'ar' ? 'رضيع' : 'Infant' }}</div>
                    <div class="t-desc">{{ app()->getLocale() === 'ar' ? '1–3 سنوات' : 'Ages 1–3 years' }}</div>
                </div>
                <div class="t-price" style="min-width:90px;text-align:end;color:var(--green);font-weight:700;">
                    {{ app()->getLocale() === 'ar' ? 'مجاني' : 'FREE' }}
                </div>
                <div class="qty-control" style="margin:0;">
                    <button type="button" class="qty-btn" onclick="changeQty('infant',-1)">−</button>
                    <span class="qty-val" id="qty-infant">0</span>
                    <button type="button" class="qty-btn" onclick="changeQty('infant',1)">+</button>
                </div>
            </div>

            {{-- Group --}}
            <div class="ticket-opt" style="display:flex;align-items:center;gap:12px;cursor:default;" id="row-group">
                <div style="flex:1;">
                    <div class="t-name">{{ app()->getLocale() === 'ar' ? 'مجموعة' : 'Group' }}</div>
                    <div class="t-desc">{{ app()->getLocale() === 'ar' ? '10 أشخاص على الأقل · سعر مخفض' : 'Min. 10 persons · discounted rate' }}</div>
                </div>
                <div class="t-price" style="min-width:90px;text-align:end;">1,200 YER</div>
                <div class="qty-control" style="margin:0;">
                    <button type="button" class="qty-btn" onclick="changeQty('group',-1)">−</button>
                    <span class="qty-val" id="qty-group">0</span>
                    <button type="button" class="qty-btn" onclick="changeQty('group',1)">+</button>
                </div>
            </div>

            {{-- Group warning --}}
            <div id="groupWarning" style="display:none;margin-top:10px;background:#fff8e1;border:1px solid #ffe082;border-radius:10px;padding:10px 14px;font-size:.82rem;color:#b45309;">
                <i class="fas fa-exclamation-triangle" style="margin-inline-end:6px;"></i>
                {{ app()->getLocale() === 'ar' ? 'تذاكر المجموعة تتطلب 10 أشخاص على الأقل' : 'Group tickets require a minimum of 10 persons' }}
            </div>
        </div>

        {{-- Step 3: Promo --}}
        <div class="step-block">
            <div class="step-header">
                <div class="step-num">3</div>
                <div class="step-title">
                    {{ app()->getLocale() === 'ar' ? 'كود الخصم' : 'Promotional Code' }}
                    <span style="font-size:10px;color:var(--text-muted);font-weight:400;"> ({{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }})</span>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <input type="text" name="promo_code" id="promoInput" class="pk-input"
                       placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: WELCOME20' : 'e.g. WELCOME20' }}"
                       style="flex:1;text-transform:uppercase;" value="{{ old('promo_code') }}">
                <button type="button" onclick="applyPromo()" class="btn-pk-sm btn-pk-gold" style="padding:8px 16px;font-size:12px;">
                    {{ app()->getLocale() === 'ar' ? 'تطبيق' : 'Apply' }}
                </button>
            </div>
            <div id="promoMsg" style="margin-top:5px;font-size:11px;"></div>
            <input type="hidden" name="promo_applied" id="promoApplied" value="">
        </div>

    </div>

    {{-- Right: Order Summary --}}
    <div class="booking-right">
        <div class="order-summary">
            <div class="os-title">{{ app()->getLocale() === 'ar' ? 'ملخص الطلب' : 'Order Summary' }}</div>

            <div class="order-row">
                <span class="or-label">{{ app()->getLocale() === 'ar' ? 'تاريخ الزيارة' : 'Visit date' }}</span>
                <span class="or-val" id="sumDate">— {{ app()->getLocale() === 'ar' ? 'اختر تاريخاً' : 'Select a date' }}</span>
            </div>

            {{-- Per-type breakdown --}}
            <div id="ticketBreakdown" style="border-top:1px solid var(--border);padding-top:8px;margin-top:4px;">
                <div style="color:#aaa;font-size:.82rem;font-style:italic;">
                    {{ app()->getLocale() === 'ar' ? 'أضف تذاكر للمتابعة' : 'Add tickets to continue' }}
                </div>
            </div>

            <div class="order-row" style="border-top:1px solid var(--border);padding-top:8px;margin-top:4px;">
                <span class="or-label">{{ app()->getLocale() === 'ar' ? 'المجموع الفرعي' : 'Subtotal' }}</span>
                <span class="or-val" id="sumSub">0 YER</span>
            </div>
            <div class="order-row or-disc" id="discRow" style="display:none;">
                <span class="or-label">{{ app()->getLocale() === 'ar' ? 'الخصم' : 'Discount' }}</span>
                <span class="or-val" id="sumDisc">—</span>
            </div>
            <div class="order-total">
                <span>{{ app()->getLocale() === 'ar' ? 'الإجمالي' : 'Total' }}</span>
                <span id="sumTotal">0 YER</span>
            </div>
        </div>

        <div class="pay-box">
            <div class="pay-box-title">💳 {{ app()->getLocale() === 'ar' ? 'تعليمات الدفع' : 'Payment Instructions' }}</div>
            <div class="pay-box-text">
                {{ app()->getLocale() === 'ar' ? 'حوّل' : 'Transfer' }} <strong id="payAmt">0 YER</strong> {{ app()->getLocale() === 'ar' ? 'إلى:' : 'to:' }}<br>
                <strong>{{ app()->getLocale() === 'ar' ? 'صرافة محسن الخضر' : 'Mohsen Al-Khader Exchange Co.' }}</strong><br>
                {{ app()->getLocale() === 'ar' ? 'الحساب:' : 'Account:' }} <strong>1234-5678-90</strong><br>
                {{ app()->getLocale() === 'ar' ? 'عبر التطبيق أو الفرع أو الحوالة.' : 'Via app, branch, or mobile transfer.' }}
            </div>
        </div>

        <div style="margin-bottom:12px;">
            <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'رقم مرجع التحويل *' : 'Transfer Reference Number *' }}</label>
            <input type="text" name="reference_no" class="pk-input"
                   placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: TRF-20260615-XXXX' : 'e.g. TRF-20260615-XXXX' }}" required>
        </div>

        <div style="margin-bottom:12px;">
            <label class="pk-label">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</label>
            <select name="payment_method" class="pk-input">
                <option value="exchange_transfer">{{ __('messages.exchange_transfer') }}</option>
                <option value="cash_at_gate">{{ __('messages.cash_at_gate') }}</option>
            </select>
        </div>

        <button type="submit" class="btn-confirm">
            🎫 {{ app()->getLocale() === 'ar' ? 'تأكيد الحجز والحصول على التذكرة' : 'Confirm Booking & Get QR Ticket' }}
        </button>
        <div style="text-align:center;font-size:10px;color:var(--text-muted);margin-top:6px;">
            {{ app()->getLocale() === 'ar' ? 'تظهر تذكرة QR فور التأكيد' : 'QR-code ticket appears instantly after confirmation' }}
        </div>
    </div>
</div>
</form>

@push('scripts')
<script>
const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const DAYS   = ['Su','Mo','Tu','We','Th','Fr','Sa'];
const PRICES = { adult:1500, child:800, group:1200, infant:0 };
const LABELS = {
    adult:  '{{ app()->getLocale() === 'ar' ? 'بالغ' : 'Adult' }}',
    child:  '{{ app()->getLocale() === 'ar' ? 'طفل' : 'Child' }}',
    group:  '{{ app()->getLocale() === 'ar' ? 'مجموعة' : 'Group' }}',
    infant: '{{ app()->getLocale() === 'ar' ? 'رضيع' : 'Infant' }}',
};
const FREE_LBL = '{{ app()->getLocale() === 'ar' ? 'مجاني' : 'Free' }}';
const YER_LBL  = 'YER';

let calY, calM, selDate = null, discount = 0;
const qtys = { adult:0, child:0, group:0, infant:0 };

// ── Calendar ──────────────────────────────────────────
function initCal() {
    const now = new Date();
    calY = now.getFullYear(); calM = now.getMonth();
    renderCal();
}
function renderCal() {
    document.getElementById('calMonthLabel').textContent = MONTHS[calM] + ' ' + calY;
    const first = new Date(calY, calM, 1).getDay();
    const days  = new Date(calY, calM+1, 0).getDate();
    const today = new Date();
    let html = DAYS.map(d => `<div class="cal-day cal-hdr">${d}</div>`).join('');
    for (let i = 0; i < first; i++) html += '<div class="cal-day cal-empty"></div>';
    for (let d = 1; d <= days; d++) {
        const ds    = `${calY}-${String(calM+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const dt    = new Date(calY, calM, d);
        const isPast= dt < new Date(today.toDateString());
        const isSel = ds === selDate;
        const isTod = d === today.getDate() && calM === today.getMonth() && calY === today.getFullYear();
        let cls = 'cal-day';
        if (isPast) cls += ' cal-past';
        else if (isSel) cls += ' cal-sel';
        else if (isTod) cls += ' cal-today';
        const onclick = isPast ? '' : `onclick="pickDate('${ds}')"`;
        html += `<div class="${cls}" ${onclick}>${d}</div>`;
    }
    document.getElementById('calGrid').innerHTML = html;
}
function calPrev() { if(calM===0){calM=11;calY--;}else calM--; renderCal(); }
function calNext() { if(calM===11){calM=0;calY++;}else calM++; renderCal(); }
function pickDate(d) {
    selDate = d;
    document.getElementById('selected_date').value = d;
    renderCal();
    const p = d.split('-');
    document.getElementById('sumDate').textContent = `${parseInt(p[2])} ${MONTHS[parseInt(p[1])-1]} ${p[0]}`;
}

// ── Ticket quantity ───────────────────────────────────
function changeQty(type, delta) {
    let val = qtys[type] + delta;
    if (type === 'group') {
        if (val < 0) val = 0;
        else if (val > 0 && val < 10) val = delta > 0 ? 10 : 0; // snap: 0 or 10+
    } else {
        val = Math.max(0, val);
    }
    qtys[type] = val;
    document.getElementById('qty-' + type).textContent = val;
    document.getElementById(type + '_qty_inp').value = val;
    updateSummary();
}

// ── Promo ─────────────────────────────────────────────
function applyPromo() {
    const code = document.getElementById('promoInput').value.trim().toUpperCase();
    if (!code) return;
    const sub = (qtys.adult*1500)+(qtys.child*800)+(qtys.group*1200);
    if (sub === 0) {
        document.getElementById('promoMsg').innerHTML =
            `<span style="color:orange;">{{ app()->getLocale() === 'ar' ? 'أضف تذاكر أولاً' : 'Add tickets first' }}</span>`;
        return;
    }
    fetch(`/api/promo-check?code=${encodeURIComponent(code)}&amount=${sub}`)
        .then(r => r.json())
        .then(data => {
            const msg = document.getElementById('promoMsg');
            if (data.valid) {
                discount = data.discount;
                document.getElementById('promoApplied').value = code;
                msg.innerHTML = `<span style="color:var(--green);font-weight:700;">✓ ${code} applied — ${data.discount.toLocaleString()} YER off</span>`;
            } else {
                discount = 0;
                document.getElementById('promoApplied').value = '';
                msg.innerHTML = `<span style="color:#C0392B;">✗ {{ app()->getLocale() === 'ar' ? 'كود غير صالح أو منتهي الصلاحية' : 'Invalid or expired promo code.' }}</span>`;
            }
            updateSummary();
        })
        .catch(() => { discount = 0; updateSummary(); });
}

// ── Summary ───────────────────────────────────────────
function updateSummary() {
    const sub   = (qtys.adult*1500) + (qtys.child*800) + (qtys.group*1200);
    const total = Math.max(0, sub - discount);

    // Build per-type lines
    let html = '';
    if (qtys.adult  > 0) html += `<div class="order-row"><span class="or-label">${LABELS.adult} × ${qtys.adult}</span><span class="or-val">${(qtys.adult*1500).toLocaleString()} ${YER_LBL}</span></div>`;
    if (qtys.child  > 0) html += `<div class="order-row"><span class="or-label">${LABELS.child} × ${qtys.child}</span><span class="or-val">${(qtys.child*800).toLocaleString()} ${YER_LBL}</span></div>`;
    if (qtys.group  > 0) html += `<div class="order-row"><span class="or-label">${LABELS.group} × ${qtys.group}</span><span class="or-val">${(qtys.group*1200).toLocaleString()} ${YER_LBL}</span></div>`;
    if (qtys.infant > 0) html += `<div class="order-row"><span class="or-label">${LABELS.infant} × ${qtys.infant}</span><span class="or-val" style="color:var(--green);">${FREE_LBL}</span></div>`;
    if (!html) html = `<div style="color:#aaa;font-size:.82rem;font-style:italic;">{{ app()->getLocale() === 'ar' ? 'أضف تذاكر للمتابعة' : 'Add tickets to continue' }}</div>`;
    document.getElementById('ticketBreakdown').innerHTML = html;

    document.getElementById('sumSub').textContent   = sub.toLocaleString() + ' YER';
    document.getElementById('sumTotal').textContent = total.toLocaleString() + ' YER';
    document.getElementById('payAmt').textContent   = total.toLocaleString() + ' YER';

    const dr = document.getElementById('discRow');
    if (discount > 0) { dr.style.display='flex'; document.getElementById('sumDisc').textContent='−'+discount.toLocaleString()+' YER'; }
    else dr.style.display='none';

    // Group minimum warning
    document.getElementById('groupWarning').style.display =
        (qtys.group > 0 && qtys.group < 10) ? 'block' : 'none';
}

initCal();
updateSummary();
</script>
@endpush
@endsection
