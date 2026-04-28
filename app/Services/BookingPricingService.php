<?php

namespace App\Services;

use App\Models\Amenity;
use App\Models\BlockedDate;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class BookingPricingService
{
    public function quote(array $payload): array
    {
        $property = Property::with(['amenities' => function ($query) {
            $query->where('status', true);
        }])->findOrFail($payload['property_id']);

        $checkIn = Carbon::parse($payload['check_in'])->startOfDay();
        $checkOut = Carbon::parse($payload['check_out'])->startOfDay();

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            throw ValidationException::withMessages([
                'check_out' => 'Check-out date must be after the check-in date.',
            ]);
        }

        $guests = max(1, (int) $payload['guests']);
        $nights = $checkIn->diffInDays($checkOut);

        $this->ensurePropertyIsAvailable($property->id, $checkIn, $checkOut);

        $availableAmenities = $property->amenities->isNotEmpty()
            ? $property->amenities->keyBy('id')
            : Amenity::where('status', true)->orderBy('name')->get()->keyBy('id');

        $baseAmount = round(((float) ($property->price ?? 0)) * $nights, 2);
        $selectedAmenities = collect($payload['amenities'] ?? []);
        $amenityLines = [];
        $amenityTotal = 0;

        foreach ($selectedAmenities as $selection) {
            $amenityId = (int) ($selection['id'] ?? 0);
            $amenity = $availableAmenities->get($amenityId);

            if (! $amenity) {
                throw ValidationException::withMessages([
                    'amenities' => 'One or more selected amenities are not available for this property.',
                ]);
            }

            $pricingType = $amenity->pricing_type ?? 'fixed';
            $quantity = $pricingType === 'per_person'
                ? max(1, (int) ($selection['quantity'] ?? 1))
                : null;

            if ($pricingType === 'per_person' && $quantity > $guests) {
                throw ValidationException::withMessages([
                    'amenities' => "The quantity for {$amenity->name} cannot exceed the guest count.",
                ]);
            }

            $unitPrice = round((float) $amenity->price, 2);
            $lineAmount = $pricingType === 'per_person'
                ? round($unitPrice * $quantity, 2)
                : $unitPrice;

            $amenityTotal += $lineAmount;
            $amenityLines[] = [
                'id' => $amenity->id,
                'name' => $amenity->name,
                'pricing_type' => $pricingType,
                'price' => $unitPrice,
                'quantity' => $quantity,
                'amount' => $lineAmount,
            ];
        }

        $totalAmount = round($baseAmount + $amenityTotal, 2);

        return [
            'property' => [
                'id' => $property->id,
                'name' => $property->name,
                'price' => round((float) ($property->price ?? 0), 2),
            ],
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'nights' => $nights,
            'guests' => $guests,
            'base_amount' => $baseAmount,
            'amenity_total' => round($amenityTotal, 2),
            'amount' => $totalAmount,
            'amenities' => $amenityLines,
        ];
    }

    protected function ensurePropertyIsAvailable(int $propertyId, Carbon $checkIn, Carbon $checkOut): void
    {
        $hasBlockedDates = BlockedDate::where('property_id', $propertyId)
            ->whereDate('start_date', '<', $checkOut->toDateString())
            ->whereDate('end_date', '>=', $checkIn->toDateString())
            ->exists();

        if ($hasBlockedDates) {
            throw ValidationException::withMessages([
                'check_in' => 'These dates are not available for the selected property.',
            ]);
        }

        $hasBookings = Booking::where('property_id', $propertyId)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) {
                $query->whereNull('payment_status')
                    ->orWhereIn('payment_status', ['Pending', 'Paid']);
            })
            ->whereDate('check_in', '<', $checkOut->toDateString())
            ->whereDate('check_out', '>', $checkIn->toDateString())
            ->exists();

        if ($hasBookings) {
            throw ValidationException::withMessages([
                'check_in' => 'This property is already booked for the selected dates.',
            ]);
        }
    }
}
