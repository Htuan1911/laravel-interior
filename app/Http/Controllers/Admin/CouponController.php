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
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'required|date|after:today',
        ]);

        $validator->after(function ($validator) use ($request) {
            $percent = $request->discount_percent;
            $amount = $request->discount_amount;
            $minOrder = $request->min_order_amount;

            // Không được nhập cả hai loại giảm
            if ($percent && $amount) {
                $validator->errors()->add('discount_amount', 'Không được nhập cả % và số tiền giảm cùng lúc.');
            }

            // Số tiền giảm không được lớn hơn hoặc bằng đơn tối thiểu
            if ($amount && $minOrder && $amount >= $minOrder) {
                $validator->errors()->add('discount_amount', 'Số tiền giảm phải nhỏ hơn đơn tối thiểu.');
            }

            // Nếu có phần trăm giảm thì cần giới hạn số tiền giảm tối đa
            if ($percent && !$request->max_discount_amount) {
                $validator->errors()->add('max_discount_amount', 'Cần nhập giới hạn số tiền giảm nếu dùng %.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['used_count'] = 0;

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'required|date|after:today',
        ]);

        $validator->after(function ($validator) use ($request) {
            $percent = $request->discount_percent;
            $amount = $request->discount_amount;
            $minOrder = $request->min_order_amount;

            if ($percent && $amount) {
                $validator->errors()->add('discount_amount', 'Không được nhập cả % và số tiền giảm cùng lúc.');
            }

            if ($amount && $minOrder && $amount >= $minOrder) {
                $validator->errors()->add('discount_amount', 'Số tiền giảm phải nhỏ hơn đơn tối thiểu.');
            }

            if ($percent && !$request->max_discount_amount) {
                $validator->errors()->add('max_discount_amount', 'Cần nhập giới hạn số tiền giảm nếu dùng %.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['is_active'] = $request->has('is_active');

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
}
