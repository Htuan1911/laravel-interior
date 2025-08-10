<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index(Request $request)
{
    $query = Coupon::query();

    // Nếu có từ khóa tìm kiếm
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
              ->orWhere('discount_percent', 'like', "%{$search}%")
              ->orWhere('discount_amount', 'like', "%{$search}%");
        });
    }

    // Lấy danh sách mã giảm giá (có phân trang)
    $coupons = $query->orderByDesc('id')->paginate(10);

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
            'discount_percent' => 'nullable|numeric|min:0|max:70',
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

    // ===============================
    // ✅ Logic áp mã giảm giá cố định
    // ===============================
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'order_total' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->first();

        if (!$coupon) {
            return response()->json(['error' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'], 400);
        }

        // Kiểm tra điều kiện đơn tối thiểu
        if ($request->order_total < $coupon->min_order_amount) {
            return response()->json(['error' => 'Đơn hàng chưa đủ điều kiện áp mã.'], 400);
        }

        $discount = 0;
        if ($coupon->discount_percent) {
            $discount = $request->order_total * ($coupon->discount_percent / 100);
            // Giới hạn giảm tối đa
            $discount = min($discount, $coupon->max_discount_amount);
        } elseif ($coupon->discount_amount) {
            $discount = $coupon->discount_amount;
        }

        return response()->json([
            'message' => 'Áp mã thành công!',
            'discount' => round($discount),
            'final_total' => round($request->order_total - $discount),
        ]);
    }
}
