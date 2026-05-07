<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = \App\Models\Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|alpha_dash|min:3|max:50|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0|max:100000',
        ]);

        \App\Models\Coupon::create($request->all());

        return back()->with('success', 'Coupon created successfully.');
    }

    public function toggleStatus($id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', 'Coupon status updated.');
    }

    public function destroy($id)
    {
        \App\Models\Coupon::destroy($id);
        return back()->with('success', 'Coupon deleted.');
    }

    // Customer Side: Validate Coupon
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric'
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.'
            ], 422);
        }

        $discount = $coupon->calculateDiscount($request->total);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'coupon_id' => $coupon->id,
            'discount' => $discount,
            'new_total' => $request->total - $discount,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);
    }
}
