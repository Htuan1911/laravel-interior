<?php

namespace App\Providers;

<<<<<<< HEAD
use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
=======
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
>>>>>>> c9dcbb0 (Push dự án Laravel lên GitHub)
    public function register(): void
    {
        //
    }

<<<<<<< HEAD
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
=======
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
>>>>>>> c9dcbb0 (Push dự án Laravel lên GitHub)
    }
}
