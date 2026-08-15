<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Sub Category List
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $subcategories = SubCategory::query()
            ->with('category')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20);

        return view(
            'backend.subcategories.index',
            compact('subcategories')
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
                'name'
            ]);

        return view(
            'backend.subcategories.create',
            compact('categories')
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

        $validated = $request->validate([

            'category_id' => [
                'required',

                Rule::exists(
                    'categories',
                    'id'
                )->where(
                    fn ($query) =>
                        $query
                            ->whereNull('deleted_at')
                            ->where('status', true)
                ),
            ],


            'name' => [
                'required',
                'string',
                'max:255',
            ],


            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],


            'description' => [
                'nullable',
                'string',
            ],


            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],


            'status' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $image = null;


        if ($request->hasFile('image')) {

            $image = ImageHelper::upload(
                $request->file('image'),
                'uploads/subcategories',
                600,
                600
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Create Sub Category
        |--------------------------------------------------------------------------
        */

        SubCategory::create([

            'category_id' =>
                $validated['category_id'],

            'name' =>
                $validated['name'],

            'slug' =>
                $this->uniqueSlug(
                    $validated['name']
                ),

            'image' =>
                $image,

            'description' =>
                $validated['description']
                ?? null,

            'sort_order' =>
                $validated['sort_order']
                ?? 0,

            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()
            ->route(
                'admin.subcategories.index'
            )
            ->with(
                'success',
                'Sub Category created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        SubCategory $subcategory
    ): RedirectResponse {

        return redirect()
            ->route(
                'admin.subcategories.edit',
                $subcategory
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        SubCategory $subcategory
    ): View {

        $categories = Category::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name'
            ]);


        return view(
            'backend.subcategories.edit',
            compact(
                'subcategory',
                'categories'
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
        SubCategory $subcategory
    ): RedirectResponse {

        $validated = $request->validate([

            'category_id' => [
                'required',

                Rule::exists(
                    'categories',
                    'id'
                )->where(
                    fn ($query) =>
                        $query
                            ->whereNull('deleted_at')
                            ->where('status', true)
                ),
            ],


            'name' => [
                'required',
                'string',
                'max:255',
            ],


            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],


            'description' => [
                'nullable',
                'string',
            ],


            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],


            'status' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $image = $subcategory->image;


        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $newImage = ImageHelper::upload(
                $request->file('image'),
                'uploads/subcategories',
                600,
                600
            );


            /*
            | Delete previous image only after
            | new image has been created successfully.
            */

            ImageHelper::delete(
                $subcategory->image
            );


            $image = $newImage;

        }


        /*
        |--------------------------------------------------------------------------
        | Update Sub Category
        |--------------------------------------------------------------------------
        */

        $subcategory->update([

            'category_id' =>
                $validated['category_id'],

            'name' =>
                $validated['name'],

            'slug' =>
                $this->uniqueSlug(
                    $validated['name'],
                    $subcategory->id
                ),

            'image' =>
                $image,

            'description' =>
                $validated['description']
                ?? null,

            'sort_order' =>
                $validated['sort_order']
                ?? 0,

            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()
            ->route(
                'admin.subcategories.index'
            )
            ->with(
                'success',
                'Sub Category updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Move To Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        SubCategory $subcategory
    ): RedirectResponse {

        /*
        | Do NOT delete image here.
        | Soft deleted Sub Category may be restored.
        */

        $subcategory->delete();


        return redirect()
            ->route(
                'admin.subcategories.index'
            )
            ->with(
                'success',
                'Sub Category moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trashed List
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $subcategories = SubCategory::onlyTrashed()
            ->with('category')
            ->orderByDesc('deleted_at')
            ->paginate(20);


        return view(
            'backend.subcategories.trashed',
            compact('subcategories')
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

        $subcategory = SubCategory::onlyTrashed()
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Check Parent Category
        |--------------------------------------------------------------------------
        */

        $category = Category::withTrashed()
            ->find(
                $subcategory->category_id
            );


        if (!$category) {

            return redirect()
                ->route(
                    'admin.subcategories.trashed'
                )
                ->with(
                    'error',
                    'Parent Category no longer exists.'
                );
        }


        if ($category->trashed()) {

            return redirect()
                ->route(
                    'admin.subcategories.trashed'
                )
                ->with(
                    'error',
                    'Restore the parent Category first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Restore
        |--------------------------------------------------------------------------
        */

        $subcategory->restore();


        return redirect()
            ->route(
                'admin.subcategories.trashed'
            )
            ->with(
                'success',
                'Sub Category restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Permanently Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $id
    ): RedirectResponse {

        $subcategory = SubCategory::onlyTrashed()
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete Physical Image
        |--------------------------------------------------------------------------
        */

        ImageHelper::delete(
            $subcategory->image
        );


        /*
        |--------------------------------------------------------------------------
        | Permanently Delete Record
        |--------------------------------------------------------------------------
        */

        $subcategory->forceDelete();


        return redirect()
            ->route(
                'admin.subcategories.trashed'
            )
            ->with(
                'success',
                'Sub Category permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Unique Slug
    |--------------------------------------------------------------------------
    */

    private function uniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {

        $base = Str::slug($name);


        if ($base === '') {

            $base = 'subcategory';

        }


        $slug = $base;

        $counter = 2;


        while (

            SubCategory::withTrashed()

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