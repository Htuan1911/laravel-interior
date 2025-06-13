<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\ProductWithoutVariantsController;
use App\Http\Controllers\Admin\UserController;

use Illuminate\Support\Facades\Route;

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


    //Quản lý sản phẩm đã có biến thể
    // Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ProductController::class, 'destroy'])->name('destroy');
        // routes/web.php
         // ✅ Route AJAX lấy thông tin sản phẩm
        // Route::get('/{id}/info', [ProductController::class, 'getProductInfo'])->name('info');


    });

      // Quản lý biến thể sản phẩm
   Route::prefix('variants')->name('variants.')->group(function () {
    Route::get('/', [ProductVariantController::class, 'index'])->name('index');
    Route::get('/create', [ProductVariantController::class, 'create'])->name('create');
    Route::post('/store', [ProductVariantController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProductVariantController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [ProductVariantController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [ProductVariantController::class, 'destroy'])->name('destroy');
   });

   // Quản lý sản phẩm không có biến thể
    Route::prefix('products_without_variants')->name('products_without_variants.')->group(function () {
        Route::get('/', [ProductWithoutVariantsController::class, 'index'])->name('index');
        Route::get('/create', [ProductWithoutVariantsController::class, 'create'])->name('create');
        Route::post('/store', [ProductWithoutVariantsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductWithoutVariantsController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductWithoutVariantsController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ProductWithoutVariantsController::class, 'destroy'])->name('destroy');
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

});
Route::get('/admin/products/{id}/info', [ProductController::class, 'getProductInfo'])->name('admin.products.info');
Route::get('/admin/variants/{sku}/info', [ProductController::class, 'getVariantInfo'])->name('admin.variants.info');









