<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $properties = $user->isSuperAdmin() 
            ? Property::all() 
            : Property::where('admin_id', $user->id)->get();
            
        $propertyIds = $properties->pluck('id');
        
        // Base Query
        $query = Booking::whereIn('payment_status', ['Paid', 'completed', 'successful']);
        
        if (!$user->isSuperAdmin()) {
            $query->whereIn('property_id', $propertyIds);
        }
            
        // Filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('check_in', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('check_in', $month->month)
                  ->whereYear('check_in', $month->year);
        }
        
        if ($request->filled('type')) {
            if ($request->type == 'stay') {
                $query->where(function($q) {
                    $q->where('type', 'stay')->orWhereNull('type')->orWhere('type', 'property');
                });
            } else {
                $query->where('type', $request->type);
            }
        }
        
        $bookings = $query->get();
        
        // Calculating Metrics
        $totalRevenue = $bookings->sum('amount');
        
        $monthlyQuery = Booking::whereIn('payment_status', ['Paid', 'completed', 'successful'])
            ->whereMonth('check_in', Carbon::now()->month)
            ->whereYear('check_in', Carbon::now()->year);
        if (!$user->isSuperAdmin()) $monthlyQuery->whereIn('property_id', $propertyIds);
        $monthlyRevenue = $monthlyQuery->sum('amount');
            
        $weeklyQuery = Booking::whereIn('payment_status', ['Paid', 'completed', 'successful'])
            ->whereBetween('check_in', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        if (!$user->isSuperAdmin()) $weeklyQuery->whereIn('property_id', $propertyIds);
        $weeklyRevenue = $weeklyQuery->sum('amount');
            
        $todayQuery = Booking::whereIn('payment_status', ['Paid', 'completed', 'successful'])
            ->whereDate('check_in', Carbon::today());
        if (!$user->isSuperAdmin()) $todayQuery->whereIn('property_id', $propertyIds);
        $todayRevenue = $todayQuery->sum('amount');
            
        // Bookings Metrics
        $totalBookings = $bookings->count();
        
        $upcomingBookingsQuery = Booking::whereDate('check_in', '>=', Carbon::today());
        if (!$user->isSuperAdmin()) $upcomingBookingsQuery->whereIn('property_id', $propertyIds);
        $upcomingBookings = $upcomingBookingsQuery->count();
        
        $pendingPaymentsQuery = Booking::whereIn('payment_status', ['Pending', 'pending']);
        if (!$user->isSuperAdmin()) $pendingPaymentsQuery->whereIn('property_id', $propertyIds);
        $pendingPayments = $pendingPaymentsQuery->count();
        
        $completedPaymentsQuery = Booking::whereIn('payment_status', ['Paid', 'completed', 'successful']);
        if (!$user->isSuperAdmin()) $completedPaymentsQuery->whereIn('property_id', $propertyIds);
        $completedPayments = $completedPaymentsQuery->count();
        
        // Breakdown
        $stayRevenue = $bookings->filter(function($b) { return in_array($b->type, ['stay', 'property', null]); })->sum('base_amount');
        $eventRevenue = $bookings->where('type', 'event')->sum('amount');
        $yachtRevenue = $bookings->where('type', 'yacht')->sum('amount');
        $amenitiesRevenue = $bookings->sum('amenity_total');
        
        // If base_amount + amenity_total is less than amount (plus discounts), the difference might be food package
        $foodPackageRevenue = $bookings->filter(function($b) { return in_array($b->type, ['stay', 'property', null]); })
            ->sum(function($b) {
                $gross = $b->amount + ($b->discount_amount ?? 0);
                return max(0, $gross - ($b->base_amount + $b->amenity_total));
            });

        // Charts Data
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            $label = $monthStart->format('M Y');
            
            $monthQuery = Booking::whereIn('payment_status', ['Paid', 'completed', 'successful'])
                ->whereBetween('check_in', [$monthStart, $monthEnd]);
            if (!$user->isSuperAdmin()) $monthQuery->whereIn('property_id', $propertyIds);
            
            $monthTotal = $monthQuery->sum('amount');
                
            $monthlyTrends['labels'][] = $label;
            $monthlyTrends['data'][] = $monthTotal;
        }

        return view('admin.revenue.index', compact(
            'properties',
            'bookings',
            'totalRevenue',
            'monthlyRevenue',
            'weeklyRevenue',
            'todayRevenue',
            'totalBookings',
            'upcomingBookings',
            'pendingPayments',
            'completedPayments',
            'stayRevenue',
            'eventRevenue',
            'yachtRevenue',
            'amenitiesRevenue',
            'foodPackageRevenue',
            'monthlyTrends'
        ));
    }
}
