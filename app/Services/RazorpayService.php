<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RazorpayService
{
    public function createOrder(int $amountInPaise, string $receipt, array $notes = []): array
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (! $key || ! $secret) {
            throw new RuntimeException('Razorpay credentials are not configured.');
        }

        $response = Http::withBasicAuth($key, $secret)
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'receipt' => $receipt,
                'payment_capture' => 1,
                'notes' => $notes,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Unable to create the Razorpay order.');
        }

        return $response->json();
    }

    public function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        $secret = config('services.razorpay.secret');

        if (! $secret) {
            throw new RuntimeException('Razorpay secret is not configured.');
        }

        $expectedSignature = hash_hmac('sha256', $orderId.'|'.$paymentId, $secret);

        return hash_equals($expectedSignature, $signature);
    }
}
