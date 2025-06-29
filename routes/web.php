<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOptionValueController;

use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;


// Trang chính
Route::get('/', function () {
    return view('welcome');
});

// Giao diện người dùng (cần đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

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
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{id}/edit-status', [OrderController::class, 'editStatus'])->name('orders.editStatus');
    Route::put('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

