<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
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






use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\WishlistControllers;
use App\Http\Controllers\Client\PostControllerUser;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Admin\CartItemController;

use App\Http\Controllers\Client\CategoryController as ClientCategoryController;



use App\Http\Controllers\Client\AccountController;

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
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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
});

// Cart
Route::prefix('admin/carts')->group(function () {
    Route::get('/', [AdminCartController::class, 'index'])->name('admin.carts.index');
    Route::get('/trashed', [AdminCartController::class, 'trashed'])->name('admin.carts.trashed');
    Route::get('/{id}', [AdminCartController::class, 'show'])->name('admin.carts.show');
    Route::put('/{id}/status', [AdminCartController::class, 'updateStatus'])->name('admin.carts.updateStatus');
    Route::delete('/{id}', [AdminCartController::class, 'destroy'])->name('admin.carts.destroy');
    Route::post('/{id}/restore', [AdminCartController::class, 'restore'])->name('admin.carts.restore');
    Route::delete('/{id}/force-delete', [AdminCartController::class, 'forceDelete'])->name('admin.carts.forceDelete');
});




Route::prefix('client')->name('client.')->group(function () {

    // Trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('client.home');

    Route::get('/', [HomeController::class, 'index'])->name('home'); // ✅ Đúng: sẽ ra client.home

    Route::get('/categories/{id}', [ClientCategoryController::class, 'show'])
        ->name('categories.show');
 

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ClientProductController::class, 'index'])->name('index'); // => client.products.index
        Route::get('/{id}', [ClientProductController::class, 'show'])->name('show');
        // routes/web.php
        Route::get('/category/{id}', [ClientProductController::class, 'category'])->name('category');
        // => client.products.show
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


    // Tài khoản người dùng
    Route::prefix('account')->middleware('auth')->name('account.')->group(function () {
        Route::get('/info', [AccountController::class, 'info'])->name('info');
        Route::post('/info', [AccountController::class, 'updateInfo'])->name('update');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist', [AccountController::class, 'addToWishlist'])->name('wishlist.add');
        Route::delete('/wishlist/{id}', [AccountController::class, 'removeFromWishlist'])->name('wishlist.delete');
    });

    // bài viết
    Route::prefix('blog')->group(function () {
        Route::get('/', [PostControllerUser::class, 'index'])->name('blog.index');
        Route::get('/{slug}', [PostControllerUser::class, 'show'])->name('blog.show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistControllers::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistControllers::class, 'toggle'])->name('wishlist.toggle');

});


Route::prefix('admin')->name('admin.')->group(function () {
    // Xoá mềm sản phẩm trong giỏ
    Route::delete('carts/items/{id}', [CartItemController::class, 'destroy'])->name('carts.items.destroy');

    // Hiển thị sản phẩm đã xoá (thùng rác)
    Route::get('carts/{cartId}/items/trashed', [CartItemController::class, 'trashed'])->name('carts.items.trashed');

    // Khôi phục sản phẩm
    Route::post('carts/items/{id}/restore', [CartItemController::class, 'restore'])->name('carts.items.restore');

    // Xoá vĩnh viễn
    Route::delete('carts/items/{id}/force-delete', [CartItemController::class, 'forceDelete'])->name('carts.items.forceDelete');
});


// routes/web.php

    // Liên hệ
    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'showForm'])->name('contact.form');
        Route::post('/', [ContactController::class, 'send'])->name('contact.send');
    });
});


require __DIR__ . '/auth.php';
