<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
   
    {
        $reviews = Review::with(['user', 'orderItem'])
                         ->orderByDesc('created_at')
                         ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $users = User::all();
        $orderItems = OrderItem::all();

        return view('admin.reviews.create', compact('users', 'orderItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Review::create($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
    }

    public function show(Review $reviews)
    {
        $reviews->load(['user', 'orderItem']);
        return view('admin.reviews.show', compact('reviews'));
    }

    public function edit(Review $reviews)
    {
        $users = User::all();
        $orderItems = OrderItem::all();

        return view('admin.reviews.edit', compact('reviews', 'users', 'orderItems'));
    }

    public function update(Request $request, Review $reviews)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $reviews->update($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $reviews)
    {
        $reviews->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
    public function toggleVisibility(Review $review)
{
    $review->is_visible = !$review->is_visible;
    $review->save();

    return redirect()->back()->with('success', 'Cập nhật hiển thị đánh giá thành công.');
}
}


