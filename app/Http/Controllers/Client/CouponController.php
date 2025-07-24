<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function check(Request $request)
    {
        $code = $request->code;
        $subtotal = (float) $request->subtotal;

        $discount = Coupon::where('code', $code)
            ->where('is_active', 1)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$discount) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn']);
        }

        if ($discount->min_order_amount && $subtotal < $discount->min_order_amount) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu']);
        }

        if ($discount->max_uses && $discount->used_count >= $discount->max_uses) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã được sử dụng tối đa']);
        }

        // Tính giảm
        $discountAmount = 0;
        if ($discount->discount_percent) {
            $discountAmount = $subtotal * ($discount->discount_percent / 100);
        } elseif ($discount->discount_amount) {
            $discountAmount = $discount->discount_amount;
        }

        $discountAmount = min($discountAmount, $subtotal); // Không âm
        $total = $subtotal - $discountAmount;

        // Lưu vào session để áp dụng sau khi submit đơn
        session(['applied_coupon_id' => $discount->id]);
        session(['discount_amount' => $discountAmount]);
        session(['discount_total' => $total]);

        return response()->json([
            'success' => true,
            'message' => "Áp dụng mã {$code} thành công - giảm " . number_format($discountAmount, 0, ',', '.') . "đ",
            'total' => $total,
            'shipping_fee' => 0,
        ]);
    }
}
