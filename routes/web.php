<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Staff;
use App\Http\Controllers\Visitor;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/rides', [PublicController::class, 'rides'])->name('rides');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/map', [PublicController::class, 'map'])->name('map');

// Language switcher
Route::get('/lang/{lang}', [AuthController::class, 'setLanguage'])->name('lang.switch');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Visitor routes
Route::middleware(['auth', 'role:visitor'])->prefix('visitor')->name('visitor.')->group(function () {
    Route::get('/dashboard', [Visitor\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings', [Visitor\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [Visitor\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [Visitor\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [Visitor\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/payment', [Visitor\BookingController::class, 'paymentForm'])->name('bookings.payment');
    Route::post('/bookings/{booking}/payment', [Visitor\BookingController::class, 'submitPayment'])->name('bookings.payment.submit');
    Route::post('/bookings/{booking}/cancel', [Visitor\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/resubmit', [Visitor\BookingController::class, 'resubmitPayment'])->name('bookings.resubmit');

    Route::get('/tickets', [Visitor\TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [Visitor\TicketController::class, 'show'])->name('tickets.show');

    Route::get('/notifications', [Visitor\NotificationController::class, 'index'])->name('notifications.index');
});

// Staff routes
Route::middleware(['auth', 'role:staff,admin'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [Staff\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/payments', [Staff\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [Staff\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/verify', [Staff\PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [Staff\PaymentController::class, 'reject'])->name('payments.reject');

    Route::get('/rides', [Staff\RideController::class, 'index'])->name('rides.index');
    Route::post('/rides/{ride}/status', [Staff\RideController::class, 'updateStatus'])->name('rides.status');

    Route::get('/tickets/scan', [Staff\TicketController::class, 'scanForm'])->name('tickets.scan');
    Route::post('/tickets/scan', [Staff\TicketController::class, 'scan'])->name('tickets.scan.submit');
});

// Promo code check (used by booking form JS)
Route::get('/api/promo-check', function (\Illuminate\Http\Request $request) {
    $promo = \App\Models\Promotion::where('code', strtoupper($request->code ?? ''))->first();
    if (!$promo || !$promo->isValid()) {
        return response()->json(['valid' => false, 'message' => app()->getLocale() === 'ar' ? 'كود غير صالح' : 'Invalid code']);
    }
    $amount  = (float) ($request->amount ?? 0);
    $discount = $promo->calculateDiscount($amount);
    return response()->json([
        'valid'    => true,
        'discount' => $discount,
        'total'    => max(0, $amount - $discount),
        'message'  => app()->getLocale() === 'ar' ? 'تم تطبيق الخصم' : 'Discount applied',
        'type'     => $promo->discount_type,
        'value'    => $promo->discount_value,
        'name'     => $promo->name,
    ]);
})->name('api.promo.check');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users', Admin\UserController::class);
    Route::resource('/rides', Admin\RideController::class);
    Route::resource('/events', Admin\EventController::class);
    Route::resource('/promotions', Admin\PromotionController::class);

    Route::get('/bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/reject', [Admin\BookingController::class, 'reject'])->name('bookings.reject');

    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');

    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [Admin\NotificationController::class, 'store'])->name('notifications.store');
    Route::delete('/notifications/{notification}', [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
});
