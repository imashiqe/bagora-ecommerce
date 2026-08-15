<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class ChildCategoryController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $childcategories =
            ChildCategory::query()

                ->with([
                    'category',
                    'subCategory'
                ])

                ->orderBy(
                    'sort_order'
                )

                ->orderByDesc(
                    'id'
                )

                ->paginate(20);


        return view(
            'backend.childcategories.index',
            compact(
                'childcategories'
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
        $categories =
            Category::query()

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'sort_order'
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'name'
                ]);


        $subcategories =
            SubCategory::query()

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'sort_order'
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'category_id',
                    'name'
                ]);


        return view(
            'backend.childcategories.create',
            compact(
                'categories',
                'subcategories'
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
            $request->validate([

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
                |
                | Must belong to selected Category
                |
                */

                'sub_category_id' => [

                    'required',

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


                'name' => [
                    'required',
                    'string',
                    'max:255'
                ],


                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:3072'
                ],


                'description' => [
                    'nullable',
                    'string'
                ],


                'sort_order' => [
                    'nullable',
                    'integer',
                    'min:0'
                ],


                'status' => [
                    'nullable',
                    'boolean'
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        $image = null;


        if (
            $request->hasFile(
                'image'
            )
        ) {

            $image =
                ImageHelper::upload(

                    $request->file(
                        'image'
                    ),

                    'uploads/childcategories',

                    600,

                    600

                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        ChildCategory::create([

            'category_id' =>
                $validated['category_id'],


            'sub_category_id' =>
                $validated[
                    'sub_category_id'
                ],


            'name' =>
                $validated['name'],


            'slug' =>
                $this->uniqueSlug(
                    $validated['name']
                ),


            'image' =>
                $image,


            'description' =>
                $validated[
                    'description'
                ]
                ?? null,


            'sort_order' =>
                $validated[
                    'sort_order'
                ]
                ?? 0,


            'status' =>
                $request->boolean(
                    'status'
                ),

        ]);


        return redirect()

            ->route(
                'admin.childcategories.index'
            )

            ->with(
                'success',
                'Child Category created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        ChildCategory $childcategory
    ): RedirectResponse {

        return redirect()

            ->route(
                'admin.childcategories.edit',
                $childcategory
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        ChildCategory $childcategory
    ): View {

        $categories =
            Category::query()

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'sort_order'
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'name'
                ]);


        $subcategories =
            SubCategory::query()

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'sort_order'
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'category_id',
                    'name'
                ]);


        return view(
            'backend.childcategories.edit',
            compact(
                'childcategory',
                'categories',
                'subcategories'
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

        ChildCategory $childcategory

    ): RedirectResponse {

        $validated =
            $request->validate([

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


                'sub_category_id' => [

                    'required',

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


                'name' => [
                    'required',
                    'string',
                    'max:255'
                ],


                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:3072'
                ],


                'description' => [
                    'nullable',
                    'string'
                ],


                'sort_order' => [
                    'nullable',
                    'integer',
                    'min:0'
                ],


                'status' => [
                    'nullable',
                    'boolean'
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $image =
            $childcategory->image;


        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'image'
            )
        ) {

            $newImage =
                ImageHelper::upload(

                    $request->file(
                        'image'
                    ),

                    'uploads/childcategories',

                    600,

                    600

                );


            ImageHelper::delete(
                $childcategory->image
            );


            $image =
                $newImage;
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $childcategory->update([

            'category_id' =>
                $validated['category_id'],


            'sub_category_id' =>
                $validated[
                    'sub_category_id'
                ],


            'name' =>
                $validated['name'],


            'slug' =>
                $this->uniqueSlug(

                    $validated['name'],

                    $childcategory->id

                ),


            'image' =>
                $image,


            'description' =>
                $validated[
                    'description'
                ]
                ?? null,


            'sort_order' =>
                $validated[
                    'sort_order'
                ]
                ?? 0,


            'status' =>
                $request->boolean(
                    'status'
                ),

        ]);


        return redirect()

            ->route(
                'admin.childcategories.index'
            )

            ->with(
                'success',
                'Child Category updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Move To Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        ChildCategory $childcategory
    ): RedirectResponse {

        /*
         * Keep image.
         * Record may be restored.
         */

        $childcategory->delete();


        return redirect()

            ->route(
                'admin.childcategories.index'
            )

            ->with(
                'success',
                'Child Category moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trashed
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $childcategories =
            ChildCategory::onlyTrashed()

                ->with([
                    'category',
                    'subCategory'
                ])

                ->orderByDesc(
                    'deleted_at'
                )

                ->paginate(20);


        return view(
            'backend.childcategories.trashed',
            compact(
                'childcategories'
            )
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

        $childcategory =
            ChildCategory::onlyTrashed()

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Parent Category
        |--------------------------------------------------------------------------
        */

        $category =
            Category::withTrashed()

                ->find(
                    $childcategory
                        ->category_id
                );


        if (!$category) {

            return redirect()

                ->route(
                    'admin.childcategories.trashed'
                )

                ->with(
                    'error',
                    'Parent Category no longer exists.'
                );
        }


        if ($category->trashed()) {

            return redirect()

                ->route(
                    'admin.childcategories.trashed'
                )

                ->with(
                    'error',
                    'Restore the parent Category first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Parent Sub Category
        |--------------------------------------------------------------------------
        */

        $subcategory =
            SubCategory::withTrashed()

                ->find(
                    $childcategory
                        ->sub_category_id
                );


        if (!$subcategory) {

            return redirect()

                ->route(
                    'admin.childcategories.trashed'
                )

                ->with(
                    'error',
                    'Parent Sub Category no longer exists.'
                );
        }


        if ($subcategory->trashed()) {

            return redirect()

                ->route(
                    'admin.childcategories.trashed'
                )

                ->with(
                    'error',
                    'Restore the parent Sub Category first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check hierarchy
        |--------------------------------------------------------------------------
        */

        if (
            $subcategory->category_id
            !=
            $category->id
        ) {

            return redirect()

                ->route(
                    'admin.childcategories.trashed'
                )

                ->with(
                    'error',
                    'Category hierarchy does not match.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Restore
        |--------------------------------------------------------------------------
        */

        $childcategory->restore();


        return redirect()

            ->route(
                'admin.childcategories.trashed'
            )

            ->with(
                'success',
                'Child Category restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Force Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $id
    ): RedirectResponse {

        $childcategory =
            ChildCategory::onlyTrashed()

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        ImageHelper::delete(
            $childcategory->image
        );


        /*
        |--------------------------------------------------------------------------
        | Permanent Delete
        |--------------------------------------------------------------------------
        */

        $childcategory->forceDelete();


        return redirect()

            ->route(
                'admin.childcategories.trashed'
            )

            ->with(
                'success',
                'Child Category permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Unique Slug
    |--------------------------------------------------------------------------
    */

    private function uniqueSlug(

        string $name,

        ?int $ignoreId = null

    ): string {

        $base =
            Str::slug(
                $name
            );


        if ($base === '') {

            $base =
                'child-category';

        }


        $slug =
            $base;


        $counter =
            2;


        while (

            ChildCategory::withTrashed()

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