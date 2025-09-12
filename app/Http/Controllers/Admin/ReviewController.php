<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
//    public function index(Request $request)
// {
//     $query = Review::with([
//         'user',
//         'orderItem.variant.product.translations'
//     ]);

//     // Nếu có lọc theo số sao
//     if ($request->has('rating') && in_array($request->rating, [1,2,3,4,5])) {
//         $query->where('rating', $request->rating);
//     }

//     $reviews = $query->orderByDesc('created_at')->paginate(20);

//     return view('admin.reviews.index', compact('reviews'));
// }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// public function index(Request $request)
// {
//     $query = Review::with([
//         'user',
//         'orderItem.variant.product.translations'
//     ]);

//     // Lọc theo số sao
//     if ($request->has('rating') && in_array($request->rating, [1,2,3,4,5])) {
//         $query->where('rating', $request->rating);
//     }

//     // Lọc theo sản phẩm (theo id)
//     if ($request->has('product_id') && $request->product_id != '') {
//         $query->whereHas('orderItem.variant.product', function($q) use ($request) {
//             $q->where('id', $request->product_id);
//         });
//     }

   
// // Tìm kiếm theo tên sản phẩm

// if ($request->has('product_name') && $request->product_name != '') {
//     $search = strtolower(trim($request->product_name));

//     $query->whereHas('orderItem.variant.product', function($q) use ($search) {
//         $q->whereRaw("LOWER(name) COLLATE utf8mb4_general_ci LIKE ?", ["%{$search}%"]) // tìm trong bảng products
//           ->orWhereHas('translations', function($t) use ($search) {
//               $t->whereRaw("LOWER(name) COLLATE utf8mb4_general_ci LIKE ?", ["%{$search}%"]); // tìm trong bảng translations
//           });
//     });
// }


//     $reviews = $query->orderByDesc('created_at')->paginate(20);

//     // Lấy danh sách sản phẩm cho dropdown
//     $products = \App\Models\Product::with(['translations' => function ($q) {
//         $q->where('language_code', app()->getLocale());
//     }])->get();

//     return view('admin.reviews.index', compact('reviews', 'products'));
// }

public function index(Request $request)
{
    $query = Review::with([
        'user',
        'orderItem.variant.product.translations'
    ]);

    // Lọc theo số sao
    if ($request->has('rating') && in_array($request->rating, [1,2,3,4,5])) {
        $query->where('rating', $request->rating);
    }

    // Lọc theo sản phẩm (theo id)
    if ($request->filled('product_id')) {
        $query->whereHas('orderItem.variant.product', function($q) use ($request) {
            $q->where('id', $request->product_id);
        });
    }

    // Tìm kiếm theo tên sản phẩm
    if ($request->filled('product_name')) {
        $search = strtolower(trim($request->product_name));
        $query->whereHas('orderItem.variant.product', function($q) use ($search) {
            $q->whereRaw("LOWER(name) COLLATE utf8mb4_general_ci LIKE ?", ["%{$search}%"])
              ->orWhereHas('translations', function($t) use ($search) {
                  $t->whereRaw("LOWER(name) COLLATE utf8mb4_general_ci LIKE ?", ["%{$search}%"]);
              });
        });
    }

    // ✅ Lọc theo ngày
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // ✅ Lọc theo tháng
    if ($request->filled('month')) {
        $query->whereMonth('created_at', $request->month);
    }

    // ✅ Lọc theo năm
    if ($request->filled('year')) {
        $query->whereYear('created_at', $request->year);
    }

    $reviews = $query->orderByDesc('created_at')->paginate(20);

    // Lấy danh sách sản phẩm cho dropdown
    $products = \App\Models\Product::with(['translations' => function ($q) {
        $q->where('language_code', app()->getLocale());
    }])->get();
    $products = $products->sortBy(function ($product) {
    return optional($product->translations->first())->name;
});

    return view('admin.reviews.index', compact('reviews', 'products'));
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


