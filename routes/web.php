<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AdminCartController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\ChatbotController;


use App\Http\Controllers\Auth\PasswordController;


use App\Http\Controllers\Admin\RevenueController;


use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\WishlistControllers;
use App\Http\Controllers\Client\PostControllerUser;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Admin\CartItemController;
use App\Http\Controllers\Client\CompareController;
use App\Http\Controllers\Client\CouponController as ClientCouponController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\ClientReviewController;
use Illuminate\Support\Facades\Artisan;

// Trang chính
Route::get('/', [HomeController::class, 'index'])->name('home');
// Giao diện người dùng (cần đăng nhập)
Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', function () {
        return view('client.dashboard'); // Đường dẫn view nên là resources/views/client/dashboard.blade.php
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Khu vực quản trị
Route::prefix('auth', 'admin')->name('admin.')->group(function () {
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [RevenueController::class, 'index'])->name('dashboard');

    // Danh mục
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/show', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });


    // Quản lý thuộc tính sản phẩm
    Route::prefix('product-options')->name('product_options.')->group(function () {
        Route::get('/', [ProductOptionController::class, 'index'])->name('index');
        Route::get('/create', [ProductOptionController::class, 'create'])->name('create');
        Route::post('/', [ProductOptionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductOptionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductOptionController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductOptionController::class, 'destroy'])->name('destroy');
        Route::get('/trashed', [ProductOptionController::class, 'trashed'])->name('trashed');
        Route::post('/{id}/restore', [ProductOptionController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [ProductOptionController::class, 'forceDelete'])->name('force_delete');
    });


    // Sản phẩm có biến thể
    Route::prefix('products')->name('products.')->group(function () {

        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/category/{id}/options', [ProductController::class, 'getOptionsByCategory'])->name('category.options');


        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');

        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/force', [ProductController::class, 'forceDelete'])->name('force-delete');
        Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
        Route::get('/trashed', [ProductController::class, 'trashed'])->name('trashed');
        Route::get('/{id}/show', [ProductController::class, 'show'])->name('show');
        Route::get('/category/{id}/options', [ProductController::class, 'getAttributeNamesByCategory']);
        Route::get('/product-options/{id}/values', [ProductController::class, 'getOptionValuesByAttribute']);

    });


    // Mã giảm giá
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/store', [CouponController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CouponController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CouponController::class, 'destroy'])->name('destroy');
    });


    // Quản lý người dùng
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/show', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}/destroy', [UserController::class, 'destroy'])->name('destroy');
    });


    // Quản lý wishlist
    Route::prefix('wishlists')->name('wishlists.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::get('/create', [WishlistController::class, 'create'])->name('create');
        Route::post('/store', [WishlistController::class, 'store'])->name('store');
        Route::get('/{user}/show', [WishlistController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [WishlistController::class, 'edit'])->name('edit');
        Route::put('/{user}/update', [WishlistController::class, 'update'])->name('update');
        Route::delete('/{user}/destroy', [WishlistController::class, 'destroy'])->name('destroy');
    });


    // Quản lý đánh giá (review)
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/create', [ReviewController::class, 'create'])->name('create');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
        Route::get('/{reviews}/show', [ReviewController::class, 'show'])->name('show');
        Route::get('/{reviews}/edit', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{reviews}/update', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{reviews}/destroy', [ReviewController::class, 'destroy'])->name('destroy');
        Route::patch('/{review}/toggle-visibility', [ReviewController::class, 'toggleVisibility'])
            ->name('toggleVisibility');
    });


    // Quản lý thanh toán
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/{reviews}/show', [PaymentController::class, 'show'])->name('show');
        Route::get('/{reviews}/edit', [PaymentController::class, 'edit'])->name('edit');
        Route::put('/{reviews}/update', [PaymentController::class, 'update'])->name('update');
        Route::delete('/{reviews}/destroy', [PaymentController::class, 'destroy'])->name('destroy');
    });


    // Quản lý đơn hàng
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit-status', [OrderController::class, 'editStatus'])->name('orders.editStatus');
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');

    Route::get('/orders/history', [OrderController::class, 'history'])->name('client.orders.history');

    // post
    Route::prefix('posts')->middleware('auth')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/store', [PostController::class, 'store'])->name('posts.store');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('posts.show');
    });

    // danh muc bài viết
    Route::prefix('post_categories')->name('post_categories.')->group(function () {
        Route::get('/', [PostCategoryController::class, 'index'])->name('index');
        Route::get('/create', [PostCategoryController::class, 'create'])->name('create');
        Route::post('/store', [PostCategoryController::class, 'store'])->name('store');

        Route::get('/{id}/edit', [PostCategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PostCategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostCategoryController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('carts')->name('carts.')->group(function () {
        // Carts
        Route::get('/', [AdminCartController::class, 'index'])->name('index');
        Route::get('/trashed', [AdminCartController::class, 'trashed'])->name('trashed');
        Route::get('/{id}', [AdminCartController::class, 'show'])->name('show');
        Route::put('/{id}/status', [AdminCartController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [AdminCartController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [AdminCartController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [AdminCartController::class, 'forceDelete'])->name('forceDelete');

        // Cart items
        Route::delete('/items/{id}', [CartItemController::class, 'destroy'])->name('items.destroy');
        Route::get('/{cartId}/items/trashed', [CartItemController::class, 'trashed'])->name('items.trashed');
        Route::post('/items/{id}/restore', [CartItemController::class, 'restore'])->name('items.restore');
        Route::delete('/items/{id}/force-delete', [CartItemController::class, 'forceDelete'])->name('items.forceDelete');
    });
});




// 💥 PUBLIC ROUTES – KHÔNG CẦN ĐĂNG NHẬP
// ==========================
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/categories/{id}', [ClientCategoryController::class, 'show'])->name('categories.show');

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ClientProductController::class, 'index'])->name('index');
        Route::get('/{id}', [ClientProductController::class, 'show'])->name('show');
        Route::get('/category/{id}', [ClientProductController::class, 'category'])->name('category');
    });


    // Trang giỏ hàng
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');

    // Thêm vào giỏ hàng
    Route::post('/carts/add', [CartController::class, 'add'])->name('carts.add');

    Route::post('/increase/{item}', [CartController::class, 'increaseQuantity'])->name('carts.increase');
    Route::post('/decrease/{item}', [CartController::class, 'decreaseQuantity'])->name('carts.decrease');
    Route::delete('/remove/{item}', [CartController::class, 'removeItem'])->name('carts.remove');

    // Đặt hàng nhanh (mua ngay)
    // Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    Route::post('/orders/checkout', [ClientOrderController::class, 'checkout'])->name('orders.checkout');
    // Cổng thanh toán
    Route::post('/client/momo_payment', [ClientOrderController::class, 'momo_payment'])->name('order.momo_payment');
    Route::get('/orders/momo-return', [ClientOrderController::class, 'momoReturn'])->name('orders.momo_return');
    Route::post('/orders/momo-ipn', [ClientOrderController::class, 'momoIpn'])->name('orders.momo_ipn');

    Route::get('/orders/shipping', [ClientOrderController::class, 'shippingForm'])->name('orders.shipping');
    Route::get('/orders/history', [ClientOrderController::class, 'history'])->name('orders.history');

    Route::post('/checkout/shipping', [OrderController::class, 'shippingForm'])->name('client.orders.shipping_form');


    Route::get('/check-coupon', [ClientCouponController::class, 'check']);

    Route::put('/orders/{order}/cancel', [ClientOrderController::class, 'cancel'])->name('orders.cancel');

    // Tài khoản người dùng
    Route::prefix('account')->middleware('auth')->name('account.')->group(function () {
        Route::post('/change-password', [PasswordController::class, 'update'])->name('change_password');
        Route::get('/info', [AccountController::class, 'info'])->name('info');
        Route::post('/info', [AccountController::class, 'updateInfo'])->name('update');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/vouchers', [AccountController::class, 'vouchers'])->name('vouchers');
        Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist', [AccountController::class, 'addToWishlist'])->name('wishlist.add');
        Route::delete('/wishlist/{id}', [AccountController::class, 'removeFromWishlist'])->name('wishlist.delete');
 });

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [PostControllerUser::class, 'index'])->name('index');
        Route::get('/{slug}', [PostControllerUser::class, 'show'])->name('show');

    });

    Route::prefix('compare')->name('compare.')->group(function () {
        Route::get('/', [CompareController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CompareController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [CompareController::class, 'remove'])->name('remove');
        Route::post('/clear', [CompareController::class, 'clear'])->name('clear');
    });

    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/', [ContactController::class, 'showForm'])->name('form');
        Route::post('/', [ContactController::class, 'send'])->name('send');
    });
});



Route::prefix('client')->name('client.')->group(function () {
    Route::middleware(['auth', 'check.status'])->group(function () {


        // Trang giỏ hàng
        Route::get('/carts', [CartController::class, 'index'])->name('carts.index');

        // Thêm vào giỏ hàng
        Route::post('/carts/add', [CartController::class, 'add'])->name('carts.add');

        Route::post('/increase/{item}', [CartController::class, 'increaseQuantity'])->name('carts.increase');
        Route::post('/decrease/{item}', [CartController::class, 'decreaseQuantity'])->name('carts.decrease');
        Route::delete('/remove/{item}', [CartController::class, 'removeItem'])->name('carts.remove');
        Route::post('/orders/checkout', [ClientOrderController::class, 'checkout'])->name('orders.checkout');
        // Cổng thanh toán
        Route::post('/client/momo_payment', [ClientOrderController::class, 'momo_payment'])->name('order.momo_payment');
        Route::get('/orders/momo-return', [ClientOrderController::class, 'momoReturn'])->name('orders.momo_return');
        Route::post('/orders/momo-ipn', [ClientOrderController::class, 'momoIpn'])->name('orders.momo_ipn');
        // Gửi yêu cầu thanh toán đến VNPay (POST)
        Route::post('/client/vnpay_payment', [ClientOrderController::class, 'vnpay_payment'])->name('order.vnpay_payment');
        Route::get('/orders/vnpay-return', [ClientOrderController::class, 'vnpayReturn'])->name('orders.vnpay_return');

        Route::get('/orders/shipping', [ClientOrderController::class, 'shippingForm'])->name('orders.shipping');
        Route::get('/orders/history', [ClientOrderController::class, 'history'])->name('orders.history');
        // Mua lại đơn hàng
        Route::get('/orders/{order}/reorder', [ClientOrderController::class, 'reorder'])->name('orders.reorder');

        Route::post('/checkout/shipping', [OrderController::class, 'shippingForm'])->name('client.orders.shipping_form');
        Route::get('/check-coupon', [ClientCouponController::class, 'check']);
        Route::put('/orders/{order}/cancel', [ClientOrderController::class, 'cancel'])->name('orders.cancel');
        // Tài khoản người dùng
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/info', [AccountController::class, 'info'])->name('info');
            Route::post('/info', [AccountController::class, 'updateInfo'])->name('update');
            Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
            Route::get('/vouchers', [AccountController::class, 'vouchers'])->name('vouchers');
            Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
            Route::post('/wishlist', [AccountController::class, 'addToWishlist'])->name('wishlist.add');
            Route::delete('/wishlist/{id}', [AccountController::class, 'removeFromWishlist'])->name('wishlist.delete');
        });
        // đánh giá
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::post('/store', [ClientReviewController::class, 'store'])->name('store'); // Gửi đánh giá
            Route::get('/product/{id}', [ClientReviewController::class, 'listByProduct'])->name('product'); // Hiển thị đánh giá theo sản phẩm (tùy chọn)
        });

        Route::middleware('auth')->group(function () {
            Route::get('/wishlist', [WishlistControllers::class, 'index'])->name('wishlist.index');
            Route::post('/wishlist/toggle/{product}', [WishlistControllers::class, 'toggle'])->name('wishlist.toggle');
        });

    });


});
// Gợi ý sản phẩm (Gemini + DB)
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

// Chat AI (OpenAI)
Route::post('/chatbot/ai', [ChatbotController::class, 'chatAI'])->name('chatbot.ai');
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

// FAQ
Route::get('/chatbot/predefined', [ChatbotController::class, 'predefined'])->name('chatbot.predefined');
Route::post('/chatbot/quick', [ChatbotController::class, 'quick'])->name('chatbot.quick');

require __DIR__ . '/auth.php';


Route::get('/', function () {
    return view('welcome');
});

