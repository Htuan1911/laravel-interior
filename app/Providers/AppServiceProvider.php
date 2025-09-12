<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Sửa phân trang theo Bootstrap 5
        Paginator::useBootstrapFive();

        // Chia sẻ biến giỏ hàng
        View::composer('*', function ($view) {
            $cart = null;

            if (Auth::check()) {
                $cart = Cart::with('items.variant.product')
                    ->where('user_id', Auth::id())
                    ->first() ?? (object)['items' => collect()];
            } else {
                $cart = (object)['items' => collect()];
            }

            $view->with('cart', $cart);
        });

    }
}
