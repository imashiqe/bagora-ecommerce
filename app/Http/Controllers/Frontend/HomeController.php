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



      /*
    |--------------------------------------------------------------------------
    | shop
    |--------------------------------------------------------------------------
    */

    public function shop(): View
    {
        return view('frontend.pages.shop');
    }


      /*
    |--------------------------------------------------------------------------
    | ABOUT
    |--------------------------------------------------------------------------
    */

    public function about(): View
    {
        return view('frontend.pages.about');
    }


    /*
    |--------------------------------------------------------------------------
    | BLOG GRID
    |--------------------------------------------------------------------------
    */

    public function blog(): View
    {
        return view('frontend.pages.blog.index');
    }


    /*
    |--------------------------------------------------------------------------
    | BLOG DETAILS
    |--------------------------------------------------------------------------
    */

    public function blogDetails(): View
    {
        return view('frontend.pages.blog.show');
    }


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    public function cart(): View
    {
        return view('frontend.pages.cart');
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout(): View
    {
        return view('frontend.pages.checkout');
    }


 

    /*
    |--------------------------------------------------------------------------
    | CONTACT
    |--------------------------------------------------------------------------
    */

    public function contact(): View
    {
        return view('frontend.pages.contact');
    }


    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */

    public function faq(): View
    {
        return view('frontend.pages.faq');
    }


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    public function forgotPassword(): View
    {
        return view('frontend.pages.forgot-password');
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER SUCCESS
    |--------------------------------------------------------------------------
    */

    public function orderSuccess(): View
    {
        return view('frontend.pages.order-success');
    }


    /*
    |--------------------------------------------------------------------------
    | OTP VERIFICATION
    |--------------------------------------------------------------------------
    */

    public function otpVerification(): View
    {
        return view('frontend.pages.otp-verification');
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD LOST
    |--------------------------------------------------------------------------
    */

    public function passwordLost(): View
    {
        return view('frontend.pages.password-lost');
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD RESET SUCCESS
    |--------------------------------------------------------------------------
    */

    public function passwordResetSuccess(): View
    {
        return view('frontend.pages.password-reset-success');
    }


    /*
    |--------------------------------------------------------------------------
    | PRIVACY POLICY
    |--------------------------------------------------------------------------
    */

    public function privacyPolicy(): View
    {
        return view('frontend.pages.privacy-policy');
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT DETAILS
    |--------------------------------------------------------------------------
    */

    public function productDetails(): View
    {
        return view('frontend.pages.product-details');
    }


    /*
    |--------------------------------------------------------------------------
    | RETURN POLICY
    |--------------------------------------------------------------------------
    */

    public function returnPolicy(): View
    {
        return view('frontend.return-policy');
    }


    /*
    |--------------------------------------------------------------------------
    | SIGN UP
    |--------------------------------------------------------------------------
    */

    public function signup(): View
    {
        return view('frontend.signup');
    }


    /*
    |--------------------------------------------------------------------------
    | TERMS & CONDITIONS
    |--------------------------------------------------------------------------
    */

    public function termsConditions(): View
    {
        return view('frontend.term-and-conditions');
    }


    /*
    |--------------------------------------------------------------------------
    | USER DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function userDashboard(): View
    {
        return view('frontend.user-dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | 404
    |--------------------------------------------------------------------------
    */

    public function notFound(): View
    {
        return view('frontend.pages.404');
    }
}