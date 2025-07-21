<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::with('items.variant.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('client.carts.index')->with('error', 'Giỏ hàng trống.');
        }

        // Tính tổng tiền sản phẩm
        $productTotal = 0;
        foreach ($cart->items as $item) {
            $productTotal += $item->variant->price * $item->quantity;
        }

        // Tính phí ship
        $shippingArea = $request->input('shipping_area'); // 'inner' hoặc 'outer'
        $shippingFee = $shippingArea === 'outer' ? 30000 : 0;

        // Tổng tiền = sản phẩm + ship
        $total = $productTotal + $shippingFee;

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_area' => $shippingArea,
            'shipping_fee' => $shippingFee,
            'booking_code' => 'ORD-' . now()->format('Ymd') . '-' . str_pad(Order::max('id') + 1, 5, '0', STR_PAD_LEFT),
        ]);

        // Lưu order_items
        foreach ($cart->items as $item) {
            $variant = $item->variant;
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

        // Lưu payment
        Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'amount' => $total,
            'method' => $request->payment_method,
            'status' => 'pending',
            'transaction_code' => null,
            'paid_at' => null,
        ]);

        // Xoá giỏ
        $cart->items()->delete();
        session()->forget('cart_count');

        // Xử lý redirect
        if ($request->payment_method === 'cod') {
            return redirect()->route('client.orders.history')->with('success', 'Đặt hàng thành công!');
        } elseif ($request->payment_method === 'online') {
            return $this->momo_payment($order);
        }

        return redirect()->route('client.carts.index')->with('error', 'Phương thức thanh toán không hợp lệ.');
    }


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

    public function momo_payment(Order $order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán đơn hàng #" . $order->id;
        $amount = (int) $order->total_amount; // chuyển sang int, tránh lỗi định dạng
        $orderId = $order->id . '-' . time(); // mã đơn hàng duy nhất
        $requestId = $order->id . '-' . time();

        $redirectUrl = route('client.orders.momo_return'); // cần định nghĩa route này
        $ipnUrl = route('client.orders.momo_ipn'); // webhook nhận thông báo MoMo
        $extraData = ""; // có thể dùng để đính kèm mã user

        $requestType = "payWithATM";

        // Chuỗi raw dữ liệu để ký
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
            $order->update(['status' => 'cancelled']);

            return redirect()->route('client.orders.history')->with('error', 'Thanh toán bị hủy hoặc thất bại!');
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
