@extends('layouts.app')
@section('title', __('messages.about'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <div style="font-size: 4rem;">🎡</div>
                <h1 class="fw-black" style="color:#1a7a4a;">{{ __('messages.park_name') }}</h1>
                <p class="fs-5 text-muted">{{ __('messages.park_tagline') }}</p>
            </div>
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold" style="color:#1a7a4a;">{{ app()->getLocale() === 'ar' ? 'عن المدينة' : 'About the Park' }}</h4>
                    <p>{{ app()->getLocale() === 'ar' ? 'مدينة غرين سيتي للترفيه هي وجهة ترفيهية متكاملة تقع في قلب صنعاء، اليمن. تضم المدينة مجموعة متنوعة من الألعاب الترفيهية والفعاليات والأنشطة التي تناسب جميع أفراد العائلة.' : 'Green City Entertainment Park is a comprehensive entertainment destination located in the heart of Sana\'a, Yemen. The park features a diverse range of rides, events and activities suitable for all family members.' }}</p>
                    <p>{{ app()->getLocale() === 'ar' ? 'نسعى دائماً لتوفير تجربة ترفيهية آمنة وممتعة لجميع زوارنا، مع الحفاظ على أعلى معايير الجودة والسلامة.' : 'We always strive to provide a safe and enjoyable entertainment experience for all our visitors, while maintaining the highest standards of quality and safety.' }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="fw-bold" style="color:#1a7a4a;">{{ __('messages.contact') }}</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p><i class="fas fa-phone fa-fw me-2 text-success"></i>{{ __('messages.contact_phone') }}</p>
                            <p><i class="fas fa-envelope fa-fw me-2 text-success"></i>{{ __('messages.contact_email') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-map-marker-alt fa-fw me-2 text-success"></i>{{ __('messages.park_location') }}</p>
                            <p><i class="fas fa-clock fa-fw me-2 text-success"></i>{{ __('messages.park_hours') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
