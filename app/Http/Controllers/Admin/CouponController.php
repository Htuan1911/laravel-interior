<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'code' => 'required|unique:coupons,code',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'discount_amount' => 'nullable|numeric|min:0',
        'min_order_amount' => 'nullable|numeric|min:0',
        'max_uses' => 'nullable|integer|min:1',
        'expires_at' => 'nullable|date',
    ]);

    $validated['is_active'] = $request->has('is_active');
    $validated['used_count'] = 0;

    \App\Models\Coupon::create($validated);

    return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
}

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
{
    $coupon = \App\Models\Coupon::findOrFail($id);

    $validated = $request->validate([
        'code' => 'required|unique:coupons,code,' . $coupon->id,
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'discount_amount' => 'nullable|numeric|min:0',
        'min_order_amount' => 'nullable|numeric|min:0',
        'max_uses' => 'nullable|integer|min:1',
        'expires_at' => 'nullable|date',
    ]);

    $validated['is_active'] = $request->has('is_active');

    $coupon->update($validated);

    return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
}

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
