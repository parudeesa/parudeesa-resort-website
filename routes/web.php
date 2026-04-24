<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// CHANGED: This now uses the Controller to load property data into your design
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/design', function () {
    return view('design');
})->name('design');

Route::get('/chatbot', function () {
    return view('chatbot');
});

Route::get('/booking', function () {
    return view('booking');
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
    Route::post('/property/add', [PropertyController::class, 'store'])->name('property.store');
    Route::delete('/property/delete/{id}', [PropertyController::class, 'destroy'])->name('property.delete');
});

require __DIR__.'/auth.php';