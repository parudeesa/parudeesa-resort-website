<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingPricingService;
use App\Services\GoogleCalendarService;
use App\Services\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChatbotBookingController extends Controller
{
    public function __construct(
        protected BookingPricingService $pricingService,
        protected RazorpayService $razorpayService,
        protected GoogleCalendarService $calendarService,
    ) {
    }

    public function quote(Request $request): JsonResponse
    {
        try {
            $data = $this->validatePayload($request, false);
            $quote = $this->pricingService->quote($data);

            return response()->json([
                'success' => true,
                'quote' => $quote,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to generate quote. Please check your booking details and try again.',
            ], 500);
        }
    }

    public function checkout(Request $request): JsonResponse
    {
        try {
            $data = $this->validatePayload($request, true);
            $quote = $this->pricingService->quote($data);

            \Log::info('Checkout initiated', [
                'quote' => $quote,
                'data' => $data,
            ]);

            $booking = null;
            $payment = null;

            DB::transaction(function () use ($data, $quote, &$booking, &$payment) {
                $booking = Booking::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'check_in' => $quote['check_in'],
                    'check_out' => $quote['check_out'],
                    'guests' => $quote['guests'],
                    'property_id' => $quote['property']['id'],
                    'event_type' => $data['event_type'] ?? null,
                    'package_name' => $data['package_name'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'amenities' => $quote['amenities'],
                    'amenity_total' => $quote['amenity_total'],
                    'base_amount' => $quote['base_amount'],
                    'amount' => $quote['amount'],
                    'status' => 'pending',
                    'payment_status' => 'Pending',
                ]);

                foreach ($quote['amenities'] as $amenity) {
                    $booking->bookingAmenities()->create([
                        'amenity_id' => $amenity['id'],
                        'quantity' => $amenity['quantity'] ?? 1,
                        'unit_price' => $amenity['price'],
                        'amount' => $amenity['amount'],
                    ]);
                }

                $order = $this->razorpayService->createOrder(
                    (int) round($quote['amount'] * 100),
                    'booking_'.$booking->id,
                    [
                        'booking_id' => (string) $booking->id,
                        'property' => $quote['property']['name'],
                    ]
                );

                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'order_id' => $order['id'] ?? null,
                    'status' => $order['status'] ?? 'created',
                    'amount' => $quote['amount'],
                ]);
            });

            \Log::info('Checkout completed successfully', [
                'booking_id' => $booking->id,
                'order_id' => $payment->order_id,
            ]);

            return response()->json([
                'success' => true,
                'booking_id' => $booking->id,
                'order' => [
                    'id' => $payment->order_id,
                    'amount' => (int) round($payment->amount * 100),
                    'currency' => 'INR',
                ],
                'booking' => [
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'property_name' => $quote['property']['name'],
                    'amount' => $quote['amount'],
                ],
                'quote' => $quote,
                'razorpay_key' => config('services.razorpay.key'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to process booking. Please try again later.',
            ], 500);
        }
    }

    public function verifyPayment(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'booking_id' => ['required', 'integer', 'exists:bookings,id'],
                'razorpay_order_id' => ['required', 'string'],
                'razorpay_payment_id' => ['required', 'string'],
                'razorpay_signature' => ['required', 'string'],
            ]);

            \Log::info('Payment verification initiated', [
                'booking_id' => $validated['booking_id'],
                'order_id' => $validated['razorpay_order_id'],
                'payment_id' => $validated['razorpay_payment_id'],
            ]);

            $booking = Booking::with(['payment', 'property'])->findOrFail($validated['booking_id']);
            $payment = $booking->payment;

            if (! $payment || $payment->order_id !== $validated['razorpay_order_id']) {
                throw ValidationException::withMessages([
                    'razorpay_order_id' => 'Payment order does not match this booking.',
                ]);
            }

            if (! $this->razorpayService->verifySignature(
                $validated['razorpay_order_id'],
                $validated['razorpay_payment_id'],
                $validated['razorpay_signature']
            )) {
                \Log::error('Payment signature verification failed', [
                    'booking_id' => $validated['booking_id'],
                    'order_id' => $validated['razorpay_order_id'],
                ]);
                throw ValidationException::withMessages([
                    'razorpay_signature' => 'Payment verification failed.',
                ]);
            }

            DB::transaction(function () use ($booking, $payment, $validated) {
                $payment->update([
                    'payment_id' => $validated['razorpay_payment_id'],
                    'signature' => $validated['razorpay_signature'],
                    'status' => 'paid',
                ]);

                $booking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'Paid',
                ]);

                $googleEvent = $this->calendarService->createEvent($booking->fresh(['property']));
                if ($googleEvent) {
                    $booking->update(['google_event_id' => $googleEvent->id]);
                }
            });

            \Log::info('Payment verification completed successfully', [
                'booking_id' => $validated['booking_id'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified and booking confirmed.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment verification failed', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.',
            ], 500);
        }
    }

    public function markFailure(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'booking_id' => ['required', 'integer', 'exists:bookings,id'],
                'reason' => ['nullable', 'string'],
            ]);

            $booking = Booking::with('payment')->findOrFail($validated['booking_id']);

            DB::transaction(function () use ($booking, $validated) {
                $booking->update([
                    'status' => 'pending',
                    'payment_status' => 'Failed',
                ]);

                if ($booking->payment) {
                    $booking->payment->update([
                        'status' => 'failed',
                        'failure_reason' => $validated['reason'] ?? 'Payment was not completed.',
                    ]);
                }
            });

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update payment status. Please contact support.',
            ], 500);
        }
    }

    protected function validatePayload(Request $request, bool $requireContactDetails): array
    {
        $rules = [
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'event_type' => ['nullable', 'string', 'max:255'],
            'package_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'amenities' => ['nullable', 'array'],
            'amenities.*.id' => ['required', 'integer', 'exists:amenities,id'],
            'amenities.*.quantity' => ['nullable', 'integer', 'min:1'],
        ];

        if ($requireContactDetails) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'email', 'max:255'];
            $rules['phone'] = ['required', 'string', 'max:20'];
        }

        return $request->validate($rules);
    }
}
