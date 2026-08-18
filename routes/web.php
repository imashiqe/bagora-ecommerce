<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::get(
    '/cart',
    [CartController::class, 'index']
)->name('cart');

Route::post(
    '/cart/add/{product}',
    [CartController::class, 'add']
)->name('cart.add');

Route::patch(
    '/cart/{product}',
    [CartController::class, 'update']
)->name('cart.update');

Route::delete(
    '/cart/{product}',
    [CartController::class, 'remove']
)->name('cart.remove');

Route::delete(
    '/cart',
    [CartController::class, 'clear']
)->name('cart.clear');
/*
|--------------------------------------------------------------------------
| Shop
|--------------------------------------------------------------------------
*/
Route::get(
    '/shop',
    [HomeController::class, 'shop']
)->name('shop');

/*
|--------------------------------------------------------------------------
| About
|--------------------------------------------------------------------------
*/

Route::get(
    '/about-us',
    [HomeController::class, 'about']
)->name('about');


/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/

Route::get(
    '/blog',
    [HomeController::class, 'blog']
)->name('blog');


Route::get(
    '/blog-details',
    [HomeController::class, 'blogDetails']
)->name('blog.details');


/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::get(
    '/cart',
    [HomeController::class, 'cart']
)->name('cart');


/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::get(
    '/checkout',
    [HomeController::class, 'checkout']
)->name('checkout');


/*
|--------------------------------------------------------------------------
| Coming Soon
|--------------------------------------------------------------------------
*/

Route::get(
    '/coming-soon',
    [HomeController::class, 'comingSoon']
)->name('coming-soon');


/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

Route::get(
    '/contact-us',
    [HomeController::class, 'contact']
)->name('contact');


/*
|--------------------------------------------------------------------------
| FAQ
|--------------------------------------------------------------------------
*/

Route::get(
    '/faq',
    [HomeController::class, 'faq']
)->name('faq');


/*
|--------------------------------------------------------------------------
| Forgot Password Template
|--------------------------------------------------------------------------
*/

Route::get(
    '/forgot-password-page',
    [HomeController::class, 'forgotPassword']
)->name('frontend.forgot-password');


/*
|--------------------------------------------------------------------------
| Order Success
|--------------------------------------------------------------------------
*/

Route::get(
    '/order-success',
    [HomeController::class, 'orderSuccess']
)->name('order.success');


/*
|--------------------------------------------------------------------------
| OTP Verification
|--------------------------------------------------------------------------
*/

Route::get(
    '/otp-verification',
    [HomeController::class, 'otpVerification']
)->name('otp.verification');


/*
|--------------------------------------------------------------------------
| Password Lost
|--------------------------------------------------------------------------
*/

Route::get(
    '/password-lost',
    [HomeController::class, 'passwordLost']
)->name('password.lost');


/*
|--------------------------------------------------------------------------
| Password Reset Success
|--------------------------------------------------------------------------
*/

Route::get(
    '/password-reset-success',
    [HomeController::class, 'passwordResetSuccess']
)->name('password.reset.success');


/*
|--------------------------------------------------------------------------
| Privacy Policy
|--------------------------------------------------------------------------
*/

Route::get(
    '/privacy-policy',
    [HomeController::class, 'privacyPolicy']
)->name('privacy-policy');


/*
|--------------------------------------------------------------------------
| Product Details
|--------------------------------------------------------------------------
*/


Route::get(
    '/product/{slug}',
    [HomeController::class, 'productDetails']
)->name('product.details');
/*
|--------------------------------------------------------------------------
| Return Policy
|--------------------------------------------------------------------------
*/

Route::get(
    '/return-policy',
    [HomeController::class, 'returnPolicy']
)->name('return-policy');


/*
|--------------------------------------------------------------------------
| Signup Template
|--------------------------------------------------------------------------
*/

Route::get(
    '/signup',
    [HomeController::class, 'signup']
)->name('frontend.signup');


/*
|--------------------------------------------------------------------------
| Terms & Conditions
|--------------------------------------------------------------------------
*/

Route::get(
    '/terms-and-conditions',
    [HomeController::class, 'termsConditions']
)->name('terms-conditions');


/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/user-dashboard',
    [HomeController::class, 'userDashboard']
)
->middleware('auth')
->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| 404 - MUST BE LAST
|--------------------------------------------------------------------------
*/

Route::fallback(
    [HomeController::class, 'notFound']
);

/*
|--------------------------------------------------------------------------
| Breeze Dashboard Redirect
|--------------------------------------------------------------------------
|
| Breeze may send logged-in users to /dashboard.
| Redirect that URL to Bagora admin dashboard.
|
*/

Route::get('/dashboard', function () {

    return redirect()
        ->route('admin.dashboard');

})->middleware(['auth', 'verified'])
  ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Bagora Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {

            return view('backend.dashboard');

        })->name('dashboard');
// blogs
  /*
        |--------------------------------------------------------------------------
        | Blog Content Image Upload
        |--------------------------------------------------------------------------
        | IMPORTANT: resource route-এর আগে
        */

        Route::post(
            'blogs/content-image/upload',
            [BlogController::class, 'uploadContentImage']
        )->name('blogs.content-image.upload');

Route::get(
    'blogs/trashed',
    [BlogController::class, 'trashed']
)->name('blogs.trashed');


Route::patch(
    'blogs/{id}/restore',
    [BlogController::class, 'restore']
)->name('blogs.restore');


Route::delete(
    'blogs/{id}/force-delete',
    [BlogController::class, 'forceDelete']
)->name('blogs.force-delete');


Route::resource(
    'blogs',
    BlogController::class
)->except('show');
// blog category
Route::get(
    'blog-categories/trashed',
    [BlogCategoryController::class, 'trashed']
)->name('blog-categories.trashed');


Route::patch(
    'blog-categories/{id}/restore',
    [BlogCategoryController::class, 'restore']
)->name('blog-categories.restore');


Route::delete(
    'blog-categories/{id}/force-delete',
    [BlogCategoryController::class, 'forceDelete']
)->name('blog-categories.force-delete');


Route::resource(
    'blog-categories',
    BlogCategoryController::class
)->except('show');
        /*
|--------------------------------------------------------------------------
| Category Trash Routes
|--------------------------------------------------------------------------
|
| Keep these BEFORE Route::resource()
|
*/

Route::get(
    'categories/trashed',
    [
        CategoryController::class,
        'trashed'
    ]
)->name(
    'categories.trashed'
);


Route::patch(
    'categories/{id}/restore',
    [
        CategoryController::class,
        'restore'
    ]
)->name(
    'categories.restore'
);


Route::delete(
    'categories/{id}/force-delete',
    [
        CategoryController::class,
        'forceDelete'
    ]
)->name(
    'categories.force-delete'
);



/*
|--------------------------------------------------------------------------
| Category Resource CRUD
|--------------------------------------------------------------------------
*/

Route::resource(
    'categories',
    CategoryController::class
);

/*
|--------------------------------------------------------------------------
| Sub Category Trash Routes
|--------------------------------------------------------------------------
*/

Route::get(
    'subcategories/trashed',
    [
        SubCategoryController::class,
        'trashed'
    ]
)->name(
    'subcategories.trashed'
);


Route::patch(
    'subcategories/{id}/restore',
    [
        SubCategoryController::class,
        'restore'
    ]
)->name(
    'subcategories.restore'
);


Route::delete(
    'subcategories/{id}/force-delete',
    [
        SubCategoryController::class,
        'forceDelete'
    ]
)->name(
    'subcategories.force-delete'
);


/*
|--------------------------------------------------------------------------
| Resource CRUD
|--------------------------------------------------------------------------
*/

Route::resource(
    'subcategories',
    SubCategoryController::class
);


/*
|--------------------------------------------------------------------------
| Child Category Trash
|--------------------------------------------------------------------------
*/

Route::get(
    'childcategories/trashed',
    [
        ChildCategoryController::class,
        'trashed'
    ]
)->name(
    'childcategories.trashed'
);


Route::patch(
    'childcategories/{id}/restore',
    [
        ChildCategoryController::class,
        'restore'
    ]
)->name(
    'childcategories.restore'
);


Route::delete(
    'childcategories/{id}/force-delete',
    [
        ChildCategoryController::class,
        'forceDelete'
    ]
)->name(
    'childcategories.force-delete'
);


/*
|--------------------------------------------------------------------------
| Child Category Resource
|--------------------------------------------------------------------------
*/

Route::resource(
    'childcategories',
    ChildCategoryController::class
);

/*
|--------------------------------------------------------------------------
| Brand Trash
|--------------------------------------------------------------------------
*/

Route::get(
    'brands/trashed',
    [
        BrandController::class,
        'trashed'
    ]
)->name(
    'brands.trashed'
);


Route::patch(
    'brands/{id}/restore',
    [
        BrandController::class,
        'restore'
    ]
)->name(
    'brands.restore'
);


Route::delete(
    'brands/{id}/force-delete',
    [
        BrandController::class,
        'forceDelete'
    ]
)->name(
    'brands.force-delete'
);


/*
|--------------------------------------------------------------------------
| Brand Resource
|--------------------------------------------------------------------------
*/

Route::resource(
    'brands',
    BrandController::class
);


/*
|--------------------------------------------------------------------------
| Color Trash Routes
|--------------------------------------------------------------------------
*/

Route::get(
    'colors/trashed',
    [
        ColorController::class,
        'trashed'
    ]
)->name(
    'colors.trashed'
);


Route::patch(
    'colors/{id}/restore',
    [
        ColorController::class,
        'restore'
    ]
)->name(
    'colors.restore'
);


Route::delete(
    'colors/{id}/force-delete',
    [
        ColorController::class,
        'forceDelete'
    ]
)->name(
    'colors.force-delete'
);


/*
|--------------------------------------------------------------------------
| Color Resource
|--------------------------------------------------------------------------
*/

Route::resource(
    'colors',
    ColorController::class
);

/*
|--------------------------------------------------------------------------
| Size Trash
|--------------------------------------------------------------------------
*/

Route::get(
    'sizes/trashed',
    [
        SizeController::class,
        'trashed'
    ]
)->name(
    'sizes.trashed'
);


Route::patch(
    'sizes/{id}/restore',
    [
        SizeController::class,
        'restore'
    ]
)->name(
    'sizes.restore'
);


Route::delete(
    'sizes/{id}/force-delete',
    [
        SizeController::class,
        'forceDelete'
    ]
)->name(
    'sizes.force-delete'
);


/*
|--------------------------------------------------------------------------
| Size Resource
|--------------------------------------------------------------------------
*/

Route::resource(
    'sizes',
    SizeController::class
);

/*
|--------------------------------------------------------------------------
| Product Trash
|--------------------------------------------------------------------------
*/

Route::get(
    'products/trashed',
    [
        ProductController::class,
        'trashed'
    ]
)->name(
    'products.trashed'
);


Route::patch(
    'products/{id}/restore',
    [
        ProductController::class,
        'restore'
    ]
)->name(
    'products.restore'
);


Route::delete(
    'products/{id}/force-delete',
    [
        ProductController::class,
        'forceDelete'
    ]
)->name(
    'products.force-delete'
);


/*
|--------------------------------------------------------------------------
| Gallery Image Delete
|--------------------------------------------------------------------------
*/

Route::delete(
    'products/{product}/gallery/{image}',
    [
        ProductController::class,
        'deleteGalleryImage'
    ]
)->name(
    'products.gallery.destroy'
);


/*
|--------------------------------------------------------------------------
| Product Resource
|--------------------------------------------------------------------------
*/

Route::resource(
    'products',
    ProductController::class
);


/*
|--------------------------------------------------------------------------
| Coupon Trash
|--------------------------------------------------------------------------
*/

Route::get(
    'coupons/trashed',
    [
        CouponController::class,
        'trashed'
    ]
)->name(
    'coupons.trashed'
);


Route::patch(
    'coupons/{id}/restore',
    [
        CouponController::class,
        'restore'
    ]
)->name(
    'coupons.restore'
);


Route::delete(
    'coupons/{id}/force-delete',
    [
        CouponController::class,
        'forceDelete'
    ]
)->name(
    'coupons.force-delete'
);


/*
|--------------------------------------------------------------------------
| Coupon Resource
|--------------------------------------------------------------------------
*/

Route::resource(
    'coupons',
    CouponController::class
);


//  banner

Route::get(
    'banners/trashed',
    [BannerController::class, 'trashed']
)->name('banners.trashed');


Route::patch(
    'banners/{id}/restore',
    [BannerController::class, 'restore']
)->name('banners.restore');


Route::delete(
    'banners/{id}/force-delete',
    [BannerController::class, 'forceDelete']
)->name('banners.force-delete');


Route::resource(
    'banners',
    BannerController::class
);
        /*
        |--------------------------------------------------------------------------
        | Catalog
        |--------------------------------------------------------------------------
        |
        | We will add these controllers next.
        |
        */

        // Categories
        // Route::resource('categories', CategoryController::class);

        // Sub Categories
        // Route::resource('subcategories', SubCategoryController::class);

        // Child Categories
        // Route::resource('childcategories', ChildCategoryController::class);

        // Brands
        // Route::resource('brands', BrandController::class);

        // Colors
        // Route::resource('colors', ColorController::class);

        // Sizes
        // Route::resource('sizes', SizeController::class);

        // Products
        // Route::resource('products', ProductController::class);

        // Variants
        // Route::resource('variants', ProductVariantController::class);

    });


/*
|--------------------------------------------------------------------------
| User Profile - Laravel Breeze
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Breeze Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';