<?php


use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SizeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('frontend.main');
})->name('home');


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