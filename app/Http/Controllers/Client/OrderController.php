<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $selectedItemIds = $request->input('selected_items', []);

        if (empty($selectedItemIds)) {
            return redirect()->route('client.carts.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('client.carts.index')->with('error', 'Không tìm thấy giỏ hàng.');
        }

        $items = CartItem::with('variant.product')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $selectedItemIds)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('client.carts.index')->with('error', 'Không tìm thấy sản phẩm đã chọn.');
        }

        $productTotal = 0;
        foreach ($items as $item) {
            $productTotal += $item->variant->price * $item->quantity;
        }

        $shippingArea = $request->input('shipping_area');
        $shippingFee = $shippingArea === 'outer' ? 30000 : 0;

        $discountId = session('applied_coupon_id');
        $discountAmount = session('discount_amount', 0);
        $total = max(0, $productTotal + $shippingFee - $discountAmount);

        if ($request->payment_method === 'online' && $total > 50000000) {
            return redirect()
                ->route('client.carts.index')
                ->with('error', 'Không thể thanh toán online cho đơn hàng trên 50 triệu.');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_area' => $shippingArea,
                'shipping_fee' => $shippingFee,
                'discount_id' => $discountId,
                'discount_amount' => $discountAmount,
                'booking_code' => 'ORD-' . now()->format('Ymd') . '-' . str_pad(Order::max('id') + 1, 5, '0', STR_PAD_LEFT),
            ]);

            // ✅ Tăng số lượt sử dụng mã giảm giá
            if ($discountId) {
                $coupon = Coupon::find($discountId);
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            foreach ($items as $item) {
                $variant = $item->variant;

                if ($variant->stock_quantity < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('client.carts.index')->with('error', 'Sản phẩm "' . ($variant->name ?? $variant->product->translations->first()->name ?? '---') . '" không đủ hàng.');
                }

                $variant->stock_quantity -= $item->quantity;
                $variant->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'variant_id' => $variant->id,
                    'quantity' => $item->quantity,
                    'unit_price' => $variant->price,
                    'total_price' => $variant->price * $item->quantity,
                    'variant_name' => $variant->name ?? $variant->product->translations->first()->name ?? '---',
                    'base_price_snapshot' => $variant->product->base_price ?? $variant->price,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'amount' => $total,
                'method' => $request->payment_method,
                'status' => 'pending',
                'transaction_code' => null,
                'paid_at' => null,
            ]);

            CartItem::where('cart_id', $cart->id)
                ->whereIn('id', $selectedItemIds)
                ->delete();

            session()->forget(['applied_coupon_id', 'discount_amount', 'cart_count']);

            DB::commit();

            if ($request->payment_method === 'cod') {
                return redirect()->route('client.orders.history')->with('success', 'Đặt hàng thành công!');
            } elseif ($request->payment_method === 'online') {
                return $this->momo_payment($request, $order);
            }

            return redirect()->route('client.carts.index')->with('error', 'Phương thức thanh toán không hợp lệ.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('client.carts.index')->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng.');
        }
    }

    // ✅ Thêm shippingForm
    public function shippingForm(Request $request)
    {
        $selectedItemIds = $request->input('selected_items', []);

        if (empty($selectedItemIds)) {
            return redirect()->route('client.carts.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        $paymentMethod = $request->payment_method;

        if (!in_array($paymentMethod, ['cod', 'online', 'momo', 'vnpay'])) {
            return redirect()->route('client.carts.index')->with('error', 'Phương thức thanh toán không hợp lệ.');
        }

        $cart = Cart::where('user_id', auth()->id())->first();

        $items = CartItem::with('variant.product')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $selectedItemIds)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('client.carts.index')->with('error', 'Không tìm thấy sản phẩm đã chọn.');
        }

        return view('client.orders.shipping', compact('items', 'paymentMethod', 'cart'));
    }
    public function history()
{
    $orders = Order::with(['items.variant.product', 'payment'])
        ->where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->get();

    $cart = auth()->user()->cart()->with('items.variant.product.translations')->first();

    return view('client.orders.history', compact('orders', 'cart'));
}


    // ... các phương thức momo_payment, momoReturn, momoIpn, cancel, history giữ nguyên như bạn đã viết
}
