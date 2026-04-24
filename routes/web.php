<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AmenityController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// CHANGED: This now uses the Controller to load property data into your design
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/property/{id}', [HomeController::class, 'show'])->name('property.show');

Route::get('/design', function () {
    return view('design');
})->name('design');

Route::get('/chatbot', function () {
    return view('chatbot');
});

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

    // Amenities management
    Route::get('/amenities', [AmenityController::class, 'index'])->name('amenities.index');
    Route::post('/amenities', [AmenityController::class, 'store'])->name('amenities.store');
    Route::patch('/amenities/{amenity}', [AmenityController::class, 'update'])->name('amenities.update');
    Route::delete('/amenities/{amenity}', [AmenityController::class, 'destroy'])->name('amenities.destroy');
});

require __DIR__.'/auth.php';