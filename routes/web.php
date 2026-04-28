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

Route::get('/chatbot', [ChatbotController::class, 'show'])->name('chatbot.show');
Route::post('/chatbot/quote', [ChatbotBookingController::class, 'quote'])->name('chatbot.quote');
Route::post('/chatbot/checkout', [ChatbotBookingController::class, 'checkout'])->name('chatbot.checkout');
Route::post('/chatbot/payment/verify', [ChatbotBookingController::class, 'verifyPayment'])->name('chatbot.payment.verify');
Route::post('/chatbot/payment/failure', [ChatbotBookingController::class, 'markFailure'])->name('chatbot.payment.failure');

Route::get('/booking', function () {
    $properties = \App\Models\Property::all();
    return view('booking', compact('properties'));
});

Route::post('/bookings', [HomeController::class, 'storeBooking'])->name('bookings.store');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'superadmin'])->name('dashboard');

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/bookings', [HomeController::class, 'bookingsIndex'])->name('bookings.index');
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/bookings', [HomeController::class, 'bookingsIndex'])->name('bookings.index');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::post('/property/add', [PropertyController::class, 'store'])->name('property.store');
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

require __DIR__.'/auth.php';
