@extends('layouts.app')
@section('title', app()->getLocale() === 'ar' ? 'خريطة الحديقة' : 'Park Map')

@section('content')

{{-- Page Hero --}}
<div style="background:var(--navy);padding:40px 20px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:url('data:image/svg+xml,%3Csvg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23C8922A\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 20.83l2.83-2.83 1.41 1.41L1.41 22.24H0v-1.41zM0 3.06l2.83-2.83 1.41 1.41L1.41 4.47H0V3.06z\"%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E') repeat;opacity:.4;"></div>
    <div style="position:relative;z-index:1;">
        <div style="font-size:.8rem;color:var(--gold-light);text-transform:uppercase;letter-spacing:.15em;margin-bottom:10px;">
            {{ app()->getLocale() === 'ar' ? 'جرين سيتي الترفيهية' : 'Green City Entertainment' }}
        </div>
        <h1 style="font-family:'Playfair Display',serif;color:#fff;font-size:2.2rem;margin:0 0 12px;">
            {{ app()->getLocale() === 'ar' ? 'خريطة الحديقة التفاعلية' : 'Interactive Park Map' }}
        </h1>
        <p style="color:rgba(255,255,255,.6);max-width:480px;margin:0 auto;">
            {{ app()->getLocale() === 'ar' ? '7 مناطق ترفيهية — مأرب، اليمن' : '7 Entertainment Zones — Marib, Yemen' }}
        </p>
    </div>
</div>

<div style="background:var(--cream-light);padding:24px 20px;">

    {{-- SVG Map --}}
    <div style="background:#fff;border-radius:14px;border:1px solid var(--border);padding:20px;margin-bottom:20px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow-x:auto;">
        <svg width="100%" viewBox="0 0 800 480" style="border-radius:8px;min-width:560px;">
            <rect width="800" height="480" fill="#d4edda" rx="8"/>

            {{-- Entry Gate --}}
            <rect x="380" y="420" width="40" height="55" fill="#D4C5A9" rx="3"/>
            <text x="400" y="452" text-anchor="middle" font-size="9" font-family="sans-serif" fill="#1B2B3A" font-weight="bold">ENTRY</text>
            <text x="400" y="464" text-anchor="middle" font-size="8" font-family="sans-serif" fill="#1B2B3A">البوابة</text>

            {{-- Zone A: Thrill Rides --}}
            <rect x="290" y="275" width="155" height="135" fill="#FFD6D6" rx="12" stroke="#C0392B" stroke-width="2.5"/>
            <text x="367" y="297" text-anchor="middle" font-size="12" fill="#C0392B" font-weight="bold" font-family="Georgia,serif">Zone A</text>
            <text x="367" y="313" text-anchor="middle" font-size="10" fill="#C0392B" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'ألعاب المغامرة' : 'Thrill Rides' }}</text>
            <text x="367" y="340" text-anchor="middle" font-size="22">🎢</text>
            <text x="330" y="365" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'القطار' : 'Roller Coaster' }}</text>
            <text x="404" y="365" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'السيارات' : 'Bumper Cars' }}</text>
            <text x="367" y="383" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'برج السقوط' : 'Free Fall Tower' }}</text>

            {{-- Zone B: Family Zone --}}
            <rect x="100" y="258" width="168" height="148" fill="#D6E8FF" rx="12" stroke="#2980B9" stroke-width="2.5"/>
            <text x="184" y="280" text-anchor="middle" font-size="12" fill="#2980B9" font-weight="bold" font-family="Georgia,serif">Zone B</text>
            <text x="184" y="296" text-anchor="middle" font-size="10" fill="#2980B9" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'منطقة العائلة' : 'Family Zone' }}</text>
            <text x="184" y="322" text-anchor="middle" font-size="22">🎡</text>
            <text x="148" y="350" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'عجلة فيريس' : 'Ferris Wheel' }}</text>
            <text x="220" y="350" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'الخيول' : 'Carousel' }}</text>
            <text x="184" y="370" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'القطار الصغير' : 'Mini Train' }}</text>

            {{-- Zone C: Water Zone --}}
            <rect x="462" y="265" width="165" height="155" fill="#D6F5FF" rx="12" stroke="#16A085" stroke-width="2.5"/>
            <text x="544" y="287" text-anchor="middle" font-size="12" fill="#16A085" font-weight="bold" font-family="Georgia,serif">Zone C</text>
            <text x="544" y="303" text-anchor="middle" font-size="10" fill="#16A085" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'منطقة المياه' : 'Water Zone' }}</text>
            <text x="544" y="330" text-anchor="middle" font-size="22">🌊</text>
            <text x="510" y="358" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'زلاقة الماء' : 'Water Slide' }}</text>
            <text x="578" y="358" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'بحرة الأمواج' : 'Wave Pool' }}</text>
            <text x="544" y="378" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'النهر الكسول' : 'Lazy River' }}</text>

            {{-- Zone D: Sabaean Theatre (center) --}}
            <ellipse cx="400" cy="152" rx="142" ry="96" fill="#FDF6E3" stroke="#C8922A" stroke-width="3"/>
            <text x="400" y="120" text-anchor="middle" font-size="12" fill="#C8922A" font-weight="bold" font-family="Georgia,serif">Zone D</text>
            <text x="400" y="136" text-anchor="middle" font-size="10" fill="#C8922A" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'مسرح سبأ' : 'Sabaean Theatre' }}</text>
            <text x="400" y="160" text-anchor="middle" font-size="24">🎭</text>
            <text x="400" y="184" text-anchor="middle" font-size="8" fill="#8B7355" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? '600 مقعد — مسرح ثقافي' : '600-Seat Cultural Theatre' }}</text>
            <text x="400" y="198" text-anchor="middle" font-size="8" fill="#8B7355" font-family="sans-serif">مسرح السبئية — مأرب</text>

            {{-- Zone E: Games Arcade --}}
            <rect x="638" y="138" width="142" height="122" fill="#F0D6FF" rx="12" stroke="#8E44AD" stroke-width="2.5"/>
            <text x="709" y="160" text-anchor="middle" font-size="12" fill="#8E44AD" font-weight="bold" font-family="Georgia,serif">Zone E</text>
            <text x="709" y="176" text-anchor="middle" font-size="10" fill="#8E44AD" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'الألعاب الإلكترونية' : 'Games Arcade' }}</text>
            <text x="709" y="200" text-anchor="middle" font-size="22">🕹</text>
            <text x="709" y="228" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'ألعاب إلكترونية' : 'Electronic Games' }}</text>
            <text x="709" y="244" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'محطة الواقع الافتراضي' : 'VR Station' }}</text>

            {{-- Zone F: Food & Retail --}}
            <rect x="18" y="106" width="162" height="130" fill="#D6FFE8" rx="12" stroke="#2D6A4F" stroke-width="2.5"/>
            <text x="99" y="128" text-anchor="middle" font-size="12" fill="#2D6A4F" font-weight="bold" font-family="Georgia,serif">Zone F</text>
            <text x="99" y="144" text-anchor="middle" font-size="10" fill="#2D6A4F" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'الطعام والتسوق' : 'Food & Retail' }}</text>
            <text x="99" y="168" text-anchor="middle" font-size="22">🍽</text>
            <text x="68" y="196" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'مطاعم' : 'Restaurants' }}</text>
            <text x="132" y="196" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'محلات' : 'Shops' }}</text>
            <text x="99" y="216" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'صالة العائلة' : 'Family Lounge' }}</text>

            {{-- Zone G: Kids Zone --}}
            <rect x="638" y="288" width="142" height="122" fill="#FFE8D6" rx="12" stroke="#E67E22" stroke-width="2.5"/>
            <text x="709" y="310" text-anchor="middle" font-size="12" fill="#E67E22" font-weight="bold" font-family="Georgia,serif">Zone G</text>
            <text x="709" y="326" text-anchor="middle" font-size="10" fill="#E67E22" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'منطقة الأطفال' : 'Kids Zone' }}</text>
            <text x="709" y="350" text-anchor="middle" font-size="22">🎠</text>
            <text x="678" y="378" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'ملعب' : 'Playground' }}</text>
            <text x="740" y="378" text-anchor="middle" font-size="8" fill="#666" font-family="sans-serif">{{ app()->getLocale() === 'ar' ? 'العاب ناعمة' : 'Soft Play' }}</text>

            {{-- Walking paths --}}
            <line x1="268" y1="342" x2="290" y2="342" stroke="#8B7355" stroke-width="3" stroke-dasharray="5,3" opacity=".7"/>
            <line x1="445" y1="342" x2="462" y2="342" stroke="#8B7355" stroke-width="3" stroke-dasharray="5,3" opacity=".7"/>
            <line x1="627" y1="342" x2="638" y2="350" stroke="#8B7355" stroke-width="3" stroke-dasharray="5,3" opacity=".7"/>
            <line x1="180" y1="258" x2="290" y2="315" stroke="#8B7355" stroke-width="2" stroke-dasharray="4,3" opacity=".5"/>
            <line x1="627" y1="228" x2="638" y2="238" stroke="#8B7355" stroke-width="2" stroke-dasharray="4,3" opacity=".5"/>
            <line x1="180" y1="236" x2="260" y2="200" stroke="#8B7355" stroke-width="2" stroke-dasharray="4,3" opacity=".4"/>

            {{-- Compass --}}
            <circle cx="750" cy="48" r="22" fill="#1B2B3A" opacity=".85"/>
            <text x="750" y="42" text-anchor="middle" font-size="11" fill="#F0C96B" font-weight="bold" font-family="sans-serif">N</text>
            <text x="750" y="58" text-anchor="middle" font-size="10" fill="#F0C96B" font-family="sans-serif">↑</text>

            {{-- Scale --}}
            <line x1="20" y1="466" x2="70" y2="466" stroke="#1B2B3A" stroke-width="2"/>
            <text x="45" y="478" text-anchor="middle" font-size="7" fill="#555" font-family="sans-serif">100m</text>
        </svg>
    </div>

    {{-- Legend Grid --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:24px;">
        @php
        $zones = [
            ['color'=>'#C0392B','name'=>'Zone A','name_ar'=>'منطقة أ','desc'=>'Thrill Rides','desc_ar'=>'الألعاب المثيرة: قطار، برج سقوط، سيارات'],
            ['color'=>'#2980B9','name'=>'Zone B','name_ar'=>'منطقة ب','desc'=>'Family Zone','desc_ar'=>'منطقة العائلة: فيريس، خيول، قطار صغير'],
            ['color'=>'#16A085','name'=>'Zone C','name_ar'=>'منطقة ج','desc'=>'Water Zone','desc_ar'=>'منطقة المياه: زلاقة، بحرة، نهر كسول'],
            ['color'=>'#C8922A','name'=>'Zone D','name_ar'=>'منطقة د','desc'=>'Sabaean Theatre','desc_ar'=>'مسرح سبأ: 600 مقعد، عروض ثقافية'],
            ['color'=>'#8E44AD','name'=>'Zone E','name_ar'=>'منطقة هـ','desc'=>'Games Arcade','desc_ar'=>'الألعاب الإلكترونية: محطة VR، ألعاب'],
            ['color'=>'#2D6A4F','name'=>'Zone F','name_ar'=>'منطقة و','desc'=>'Food & Retail','desc_ar'=>'الطعام والتسوق: مطاعم، محلات'],
            ['color'=>'#E67E22','name'=>'Zone G','name_ar'=>'منطقة ز','desc'=>'Kids Zone','desc_ar'=>'منطقة الأطفال: ملعب، ألعاب ناعمة'],
        ];
        @endphp
        @foreach($zones as $z)
        <div style="background:#fff;border-radius:10px;padding:10px 12px;border:1px solid var(--border);border-left:4px solid {{ $z['color'] }};display:flex;flex-direction:column;gap:3px;">
            <div style="display:flex;align-items:center;gap:7px;">
                <span style="width:11px;height:11px;border-radius:50%;background:{{ $z['color'] }};flex-shrink:0;display:inline-block;"></span>
                <span style="font-weight:700;color:var(--text-dark);font-size:11px;">{{ app()->getLocale() === 'ar' ? $z['name_ar'] : $z['name'] }}</span>
            </div>
            <div style="font-size:10px;color:var(--gold);font-weight:600;">{{ app()->getLocale() === 'ar' ? $z['name_ar'] . ' — ' . $z['desc_ar'] : $z['name'] . ' — ' . $z['desc'] }}</div>
            <div style="font-size:9px;color:var(--text-muted);">{{ app()->getLocale() === 'ar' ? $z['desc_ar'] : $z['desc'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Park Info --}}
    <div style="background:var(--navy);border-radius:14px;padding:32px;text-align:center;border:1px solid rgba(200,146,42,.3);">
        <h2 style="font-family:'Playfair Display',serif;color:var(--gold-light);margin:0 0 10px;">
            {{ app()->getLocale() === 'ar' ? 'معلومات الزيارة' : 'Visit Information' }}
        </h2>
        <p style="color:rgba(255,255,255,.6);font-size:12px;max-width:500px;margin:0 auto 20px;">
            {{ app()->getLocale() === 'ar' ? 'حديقة جرين سيتي الترفيهية — مأرب، اليمن · مفتوح يومياً من 9 صباحاً' : 'Green City Entertainment Park — Marib, Yemen · Open daily from 9 AM' }}
        </p>
        <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
            @if(auth()->check() && auth()->user()->role === 'visitor')
                <a href="{{ route('visitor.bookings.create') }}" class="btn-pk-primary">
                    🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن' : 'Book Tickets Now' }}
                </a>
            @elseif(!auth()->check())
                <a href="{{ route('register') }}" class="btn-pk-primary">
                    🎫 {{ app()->getLocale() === 'ar' ? 'احجز تذكرتك الآن' : 'Book Tickets Now' }}
                </a>
            @endif
            <a href="{{ route('rides') }}" class="btn-pk-secondary">
                {{ app()->getLocale() === 'ar' ? 'استعرض الألعاب' : 'View All Rides' }}
            </a>
        </div>
    </div>
</div>

@endsection
