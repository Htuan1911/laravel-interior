<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {
    // Các đường dẫn trong nhóm admin sẽ đặt trong đây
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route quản lý sản phẩm
    // Route::prefix('products')->name('products.')->group(function () {
    //     Route::get('/',                     [ProductController::class, 'index'])->name('index');
    //     Route::get('/create',               [ProductController::class, 'create'])->name('create');
    //     Route::post('/store',               [ProductController::class, 'store'])->name('store');
    //     Route::get('/{id}/edit',            [ProductController::class, 'edit'])->name('edit');
    //     Route::put('/{id}/update',          [ProductController::class, 'update'])->name('update');
    //     Route::delete('/{id}/destroy',      [ProductController::class, 'destroy'])->name('destroy');
    // });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/',                     [CategoryController::class, 'index'])->name('index');
        Route::get('/create',               [CategoryController::class, 'create'])->name('create');
        Route::post('/store',               [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [CategoryController::class, 'destroy'])->name('destroy');
    });

});
