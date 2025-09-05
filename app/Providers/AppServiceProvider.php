<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

<<<<<<< HEAD

class AppServiceProvider extends ServiceProvider 
{
    /**
     * Register any application services.
     */
=======
class AppServiceProvider extends ServiceProvider
{
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
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

            if (auth()->check()) {
                $cart = Cart::with('items.variant.product')
                    ->where('user_id', auth()->id())
                    ->first() ?? (object)['items' => collect()];
            } else {
                $cart = (object)['items' => collect()];
            }

            $view->with('cart', $cart);
        });
<<<<<<< HEAD
}
=======
    }
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
}
