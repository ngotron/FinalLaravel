<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Wishlist;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.header',  'page.checkout'], function ($view) {
            $typeProduct = ProductType::all();
            if (Session('cart')) {
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $view->with(['cart' => Session::get('cart'), 'product_cart' => $cart->items, 'totalPrice' => $cart->totalPrice, 'totalQty' => $cart->totalQty]);
            }
            $view->with(['typeProduct' => $typeProduct]);
        });
        view()->composer(['layouts.header'], function ($view) {
            if (Session('user')) {
                $user = Session::get('user');
                $wishlists = Wishlist::where('id_user', $user->id)->get();
                $sumWishlist = 0;
                $totalWishlist = 0;
                $productsInWishlist = [];
                if (isset($wishlists)) {
                    foreach ($wishlists as $item) {
                        $sumWishlist += $item->quantity;
                        $product = Product::find($item->id_product);
                        $productsInWishlist[] = $product;
                        if ($product->promotion_price == 0) {
                            $totalWishlist += (intval($item->quantity) * intval($product->unit_price));
                        } else {
                            $totalWishlist += (intval($item->quantity) * intval($product->promotion_price));
                        }
                    }
                }

                $view->with(['user' => $user, 'wishlists' => $wishlists, 'sumWishlist' => $sumWishlist, 'productsInWishlist' => $productsInWishlist, 'totalWishlist' => $totalWishlist]);
            }
        });
    }
}
