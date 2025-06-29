<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// view người dùng
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard'); // tạo view này
    })->name('user.dashboard');
});


require __DIR__.'/auth.php';


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOptionValueController;


Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {
    // Các đường dẫn trong nhóm admin sẽ đặt trong đây
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/',                     [CategoryController::class, 'index'])->name('index');
        Route::get('/create',               [CategoryController::class, 'create'])->name('create');
        Route::post('/store',               [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [CategoryController::class, 'destroy'])->name('destroy');
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
  

// Quản lý sản phẩm
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


 

    // Quản lý users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/show', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}/destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    // Quản lý wishlists
    Route::prefix('wishlists')->name('wishlists.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::get('/create', [WishlistController::class, 'create'])->name('create');
        Route::post('/store', [WishlistController::class, 'store'])->name('store');
        Route::get('/{user}/show', [WishlistController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [WishlistController::class, 'edit'])->name('edit');
        Route::put('/{user}/update', [WishlistController::class, 'update'])->name('update');
        Route::delete('/{user}/destroy', [WishlistController::class, 'destroy'])->name('destroy');
    });
});
