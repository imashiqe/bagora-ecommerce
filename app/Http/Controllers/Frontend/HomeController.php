<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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

$latestBlogs = Blog::query()
    ->with('category')
    ->where('status', true)
    ->where(function ($query) {
        $query
            ->whereNull('publish_date')
            ->orWhereDate(
                'publish_date',
                '<=',
                now()->toDateString()
            );
    })
    ->orderByDesc('publish_date')
    ->orderByDesc('publish_time')
    ->latest('id')
    ->take(4)
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
    'latestProducts',
    'latestBlogs'
));
    }



      /*
    |--------------------------------------------------------------------------
    | shop
    |--------------------------------------------------------------------------
    */

   /*
|--------------------------------------------------------------------------
| SHOP
|--------------------------------------------------------------------------
*/

public function shop(Request $request): View
{
    /*
    |--------------------------------------------------------------------------
    | Base Product Query
    |--------------------------------------------------------------------------
    */

    $productsQuery = Product::query()
        ->with([
            'category',
            'brand',
        ])
        ->where('status', true);


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if ($request->filled('q')) {

        $search = trim($request->q);

        $productsQuery->where(function ($query) use ($search) {

            $query
                ->where(
                    'title',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'sku',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'model_no',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas(
                    'category',
                    function ($categoryQuery) use ($search) {

                        $categoryQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                    }
                )

                ->orWhereHas(
                    'brand',
                    function ($brandQuery) use ($search) {

                        $brandQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                    }
                );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Category Filter
    |--------------------------------------------------------------------------
    */

    if ($request->filled('category')) {

        $categorySlug =
            $request->category;

        $productsQuery->whereHas(
            'category',
            function ($query) use ($categorySlug) {

                $query
                    ->where(
                        'slug',
                        $categorySlug
                    )
                    ->where(
                        'status',
                        true
                    );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Brand Filter
    |--------------------------------------------------------------------------
    */

    if ($request->filled('brand')) {

        $brandSlug =
            $request->brand;

        $productsQuery->whereHas(
            'brand',
            function ($query) use ($brandSlug) {

                $query
                    ->where(
                        'slug',
                        $brandSlug
                    )
                    ->where(
                        'status',
                        true
                    );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Minimum Price
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('min_price')
        &&
        is_numeric($request->min_price)
    ) {

        $minPrice =
            (float) $request->min_price;

        $productsQuery->whereRaw(
            'COALESCE(sale_price, regular_price) >= ?',
            [$minPrice]
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Maximum Price
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('max_price')
        &&
        is_numeric($request->max_price)
    ) {

        $maxPrice =
            (float) $request->max_price;

        $productsQuery->whereRaw(
            'COALESCE(sale_price, regular_price) <= ?',
            [$maxPrice]
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */

    switch ($request->get('sort')) {

        /*
        |--------------------------------------------------------------------------
        | Price: Low → High
        |--------------------------------------------------------------------------
        */

        case 'price_low':

            $productsQuery->orderByRaw(
                'COALESCE(sale_price, regular_price) ASC'
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Price: High → Low
        |--------------------------------------------------------------------------
        */

        case 'price_high':

            $productsQuery->orderByRaw(
                'COALESCE(sale_price, regular_price) DESC'
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Name A-Z
        |--------------------------------------------------------------------------
        */

        case 'name_az':

            $productsQuery->orderBy(
                'title',
                'asc'
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Name Z-A
        |--------------------------------------------------------------------------
        */

        case 'name_za':

            $productsQuery->orderBy(
                'title',
                'desc'
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Biggest Discount
        |--------------------------------------------------------------------------
        */

        case 'discount':

            $productsQuery->orderByRaw(
                '
                CASE

                    WHEN
                        sale_price IS NOT NULL
                        AND sale_price < regular_price
                        AND regular_price > 0

                    THEN
                        (
                            (regular_price - sale_price)
                            /
                            regular_price
                        )

                    ELSE 0

                END DESC
                '
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Latest
        |--------------------------------------------------------------------------
        */

        default:

            $productsQuery->latest('id');

            break;

    }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $products = $productsQuery
        ->paginate(12)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    $categories = Category::query()
        ->where('status', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Category Product Counts
    |--------------------------------------------------------------------------
    |
    | Doing this separately means Category model does NOT need
    | a products() relationship just for shop counts.
    |
    */

    $categoryProductCounts = Product::query()
        ->where('status', true)
        ->selectRaw(
            'category_id, COUNT(*) as total'
        )
        ->groupBy('category_id')
        ->pluck(
            'total',
            'category_id'
        );


    $categories->each(
        function ($category) use ($categoryProductCounts) {

            $category->active_products_count =
                (int) (
                    $categoryProductCounts[
                        $category->id
                    ]
                    ?? 0
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Brands
    |--------------------------------------------------------------------------
    */

    $brands = Brand::query()
        ->where('status', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Brand Product Counts
    |--------------------------------------------------------------------------
    */

    $brandProductCounts = Product::query()
        ->where('status', true)
        ->whereNotNull('brand_id')
        ->selectRaw(
            'brand_id, COUNT(*) as total'
        )
        ->groupBy('brand_id')
        ->pluck(
            'total',
            'brand_id'
        );


    $brands->each(
        function ($brand) use ($brandProductCounts) {

            $brand->active_products_count =
                (int) (
                    $brandProductCounts[
                        $brand->id
                    ]
                    ?? 0
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Available Maximum Price
    |--------------------------------------------------------------------------
    */

    $availableMaxPrice = Product::query()
        ->where('status', true)
        ->selectRaw(
            '
            MAX(
                COALESCE(
                    sale_price,
                    regular_price
                )
            ) as max_price
            '
        )
        ->value('max_price');


    $availableMaxPrice =
        (float) (
            $availableMaxPrice
            ?? 0
        );


    /*
    |--------------------------------------------------------------------------
    | Return View
    |--------------------------------------------------------------------------
    */

    return view(
        'frontend.pages.shop',
        compact(
            'products',
            'categories',
            'brands',
            'availableMaxPrice'
        )
    );
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

public function productDetails(string $slug): View
{
    $product = Product::query()
        ->with([
            'category',
            'subCategory',
            'childCategory',
            'brand',
            'images',
            'keyFeatures',
        ])
        ->where('status', 1)
        ->where('slug', $slug)
        ->firstOrFail();

    $relatedProducts = Product::query()
        ->with([
            'category',
            'brand',
        ])
        ->where('status', 1)
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->latest('id')
        ->take(8)
        ->get();

    return view(
        'frontend.pages.product-details',
        compact(
            'product',
            'relatedProducts'
        )
    );
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