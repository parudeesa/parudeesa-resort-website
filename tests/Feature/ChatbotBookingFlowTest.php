<?php

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Property;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('services.razorpay.key', 'rzp_test_key');
    config()->set('services.razorpay.secret', 'rzp_test_secret');

    $calendarService = \Mockery::mock(GoogleCalendarService::class);
    $calendarService->shouldReceive('createEvent')->andReturn((object) ['id' => 'google_evt_123']);
    $this->app->instance(GoogleCalendarService::class, $calendarService);
});

it('returns a chatbot quote with dynamic amenity pricing', function () {
    $property = Property::create([
        'name' => 'Parudeesa The Paradise',
        'price' => 2000,
    ]);

    $breakfast = Amenity::create([
        'name' => 'Breakfast',
        'price' => 100,
        'pricing_type' => 'per_person',
        'status' => true,
    ]);

    $pickup = Amenity::create([
        'name' => 'Airport Pickup',
        'price' => 500,
        'pricing_type' => 'fixed',
        'status' => true,
    ]);

    $property->amenities()->attach([$breakfast->id, $pickup->id]);

    $response = $this->postJson('/chatbot/quote', [
        'property_id' => $property->id,
        'check_in' => '2026-05-01',
        'check_out' => '2026-05-03',
        'guests' => 3,
        'amenities' => [
            ['id' => $breakfast->id, 'quantity' => 3],
            ['id' => $pickup->id],
        ],
    ]);

    $response->assertOk()
        ->assertJsonPath('quote.base_amount', 4000)
        ->assertJsonPath('quote.amenity_total', 800)
        ->assertJsonPath('quote.amount', 4800)
        ->assertJsonCount(2, 'quote.amenities');
});

it('creates a pending chatbot booking, booking amenities, and a razorpay order', function () {
    Http::fake([
        'https://api.razorpay.com/v1/orders' => Http::response([
            'id' => 'order_test_123',
            'status' => 'created',
        ], 200),
    ]);

    $property = Property::create([
        'name' => 'Parudeesa Utopiya',
        'price' => 3000,
    ]);

    $campfire = Amenity::create([
        'name' => 'Campfire',
        'price' => 250,
        'pricing_type' => 'per_person',
        'status' => true,
    ]);

    $bed = Amenity::create([
        'name' => 'Extra Bed',
        'price' => 700,
        'pricing_type' => 'fixed',
        'status' => true,
    ]);

    $property->amenities()->attach([$campfire->id, $bed->id]);

    $response = $this->postJson('/chatbot/checkout', [
        'property_id' => $property->id,
        'check_in' => '2026-06-10',
        'check_out' => '2026-06-12',
        'guests' => 2,
        'name' => 'Amina',
        'email' => 'amina@example.com',
        'phone' => '9999999999',
        'event_type' => 'Stay',
        'amenities' => [
            ['id' => $campfire->id, 'quantity' => 2],
            ['id' => $bed->id],
        ],
    ]);

    $response->assertOk()
        ->assertJsonPath('order.id', 'order_test_123')
        ->assertJsonPath('booking.amount', 7200);

    $booking = Booking::first();
    expect($booking)->not->toBeNull();
    expect($booking->payment_status)->toBe('Pending');
    expect($booking->status)->toBe('pending');
    expect($booking->bookingAmenities()->count())->toBe(2);

    $payment = Payment::first();
    expect($payment->order_id)->toBe('order_test_123');
    expect((float) $payment->amount)->toBe(7200.0);
});

it('verifies chatbot payment and confirms the booking', function () {
    $property = Property::create([
        'name' => 'Parudeesa The Paradise',
        'price' => 2500,
    ]);

    $booking = Booking::create([
        'name' => 'Guest',
        'email' => 'guest@example.com',
        'phone' => '9999999999',
        'check_in' => '2026-07-01',
        'check_out' => '2026-07-03',
        'guests' => 2,
        'property_id' => $property->id,
        'amount' => 5000,
        'base_amount' => 5000,
        'amenity_total' => 0,
        'status' => 'pending',
        'payment_status' => 'Pending',
    ]);

    Payment::create([
        'booking_id' => $booking->id,
        'order_id' => 'order_test_456',
        'status' => 'created',
        'amount' => 5000,
    ]);

    $signature = hash_hmac('sha256', 'order_test_456|pay_test_456', config('services.razorpay.secret'));

    $response = $this->postJson('/chatbot/payment/verify', [
        'booking_id' => $booking->id,
        'razorpay_order_id' => 'order_test_456',
        'razorpay_payment_id' => 'pay_test_456',
        'razorpay_signature' => $signature,
    ]);

    $response->assertOk()->assertJsonPath('success', true);

    $booking->refresh();
    $booking->payment->refresh();

    expect($booking->status)->toBe('confirmed');
    expect($booking->payment_status)->toBe('Paid');
    expect($booking->google_event_id)->toBe('google_evt_123');
    expect($booking->payment->status)->toBe('paid');
    expect($booking->payment->payment_id)->toBe('pay_test_456');
});
