<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ClientReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Kiểm tra xem user có quyền đánh giá order item này không
        $orderItem = \App\Models\OrderItem::find($request->order_item_id);

        if (!$orderItem) {
            return redirect()->back()->withErrors('Sản phẩm không tồn tại.');
        }

        // Kiểm tra user có phải owner của đơn hàng chứa order item này không
        if ($orderItem->order->user_id !== Auth::id()) {
            return redirect()->back()->withErrors('Bạn không có quyền đánh giá sản phẩm này.');
        }

        // Tạo review
        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'order_item_id' => $request->order_item_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
