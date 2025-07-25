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

        if ($request->payment_method === 'momo' && $total > 50000000) {
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
            } elseif ($request->payment_method === 'momo') {
                return $this->momo_payment($request, $order);
            } elseif ($request->payment_method === 'vnpay') {
                return $this->vnpay_payment($request, $order); // Gọi xử lý VNPay tại đây
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

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request, Order $order)
    {
        // Ghi log toàn bộ dữ liệu MoMo trả về
        Log::info('MoMo RETURN DATA:', $request->all());

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán đơn hàng #" . $order->id;
        $amount = (int) $order->total_amount;
        $orderId = $order->id . '-' . time();
        $requestId = $order->id . '-' . time();

        $redirectUrl = route('client.orders.momo_return');
        $ipnUrl = route('client.orders.momo_ipn');
        $extraData = "";

        $requestType = "payWithATM";

        $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $response = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($response, true);

        return redirect()->to($jsonResult['payUrl']);
    }

    public function momoReturn(Request $request)
    {
        Log::info('MoMo RETURN (Redirect):', $request->all());
        $orderId = $request->orderId;
        $resultCode = $request->resultCode;

        // Có thể tách mã đơn hàng từ orderId nếu cần
        $orderIdOnly = explode('-', $orderId)[0] ?? null;

        $order = Order::find($orderIdOnly);

        if (!$order) {
            return redirect()->route('client.orders.history')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($resultCode == 0) {
            // Thành công
            $order->update(['status' => 'paid']);

            // Cập nhật payment nếu có
            $order->payment()->update([
                'status' => 'paid',
                'transaction_code' => $request->transId,
                'paid_at' => now(),
            ]);

            return redirect()->route('client.orders.history')->with('success', 'Thanh toán MoMo thành công!');
        } else {
            // Thất bại
            $order->update(['status' => 'pending']);

            return redirect()->route('client.orders.history')->with('error', 'Thanh toán bị hủy hoặc thất bại!');
        }
    }

    public function momoIpn(Request $request)
    {
        Log::info('MoMo IPN (Callback):', $request->all());
        $data = $request->all();

        Log::info('MoMo IPN Received:', $data); // Log ra để debug

        $orderIdOnly = explode('-', $data['orderId'])[0] ?? null;

        $order = Order::find($orderIdOnly);

        if (!$order) {
            return response('Order not found', 404);
        }

        if ($data['resultCode'] == 0) {
            // Thành công
            $order->update(['status' => 'paid']);

            $order->payment()->update([
                'status' => 'paid',
                'transaction_code' => $data['transId'] ?? null,
                'paid_at' => now(),
            ]);
        } else {
            // Thất bại
            $order->update(['status' => 'cancelled']);

            $order->payment()->update([
                'status' => 'cancelled',
            ]);
        }

        return response('OK', 200); // MoMo cần phản hồi 'OK'
    }

    public function vnpay_payment(Request $request, Order $order)
    {
        $code_cart = $order->id . '-' . time(); // tạo mã đơn hàng duy nhất

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('client.orders.vnpay_return');
        $vnp_TmnCode = "QZIUA5MS";
        $vnp_HashSecret = "1CBH5W640QCETVSBBWI4IEY7L2QSN0EK";

        $vnp_TxnRef = $code_cart;
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = (int) $order->total_amount * 100; // từ order thay vì $request
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $hashdata = '';
        $query = '';

        foreach ($inputData as $key => $value) {
            $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . '=' . urlencode($value);
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

        return redirect()->away($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        Log::info('VNPay RETURN:', $request->all());

        $vnp_ResponseCode = $request->vnp_ResponseCode;
        $vnp_TxnRef = $request->vnp_TxnRef;
        $vnp_TransactionNo = $request->vnp_TransactionNo;

        // Lấy order id từ mã đơn hàng
        $orderIdOnly = explode('-', $vnp_TxnRef)[0] ?? null;
        $order = Order::find($orderIdOnly);

        if (!$order) {
            return redirect()->route('client.orders.history')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công
            $order->update(['status' => 'paid']);

            $order->payment()->update([
                'status' => 'paid',
                'transaction_code' => $vnp_TransactionNo,
                'paid_at' => now(),
            ]);

            return redirect()->route('client.orders.history')->with('success', 'Thanh toán VNPay thành công!');
        } else {
            // Thanh toán thất bại
            $order->update(['status' => 'pending']);

            return redirect()->route('client.orders.history')->with('error', 'Thanh toán VNPay thất bại hoặc bị hủy!');
        }
    }





    public function cancel(Order $order)
    {
        // Kiểm tra quyền hủy
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Không có quyền hủy đơn này.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn đang chờ xử lý.');
        }

        DB::beginTransaction();

        try {
            // Load danh sách item và variant
            $order->load('items.variant');

            foreach ($order->items as $item) {
                // Tăng lại tồn kho cho variant
                if ($item->variant) {
                    $item->variant->increment('stock_quantity', $item->quantity);
                }
            }

            // Cập nhật trạng thái đơn hàng
            $order->status = 'cancelled';
            $order->save();

            DB::commit();

            return back()->with('success', 'Đơn hàng đã được hủy.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Hủy đơn hàng thất bại: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi hủy đơn hàng.');
        }
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
}
