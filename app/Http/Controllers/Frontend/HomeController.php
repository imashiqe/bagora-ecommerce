<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Banners
        |--------------------------------------------------------------------------
        */

        $banners = Banner::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Best Selling Products
        |--------------------------------------------------------------------------
        */

        $bestSellingProducts = Product::query()
            ->with([
                'category',
                'brand',
            ])
            ->where('status', true)
            ->where('best_seller', true)
            ->latest('id')
            ->take(12)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Featured Products
        |--------------------------------------------------------------------------
        */

        $featuredProducts = Product::query()
            ->with([
                'category',
                'brand',
            ])
            ->where('status', true)
            ->where('featured', true)
            ->latest('id')
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | New Arrivals
        |--------------------------------------------------------------------------
        */

        $newArrivalProducts = Product::query()
            ->with([
                'category',
                'brand',
            ])
            ->where('status', true)
            ->where('new_arrival', true)
            ->latest('id')
            ->take(12)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Latest Products
        |--------------------------------------------------------------------------
        */

     $latestProducts = Product::query()
    ->with([
        'category',
        'brand',
    ])
    ->where('status', 1)
    ->latest('id')
    ->take(12)
    ->get();


        /*
        |--------------------------------------------------------------------------
        | Homepage
        |--------------------------------------------------------------------------
        */

return view('frontend.main', compact(
    'banners',
    'categories',
    'bestSellingProducts',
    'featuredProducts',
    'newArrivalProducts',
    'latestProducts'
));
    }
}