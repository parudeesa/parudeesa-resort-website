<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotBookingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\GalleryController;

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
Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events');
Route::post('/events/inquiry', [App\Http\Controllers\EventController::class, 'store'])->name('events.inquiry');

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
    $amenities = \App\Models\Amenity::all();
    return view('booking', compact('properties', 'activeCoupons', 'amenities'));
});

Route::post('/bookings', [HomeController::class, 'storeBooking'])->name('bookings.store');
Route::post('/book-yacht', [\App\Http\Controllers\YachtController::class, 'store'])->name('yacht.store');
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

    // Gallery management
    Route::get('/admin/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
    Route::post('/admin/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::patch('/admin/gallery/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/admin/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
    Route::post('/admin/gallery/reorder', [GalleryController::class, 'reorder'])->name('admin.gallery.reorder');

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

    // Yacht Management
    Route::get('/admin/yachts', [\App\Http\Controllers\YachtController::class, 'index'])->name('admin.yachts.index');
    Route::post('/admin/yachts', [\App\Http\Controllers\YachtController::class, 'storeAdmin'])->name('admin.yachts.store');
    Route::patch('/admin/yachts/{id}', [\App\Http\Controllers\YachtController::class, 'updateAdmin'])->name('admin.yachts.update');
    Route::delete('/admin/yachts/{id}', [\App\Http\Controllers\YachtController::class, 'destroyAdmin'])->name('admin.yachts.delete');

    // Home Page Settings
    Route::get('/admin/settings/home', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.home');
    Route::post('/admin/settings/home', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    // Pricing & Services Management
    Route::get('/admin/pricing', [\App\Http\Controllers\Admin\ServicePricingController::class, 'index'])->name('admin.pricing.index');
    Route::post('/admin/pricing/food', [\App\Http\Controllers\Admin\ServicePricingController::class, 'storeFood'])->name('admin.pricing.food.store');
    Route::patch('/admin/pricing/food/{id}', [\App\Http\Controllers\Admin\ServicePricingController::class, 'updateFood'])->name('admin.pricing.food.update');
    Route::delete('/admin/pricing/food/{id}', [\App\Http\Controllers\Admin\ServicePricingController::class, 'destroyFood'])->name('admin.pricing.food.delete');
    
    Route::post('/admin/pricing/service', [\App\Http\Controllers\Admin\ServicePricingController::class, 'storeService'])->name('admin.pricing.service.store');
    Route::patch('/admin/pricing/service/{id}', [\App\Http\Controllers\Admin\ServicePricingController::class, 'updateService'])->name('admin.pricing.service.update');
    Route::delete('/admin/pricing/service/{id}', [\App\Http\Controllers\Admin\ServicePricingController::class, 'destroyService'])->name('admin.pricing.service.delete');

    Route::get('/admin/pricing/amenities', [\App\Http\Controllers\Admin\ServicePricingController::class, 'amenitiesIndex'])->name('admin.pricing.amenities');
    Route::post('/admin/pricing/amenities', [\App\Http\Controllers\Admin\ServicePricingController::class, 'updateAmenitiesPricing'])->name('admin.pricing.amenities.update');

    // Event Inquiries Management
    Route::get('/admin/events', [\App\Http\Controllers\Admin\EventInquiryController::class, 'index'])->name('admin.events.index');
    Route::get('/admin/events/{id}', [\App\Http\Controllers\Admin\EventInquiryController::class, 'show'])->name('admin.events.show');
    Route::patch('/admin/events/{id}/status', [\App\Http\Controllers\Admin\EventInquiryController::class, 'updateStatus'])->name('admin.events.update_status');
    Route::delete('/admin/events/{id}', [\App\Http\Controllers\Admin\EventInquiryController::class, 'destroy'])->name('admin.events.destroy');

    // Reels Management
    Route::get('/admin/reels', [\App\Http\Controllers\Admin\ReelController::class, 'index'])->name('admin.reels.index');
    Route::post('/admin/reels', [\App\Http\Controllers\Admin\ReelController::class, 'store'])->name('admin.reels.store');
    Route::patch('/admin/reels/{reel}', [\App\Http\Controllers\Admin\ReelController::class, 'update'])->name('admin.reels.update');
    Route::delete('/admin/reels/{reel}', [\App\Http\Controllers\Admin\ReelController::class, 'destroy'])->name('admin.reels.destroy');
    Route::post('/admin/reels/update-order', [\App\Http\Controllers\Admin\ReelController::class, 'updateOrder'])->name('admin.reels.update_order');

    // Events Page Manager
    Route::prefix('admin/events-manager')->name('admin.events-manager.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\EventPageController::class, 'index'])->name('index');
        Route::post('/hero', [\App\Http\Controllers\Admin\EventPageController::class, 'updateHero'])->name('hero.update');
        Route::post('/pricing-settings', [\App\Http\Controllers\Admin\EventPageController::class, 'updatePricingSettings'])->name('pricing.update');
        Route::post('/seo', [\App\Http\Controllers\Admin\EventPageController::class, 'updateSEO'])->name('seo.update');
        
        Route::post('/cards', [\App\Http\Controllers\Admin\EventPageController::class, 'storeCard'])->name('cards.store');
        Route::patch('/cards/{card}', [\App\Http\Controllers\Admin\EventPageController::class, 'updateCard'])->name('cards.update');
        Route::delete('/cards/{card}', [\App\Http\Controllers\Admin\EventPageController::class, 'deleteCard'])->name('cards.delete');

        Route::post('/amenities', [\App\Http\Controllers\Admin\EventPageController::class, 'storeAmenity'])->name('amenities.store');
        Route::patch('/amenities/{amenity}', [\App\Http\Controllers\Admin\EventPageController::class, 'updateAmenity'])->name('amenities.update');
        Route::delete('/amenities/{amenity}', [\App\Http\Controllers\Admin\EventPageController::class, 'deleteAmenity'])->name('amenities.delete');

        Route::post('/gallery', [\App\Http\Controllers\Admin\EventPageController::class, 'storeGallery'])->name('gallery.store');
        Route::delete('/gallery/{gallery}', [\App\Http\Controllers\Admin\EventPageController::class, 'deleteGallery'])->name('gallery.delete');

        Route::post('/steps', [\App\Http\Controllers\Admin\EventPageController::class, 'storeStep'])->name('steps.store');
        Route::patch('/steps/{step}', [\App\Http\Controllers\Admin\EventPageController::class, 'updateStep'])->name('steps.update');
        Route::delete('/steps/{step}', [\App\Http\Controllers\Admin\EventPageController::class, 'deleteStep'])->name('steps.delete');

        Route::post('/features', [\App\Http\Controllers\Admin\EventPageController::class, 'storeFeature'])->name('features.store');
        Route::delete('/features/{feature}', [\App\Http\Controllers\Admin\EventPageController::class, 'deleteFeature'])->name('features.delete');
        
        Route::post('/order', [\App\Http\Controllers\Admin\EventPageController::class, 'updateOrder'])->name('update_order');
    });

    // Homepage Management
    Route::prefix('admin/homepage-manager')->name('admin.homepage-manager.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\HomepageController::class, 'index'])->name('index');
        Route::post('/update-settings', [\App\Http\Controllers\Admin\HomepageController::class, 'updateSettings'])->name('settings.update');
        
        // Home Amenities
        Route::post('/amenities', [\App\Http\Controllers\Admin\HomepageController::class, 'storeAmenity'])->name('amenities.store');
        Route::patch('/amenities/{amenity}', [\App\Http\Controllers\Admin\HomepageController::class, 'updateAmenity'])->name('amenities.update');
        Route::delete('/amenities/{amenity}', [\App\Http\Controllers\Admin\HomepageController::class, 'deleteAmenity'])->name('amenities.delete');
        
        // Home Reviews
        Route::post('/reviews', [\App\Http\Controllers\Admin\HomepageController::class, 'storeReview'])->name('reviews.store');
        Route::patch('/reviews/{review}', [\App\Http\Controllers\Admin\HomepageController::class, 'updateReview'])->name('reviews.update');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\HomepageController::class, 'deleteReview'])->name('reviews.delete');

        Route::post('/update-order', [\App\Http\Controllers\Admin\HomepageController::class, 'updateOrder'])->name('update_order');
    });

    // Standalone About Us Management
    Route::prefix('admin/about-us')->name('admin.about-us.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AboutUsController::class, 'index'])->name('index');
        Route::post('/settings', [\App\Http\Controllers\Admin\AboutUsController::class, 'updateSettings'])->name('settings.update');
        
        Route::post('/values', [\App\Http\Controllers\Admin\AboutUsController::class, 'storeAboutValue'])->name('values.store');
        Route::patch('/values/{value}', [\App\Http\Controllers\Admin\AboutUsController::class, 'updateAboutValue'])->name('values.update');
        Route::delete('/values/{value}', [\App\Http\Controllers\Admin\AboutUsController::class, 'deleteAboutValue'])->name('values.delete');

        Route::post('/team', [\App\Http\Controllers\Admin\AboutUsController::class, 'storeTeamMember'])->name('team.store');
        Route::patch('/team/{member}', [\App\Http\Controllers\Admin\AboutUsController::class, 'updateTeamMember'])->name('team.update');
        Route::delete('/team/{member}', [\App\Http\Controllers\Admin\AboutUsController::class, 'deleteTeamMember'])->name('team.delete');

        Route::post('/update-order', [\App\Http\Controllers\Admin\AboutUsController::class, 'updateOrder'])->name('update_order');
    });
});

require __DIR__.'/auth.php';
