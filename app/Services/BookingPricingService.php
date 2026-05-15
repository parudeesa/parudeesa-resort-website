<?php

namespace App\Services;

use App\Models\Amenity;
use App\Models\BlockedDate;
use App\Models\Booking;
use App\Models\Property;
use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class BookingPricingService
{
    public function quote(array $payload): array
    {
        $property = Property::with(['amenities' => function ($query) {
            $query->where('status', true);
        }])->findOrFail($payload['property_id']);

        $coupon = null;
        if (!empty($payload['coupon_code'])) {
            $coupon = Coupon::where('code', $payload['coupon_code'])->where('is_active', true)->first();
        } elseif (!empty($payload['coupon_id'])) {
            $coupon = Coupon::where('id', $payload['coupon_id'])->where('is_active', true)->first();
        }

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

        $nameLower = strtolower($property->name);
        $propertyTag = str_contains($nameLower, 'paradise') ? 'paradise' : (str_contains($nameLower, 'utopi') ? 'utopia' : 'both');

        $availableAmenities = Amenity::where('status', true)
            ->where(function($q) use ($propertyTag) {
                $q->where('property_assignment', $propertyTag)
                  ->orWhere('property_assignment', 'both');
            })
            ->get()
            ->keyBy('id');

        $totalBaseStayAmount = 0;
        $currentDate = $checkIn->copy();

        while ($currentDate->lessThan($checkOut)) {
            $dayOfWeek = $currentDate->dayOfWeek;
            $isNightWeekend = in_array($dayOfWeek, [\Illuminate\Support\Carbon::FRIDAY, \Illuminate\Support\Carbon::SATURDAY, \Illuminate\Support\Carbon::SUNDAY]);
            
            $stayThreshold = (int) \App\Models\Setting::get('property_stay_threshold', 5);
            $nightPrice = 0;
            if ($isNightWeekend) {
                // Rule 3: Weekend (Up to 10 Guests)
                $nightPrice = (float) ($property->weekend_price ?: 12000);
            } else {
                if ($guests <= $stayThreshold) {
                    // Rule 1: Weekday (Up to threshold Guests)
                    $nightPrice = (float) ($property->weekday_price ?: 8000);
                } else {
                    // Rule 2: Weekday (Up to 10 Guests)
                    $nightPrice = (float) ($property->weekday_tier2_price ?: 11000);
                }
            }

            $totalBaseStayAmount += $nightPrice;
            $currentDate->addDay();
        }

        $baseAmount = round($totalBaseStayAmount, 2);
        $selectedAmenities = collect($payload['amenities'] ?? []);
        $amenityLines = [];
        $amenityTotal = 0;

        // Fetch settings for tiered pricing (Unified Water Activity)
        $waThreshold = (int) \App\Models\Setting::get('water_activity_threshold', 5);
        $waLowPrice = (float) \App\Models\Setting::get('water_activity_low_price', 1000);
        $waHighPrice = (float) \App\Models\Setting::get('water_activity_high_price', 700);

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

            // Dynamic tiered pricing for Kayaking & Boating based on settings
            $aName = strtolower($amenity->name);
            if (str_contains($aName, 'kayaking') || str_contains($aName, 'boating')) {
                $unitPrice = ($quantity < $waThreshold) ? $waLowPrice : $waHighPrice;
            }

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

        // Add Food Package from database
        $packageName = $payload['package_name'] ?? 'Stay Only';
        $foodPackage = \App\Models\FoodPackage::where('name', $packageName)->where('status', true)->first();
        
        if ($foodPackage && $foodPackage->price > 0) {
            $rate = (float) $foodPackage->price;
            $packageAmount = round($rate * $guests * $nights, 2);
            $amenityTotal += $packageAmount;
            $amenityLines[] = [
                'id' => $foodPackage->id,
                'name' => "Package: " . $foodPackage->name,
                'pricing_type' => 'package',
                'price' => $rate,
                'quantity' => $guests * $nights,
                'amount' => $packageAmount,
            ];
        }

        $totalAmount = round($baseAmount + $amenityTotal, 2);
        
        $discountAmount = 0;
        if ($coupon) {
            $discountAmount = $coupon->calculateDiscount($totalAmount);
            $totalAmount = max(0, $totalAmount - $discountAmount);
        }

        return [
            'property' => [
                'id' => $property->id,
                'name' => $property->name,
                'price' => round((float) ($property->weekday_price ?? 0), 2),
            ],
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'nights' => $nights,
            'guests' => $guests,
            'base_amount' => $baseAmount,
            'amenity_total' => round($amenityTotal, 2),
            'discount_amount' => round($discountAmount, 2),
            'coupon_id' => $coupon ? $coupon->id : null,
            'coupon_code' => $coupon ? $coupon->code : null,
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
