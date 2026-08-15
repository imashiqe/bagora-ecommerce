<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductKeyFeature;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

  public function index(
    Request $request
): View {

    /*
    |--------------------------------------------------------------------------
    | Search Keyword
    |--------------------------------------------------------------------------
    */

    $search = trim(
        (string) $request->query(
            'search',
            ''
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Products Query
    |--------------------------------------------------------------------------
    */

    $products = Product::query()

        ->with([
            'category',
            'subCategory',
            'childCategory',
            'brand',
        ])


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        ->when(
            $search !== '',
            function ($query) use ($search) {

                $query->where(
                    function ($q) use ($search) {

                        /*
                        |--------------------------------------------------------------------------
                        | Product Fields
                        |--------------------------------------------------------------------------
                        */

                        $q->where(
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


                        /*
                        |--------------------------------------------------------------------------
                        | Category
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'category',
                            function ($category) use ($search) {

                                $category->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );

                            }
                        )


                        /*
                        |--------------------------------------------------------------------------
                        | Sub Category
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'subCategory',
                            function ($subcategory) use ($search) {

                                $subcategory->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );

                            }
                        )


                        /*
                        |--------------------------------------------------------------------------
                        | Child Category
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'childCategory',
                            function ($childCategory) use ($search) {

                                $childCategory->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );

                            }
                        )


                        /*
                        |--------------------------------------------------------------------------
                        | Brand
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'brand',
                            function ($brand) use ($search) {

                                $brand->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );

                            }
                        );

                    }
                );

            }
        )


        /*
        |--------------------------------------------------------------------------
        | Latest First
        |--------------------------------------------------------------------------
        */

        ->latest('id')


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        ->paginate(20)

        ->withQueryString();


    return view(
        'backend.products.index',
        compact(
            'products',
            'search'
        )
    );
}

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $categories = Category::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);


        $subcategories = SubCategory::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'category_id',
                'name',
            ]);


        $childcategories = ChildCategory::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'category_id',
                'sub_category_id',
                'name',
            ]);


        $brands = Brand::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);


        return view(
            'backend.products.create',
            compact(
                'categories',
                'subcategories',
                'childcategories',
                'brands'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $validated =
            $this->validateProduct(
                $request
            );


        DB::beginTransaction();


        $thumbnail = null;


        try {

            /*
            |--------------------------------------------------------------------------
            | Thumbnail
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile(
                    'thumbnail'
                )
            ) {

                $thumbnail =
                    ImageHelper::upload(

                        $request->file(
                            'thumbnail'
                        ),

                        'uploads/products/thumbnail',

                        1000,

                        1000,

                        85

                    );

            }


            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            $product = Product::create([

                'category_id' =>
                    $validated['category_id'],


                'sub_category_id' =>
                    $validated['sub_category_id']
                    ?? null,


                'child_category_id' =>
                    $validated['child_category_id']
                    ?? null,


                'brand_id' =>
                    $validated['brand_id']
                    ?? null,


                'title' =>
                    $validated['title'],


                'slug' =>
                    $this->uniqueSlug(
                        $validated['title']
                    ),


                'sku' =>
                    strtoupper(
                        trim(
                            $validated['sku']
                        )
                    ),


                'model_no' =>
                    !empty(
                        $validated['model_no']
                    )
                    ? trim(
                        $validated['model_no']
                    )
                    : null,


                'short_description' =>
                    $validated['short_description']
                    ?? null,


                'description' =>
                    $validated['description']
                    ?? null,


                'cost_price' =>
                    $validated['cost_price']
                    ?? 0,


                'regular_price' =>
                    $validated['regular_price'],


                'sale_price' =>
                    $validated['sale_price']
                    ?? null,


                'thumbnail' =>
                    $thumbnail,


                'keywords' =>
                    $validated['keywords']
                    ?? null,


                'meta_title' =>
                    $validated['meta_title']
                    ?? null,


                'meta_description' =>
                    $validated['meta_description']
                    ?? null,


                'featured' =>
                    $request->boolean(
                        'featured'
                    ),


                'best_seller' =>
                    $request->boolean(
                        'best_seller'
                    ),


                'new_arrival' =>
                    $request->boolean(
                        'new_arrival'
                    ),


                'status' =>
                    $request->boolean(
                        'status'
                    ),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Key Features
            |--------------------------------------------------------------------------
            */

            $this->saveKeyFeatures(
                $request,
                $product
            );


            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            $this->uploadGallery(
                $request,
                $product
            );


            DB::commit();


            return redirect()

                ->route(
                    'admin.products.index'
                )

                ->with(
                    'success',
                    'Product created successfully.'
                );


        } catch (\Throwable $e) {

            DB::rollBack();


            if ($thumbnail) {

                ImageHelper::delete(
                    $thumbnail
                );

            }


            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Product $product
    ): RedirectResponse {

        return redirect()

            ->route(
                'admin.products.edit',
                $product
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Product $product
    ): View {

        $product->load([
            'images',
            'keyFeatures',
        ]);


        $categories = Category::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);


        $subcategories = SubCategory::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'category_id',
                'name',
            ]);


        $childcategories = ChildCategory::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'category_id',
                'sub_category_id',
                'name',
            ]);


        $brands = Brand::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);


        return view(
            'backend.products.edit',
            compact(
                'product',
                'categories',
                'subcategories',
                'childcategories',
                'brands'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {

        $validated =
            $this->validateProduct(
                $request,
                $product
            );


        DB::beginTransaction();


        $oldThumbnail =
            $product->thumbnail;


        $newThumbnail =
            null;


        try {

            /*
            |--------------------------------------------------------------------------
            | New Thumbnail
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile(
                    'thumbnail'
                )
            ) {

                $newThumbnail =
                    ImageHelper::upload(

                        $request->file(
                            'thumbnail'
                        ),

                        'uploads/products/thumbnail',

                        1000,

                        1000,

                        85

                    );

            }


            /*
            |--------------------------------------------------------------------------
            | Update Product
            |--------------------------------------------------------------------------
            */

            $product->update([

                'category_id' =>
                    $validated['category_id'],


                'sub_category_id' =>
                    $validated['sub_category_id']
                    ?? null,


                'child_category_id' =>
                    $validated['child_category_id']
                    ?? null,


                'brand_id' =>
                    $validated['brand_id']
                    ?? null,


                'title' =>
                    $validated['title'],


                'slug' =>
                    $this->uniqueSlug(
                        $validated['title'],
                        $product->id
                    ),


                'sku' =>
                    strtoupper(
                        trim(
                            $validated['sku']
                        )
                    ),


                'model_no' =>
                    !empty(
                        $validated['model_no']
                    )
                    ? trim(
                        $validated['model_no']
                    )
                    : null,


                'short_description' =>
                    $validated['short_description']
                    ?? null,


                'description' =>
                    $validated['description']
                    ?? null,


                'cost_price' =>
                    $validated['cost_price']
                    ?? 0,


                'regular_price' =>
                    $validated['regular_price'],


                'sale_price' =>
                    $validated['sale_price']
                    ?? null,


                'thumbnail' =>
                    $newThumbnail
                    ?: $oldThumbnail,


                'keywords' =>
                    $validated['keywords']
                    ?? null,


                'meta_title' =>
                    $validated['meta_title']
                    ?? null,


                'meta_description' =>
                    $validated['meta_description']
                    ?? null,


                'featured' =>
                    $request->boolean(
                        'featured'
                    ),


                'best_seller' =>
                    $request->boolean(
                        'best_seller'
                    ),


                'new_arrival' =>
                    $request->boolean(
                        'new_arrival'
                    ),


                'status' =>
                    $request->boolean(
                        'status'
                    ),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Key Features
            |--------------------------------------------------------------------------
            */

            $this->saveKeyFeatures(
                $request,
                $product
            );


            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            $this->uploadGallery(
                $request,
                $product
            );


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Delete Old Thumbnail
            |--------------------------------------------------------------------------
            */

            if ($newThumbnail) {

                ImageHelper::delete(
                    $oldThumbnail
                );

            }


            return redirect()

                ->route(
                    'admin.products.index'
                )

                ->with(
                    'success',
                    'Product updated successfully.'
                );


        } catch (\Throwable $e) {

            DB::rollBack();


            if ($newThumbnail) {

                ImageHelper::delete(
                    $newThumbnail
                );

            }


            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Product $product
    ): RedirectResponse {

        $product->delete();


        return redirect()

            ->route(
                'admin.products.index'
            )

            ->with(
                'success',
                'Product moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $products =
            Product::onlyTrashed()

                ->with([
                    'category',
                    'brand',
                ])

                ->orderByDesc(
                    'deleted_at'
                )

                ->paginate(20);


        return view(
            'backend.products.trashed',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Restore
    |--------------------------------------------------------------------------
    */

    public function restore(
        int $id
    ): RedirectResponse {

        $product =
            Product::onlyTrashed()
                ->findOrFail($id);


        $category =
            Category::withTrashed()
                ->find(
                    $product->category_id
                );


        if (
            !$category
            ||
            $category->trashed()
        ) {

            return redirect()

                ->route(
                    'admin.products.trashed'
                )

                ->with(
                    'error',
                    'Restore the parent Category first.'
                );
        }


        $product->restore();


        return redirect()

            ->route(
                'admin.products.trashed'
            )

            ->with(
                'success',
                'Product restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Forever
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $id
    ): RedirectResponse {

        $product =
            Product::onlyTrashed()

                ->with([
                    'images',
                    'keyFeatures',
                ])

                ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Thumbnail
        |--------------------------------------------------------------------------
        */

        ImageHelper::delete(
            $product->thumbnail
        );


        /*
        |--------------------------------------------------------------------------
        | Gallery Files
        |--------------------------------------------------------------------------
        */

        foreach (
            $product->images
            as $image
        ) {

            ImageHelper::delete(
                $image->image
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Product Delete
        |--------------------------------------------------------------------------
        */

        $product->forceDelete();


        return redirect()

            ->route(
                'admin.products.trashed'
            )

            ->with(
                'success',
                'Product permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Gallery Image
    |--------------------------------------------------------------------------
    */

    public function deleteGalleryImage(
        Product $product,
        ProductImage $image
    ): RedirectResponse {

        if (
            $image->product_id
            !==
            $product->id
        ) {

            abort(404);

        }


        ImageHelper::delete(
            $image->image
        );


        $image->delete();


        return back()

            ->with(
                'success',
                'Gallery image deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Product Validation
    |--------------------------------------------------------------------------
    */

    private function validateProduct(
        Request $request,
        ?Product $product = null
    ): array {

        return $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            'category_id' => [

                'required',

                Rule::exists(
                    'categories',
                    'id'
                )->where(
                    fn ($query) =>
                        $query
                            ->whereNull(
                                'deleted_at'
                            )
                            ->where(
                                'status',
                                true
                            )
                ),

            ],


            /*
            |--------------------------------------------------------------------------
            | Sub Category
            |--------------------------------------------------------------------------
            */

            'sub_category_id' => [

                'nullable',

                'required_with:child_category_id',

                Rule::exists(
                    'sub_categories',
                    'id'
                )->where(
                    function ($query) use ($request) {

                        $query
                            ->where(
                                'category_id',
                                $request->category_id
                            )
                            ->whereNull(
                                'deleted_at'
                            )
                            ->where(
                                'status',
                                true
                            );

                    }
                ),

            ],


            /*
            |--------------------------------------------------------------------------
            | Child Category
            |--------------------------------------------------------------------------
            */

            'child_category_id' => [

                'nullable',

                Rule::exists(
                    'child_categories',
                    'id'
                )->where(
                    function ($query) use ($request) {

                        $query
                            ->where(
                                'category_id',
                                $request->category_id
                            )
                            ->where(
                                'sub_category_id',
                                $request->sub_category_id
                            )
                            ->whereNull(
                                'deleted_at'
                            )
                            ->where(
                                'status',
                                true
                            );

                    }
                ),

            ],


            /*
            |--------------------------------------------------------------------------
            | Brand
            |--------------------------------------------------------------------------
            */

            'brand_id' => [

                'nullable',

                Rule::exists(
                    'brands',
                    'id'
                )->where(
                    fn ($query) =>
                        $query
                            ->whereNull(
                                'deleted_at'
                            )
                            ->where(
                                'status',
                                true
                            )
                ),

            ],


            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            'title' => [
                'required',
                'string',
                'max:255',
            ],


            'sku' => [

                'required',

                'string',

                'max:100',

                Rule::unique(
                    'products',
                    'sku'
                )->ignore(
                    $product?->id
                ),

            ],


            'model_no' => [
                'nullable',
                'string',
                'max:100',
            ],


            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            'short_description' => [
                'nullable',
                'string',
            ],


            'description' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Prices
            |--------------------------------------------------------------------------
            */

            'cost_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'regular_price' => [
                'required',
                'numeric',
                'min:0',
            ],


            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:regular_price',
            ],


            /*
            |--------------------------------------------------------------------------
            | Thumbnail
            |--------------------------------------------------------------------------
            */

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],


            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            'gallery' => [
                'nullable',
                'array',
                'max:10',
            ],


            'gallery.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],


            /*
            |--------------------------------------------------------------------------
            | Key Features
            |--------------------------------------------------------------------------
            */

            'key_features' => [
                'nullable',
                'array',
                'max:20',
            ],


            'key_features.*' => [
                'nullable',
                'string',
                'max:500',
            ],


            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'keywords' => [
                'nullable',
                'string',
            ],


            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],


            'meta_description' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Flags
            |--------------------------------------------------------------------------
            */

            'featured' => [
                'nullable',
                'boolean',
            ],


            'best_seller' => [
                'nullable',
                'boolean',
            ],


            'new_arrival' => [
                'nullable',
                'boolean',
            ],


            'status' => [
                'nullable',
                'boolean',
            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Save Key Features
    |--------------------------------------------------------------------------
    */

    private function saveKeyFeatures(
        Request $request,
        Product $product
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Remove Old Features
        |--------------------------------------------------------------------------
        */

        $product
            ->keyFeatures()
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | New Features
        |--------------------------------------------------------------------------
        */

        $features =
            $request->input(
                'key_features',
                []
            );


        $sortOrder = 0;


        foreach (
            $features
            as $feature
        ) {

            $feature =
                trim(
                    (string) $feature
                );


            if ($feature === '') {

                continue;

            }


            $sortOrder++;


            ProductKeyFeature::create([

                'product_id' =>
                    $product->id,

                'feature' =>
                    $feature,

                'sort_order' =>
                    $sortOrder,

            ]);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Gallery
    |--------------------------------------------------------------------------
    */

    private function uploadGallery(
        Request $request,
        Product $product
    ): void {

        if (
            !$request->hasFile(
                'gallery'
            )
        ) {

            return;

        }


        $currentSort =
            (int) $product
                ->images()
                ->max(
                    'sort_order'
                );


        foreach (
            $request->file(
                'gallery'
            )
            as $file
        ) {

            $currentSort++;


            $path =
                ImageHelper::uploadGallery(

                    $file,

                    'uploads/products/gallery',

                    1200,

                    1200,

                    85

                );


            ProductImage::create([

                'product_id' =>
                    $product->id,

                'image' =>
                    $path,

                'alt_text' =>
                    $product->title,

                'sort_order' =>
                    $currentSort,

            ]);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Unique Slug
    |--------------------------------------------------------------------------
    */

    private function uniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {

        $base =
            Str::slug(
                $title
            );


        if ($base === '') {

            $base =
                'product';

        }


        $slug =
            $base;


        $counter =
            2;


        while (

            Product::withTrashed()

                ->when(

                    $ignoreId,

                    fn ($query) =>
                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        )

                )

                ->where(
                    'slug',
                    $slug
                )

                ->exists()

        ) {

            $slug =
                $base
                . '-'
                . $counter;


            $counter++;

        }


        return $slug;
    }
}