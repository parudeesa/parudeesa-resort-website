<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotBookingController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// CHANGED: This now uses the Controller to load property data into your design
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/property/{id}', [HomeController::class, 'show'])->name('property.show');
Route::get('/property/{id}/unavailable-dates', [HomeController::class, 'unavailableDates']);

Route::get('/design', [HomeController::class, 'design'])->name('design');

// Policy Pages
Route::get('/terms-and-conditions', function () {
    return view('policies.terms-and-conditions');
});

Route::get('/privacy-policy', function () {
    return view('policies.privacy-policy');
});

Route::get('/cancellation-policy', function () {
    return view('policies.cancellation-policy');
});

Route::get('/chatbot', [ChatbotController::class, 'show'])->name('chatbot.show');
Route::post('/chatbot/quote', [ChatbotBookingController::class, 'quote'])->name('chatbot.quote');
Route::post('/chatbot/checkout', [ChatbotBookingController::class, 'checkout'])->name('chatbot.checkout');
Route::post('/chatbot/payment/verify', [ChatbotBookingController::class, 'verifyPayment'])->name('chatbot.payment.verify');
Route::post('/chatbot/payment/failure', [ChatbotBookingController::class, 'markFailure'])->name('chatbot.payment.failure');

Route::get('/booking', function () {
    $properties = \App\Models\Property::all();
    $activeCoupons = \App\Models\Coupon::where('is_active', true)->get();
    return view('booking', compact('properties', 'activeCoupons'));
});

Route::post('/bookings', [HomeController::class, 'storeBooking'])->name('bookings.store');
Route::get('/api/check-phone-bookings/{phone}', [HomeController::class, 'checkPhoneBookings']);
Route::post('/coupons/validate', [\App\Http\Controllers\CouponController::class, 'validateCoupon'])->name('coupons.validate');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:superadmin'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [HomeController::class, 'bookingsIndex'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [HomeController::class, 'updateBookingStatus'])->name('bookings.update_status');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin & Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::post('/property/add', [PropertyController::class, 'store'])->name('property.store');
    Route::patch('/property/{property}', [PropertyController::class, 'update'])->name('property.update');
    Route::delete('/property/delete/{id}', [PropertyController::class, 'destroy'])->name('property.delete');

    // Amenities management
    Route::get('/amenities', [AmenityController::class, 'index'])->name('amenities.index');
    Route::post('/amenities', [AmenityController::class, 'store'])->name('amenities.store');
    Route::patch('/amenities/{amenity}', [AmenityController::class, 'update'])->name('amenities.update');
    Route::delete('/amenities/{amenity}', [AmenityController::class, 'destroy'])->name('amenities.destroy');

    // Calendar & Settings
    Route::get('/calendar', [AdminController::class, 'calendar'])->name('admin.calendar');
    
    Route::post('/calendar/blocks', [AdminController::class, 'storeBlock'])->name('admin.calendar.store_block');
    Route::patch('/calendar/blocks/{id}', [AdminController::class, 'updateBlock'])->name('admin.calendar.update_block');
    Route::delete('/calendar/blocks/{id}', [AdminController::class, 'destroyBlock'])->name('admin.calendar.destroy_block');

    Route::post('/calendar/reservations', [AdminController::class, 'storeReservation'])->name('admin.calendar.store_reservation');
    Route::patch('/calendar/reservations/{id}', [AdminController::class, 'updateReservation'])->name('admin.calendar.update_reservation');
    Route::delete('/calendar/reservations/{id}', [AdminController::class, 'destroyReservation'])->name('admin.calendar.destroy_reservation');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
});

/*
|--------------------------------------------------------------------------
| Super Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/admin/admins', [AdminController::class, 'adminsIndex'])->name('admin.admins.index');
    Route::post('/admin/admins', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
    Route::patch('/admin/admins/{id}', [AdminController::class, 'updateAdmin'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.admins.delete');
    Route::post('/admin/admins/{id}/toggle-status', [AdminController::class, 'toggleAdminStatus'])->name('admin.admins.toggle_status');

    // Coupons Management
    Route::get('/admin/coupons', [\App\Http\Controllers\CouponController::class, 'index'])->name('admin.coupons.index');
    Route::post('/admin/coupons', [\App\Http\Controllers\CouponController::class, 'store'])->name('admin.coupons.store');
    Route::post('/admin/coupons/{id}/toggle', [\App\Http\Controllers\CouponController::class, 'toggleStatus'])->name('admin.coupons.toggle_status');
    Route::delete('/admin/coupons/{id}', [\App\Http\Controllers\CouponController::class, 'destroy'])->name('admin.coupons.destroy');
});

require __DIR__.'/auth.php';
