<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Toastr;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('backEnd.coupon.coupon', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_name' => 'required|string|max:100|unique:coupons,coupon_name',
            'coupon_type' => 'required|in:1,2',
            'amount' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'validity' => 'required|date',
        ]);

        Coupon::create([
            'coupon_name' => strtoupper(trim($request->coupon_name)),
            'coupon_type' => $request->coupon_type,
            'amount' => $request->amount,
            'count' => $request->quantity,
            'validity' => $request->validity,
            'unique_id' => $request->coupon_type . uniqid() . $request->amount . $request->validity,
        ]);

        Toastr::success('Coupon added successfully', 'Success');
        return back()->with('success', 'Coupon added successfully');
    }

    public function delete($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            CouponUser::where('coupon_id', $id)->delete();
            $coupon->delete();
            Toastr::success('Coupon deleted successfully', 'Success');
            return back()->with('cpn_dlt', 'Coupon deleted successfully');
        }
        Toastr::error('Coupon not found', 'Error');
        return back();
    }

    public function apply(Request $request)
    {
        $couponCode = strtoupper(trim((string) $request->coupon));
        if (empty($couponCode)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a coupon code.',
            ]);
        }

        $pack = Coupon::where('coupon_name', $couponCode)->first();
        if (!$pack) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Coupon Code.',
            ]);
        }

        if ($pack->count <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached!',
            ]);
        }

        if (Carbon::parse($pack->validity)->endOfDay()->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon has expired!',
            ]);
        }

        // Check customer specific usage if customer is authenticated or customer ID provided
        $customerId = Auth::guard('customer')->id() ?? $request->customer;
        if ($customerId) {
            $alreadyUsed = CouponUser::where('customer_id', $customerId)
                ->where('coupon_id', $pack->id)
                ->exists();

            if ($alreadyUsed) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already used this coupon.',
                ]);
            }
        }

        $cartAmount = (float) $request->amount;
        if ($cartAmount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cart amount is invalid.',
            ]);
        }

        if ($pack->coupon_type == 2) {
            // Percentage discount
            $discount = round(($cartAmount / 100) * $pack->amount);
        } else {
            // Flat amount discount
            $discount = round($pack->amount);
        }

        // Prevent discount exceeding cart amount
        if ($discount > $cartAmount) {
            $discount = $cartAmount;
        }

        $total = $cartAmount - $discount;

        // Store in Session so order placement always remembers it!
        Session::put('coupon_id', $pack->id);
        Session::put('coupon_code', $pack->coupon_name);
        Session::put('discount', $discount);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'amount' => $total,
            'discount' => $discount,
            'id' => $pack->id,
            'code' => $pack->coupon_name,
        ]);
    }
}
