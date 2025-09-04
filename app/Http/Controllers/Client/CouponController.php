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

        $coupon = Coupon::where('code', $code)
            ->where('is_active', 1)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn']);
        }

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu']);
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã được sử dụng tối đa']);
        }

        // Tính số tiền giảm
        $discountAmount = 0;

        if ($coupon->discount_percent && !$coupon->discount_amount) {
            // Tính giảm theo %
            $discountAmount = $subtotal * ($coupon->discount_percent / 100);

            // Nếu số tiền giảm > giới hạn, chỉ giảm tới mức giới hạn
            if (!is_null($coupon->max_discount_amount) && $discountAmount > $coupon->max_discount_amount) {
                $discountAmount = $coupon->max_discount_amount;
            }
        } elseif ($coupon->discount_amount && !$coupon->discount_percent) {
            // Giảm theo số tiền
            $discountAmount = $coupon->discount_amount;
        } else {
            // Nếu có cả % và số tiền thì báo lỗi
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ (không được vừa % vừa số tiền)',
            ]);
        }

        // Đảm bảo không giảm vượt quá tổng tiền đơn hàng
        $discountAmount = min($discountAmount, $subtotal);
        $total = $subtotal - $discountAmount;

        // Lưu thông tin vào session
        session([
            'applied_coupon_id' => $coupon->id,
            'discount_amount' => $discountAmount,
            'discount_total' => $total,
        ]);

        // Trả kết quả
        return response()->json([
            'success' => true,
            'message' => "Áp dụng mã {$code} thành công - giảm "
                . number_format($discountAmount, 0, ',', '.') . "đ"
                . ($coupon->max_discount_amount ? " (giảm tối đa: " . number_format($coupon->max_discount_amount, 0, ',', '.') . "đ)" : ""),
            'total' => $total,
            'shipping_fee' => 0,
        ]);
    }
}
