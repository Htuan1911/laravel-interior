<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
    }
}
