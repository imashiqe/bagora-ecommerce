<?php

namespace App\Http\Controllers\Backend;


use App\Helpers\ImageHelper;

use App\Http\Controllers\Controller;

use App\Models\Category;

use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Illuminate\View\View;


class CategoryController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Category List
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $categories = Category::query()

            ->orderBy(
                'sort_order'
            )

            ->orderByDesc(
                'id'
            )

            ->paginate(20);


        return view(

            'backend.categories.index',

            compact(
                'categories'
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
        return view(
            'backend.categories.create'
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
        | Upload Image
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

                    'uploads/categories',

                    600,

                    600

                );
        }



        /*
        |--------------------------------------------------------------------------
        | Create Category
        |--------------------------------------------------------------------------
        */

        Category::create([

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
                $request->boolean(
                    'status'
                ),

        ]);


        return redirect()

            ->route(
                'admin.categories.index'
            )

            ->with(
                'success',
                'Category created successfully.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Category $category
    ): RedirectResponse {

        return redirect()
            ->route(
                'admin.categories.edit',
                $category
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Category $category
    ): View {

        return view(

            'backend.categories.edit',

            compact(
                'category'
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

        Category $category

    ): RedirectResponse {

        $validated =
            $request->validate([

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


        $image =
            $category->image;



        /*
        |--------------------------------------------------------------------------
        | New Image
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

                    'uploads/categories',

                    600,

                    600

                );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            ImageHelper::delete(
                $category->image
            );


            $image =
                $newImage;
        }



        /*
        |--------------------------------------------------------------------------
        | Update Category
        |--------------------------------------------------------------------------
        */

        $category->update([

            'name' =>
                $validated['name'],

            'slug' =>
                $this->uniqueSlug(

                    $validated['name'],

                    $category->id

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
                $request->boolean(
                    'status'
                ),

        ]);


        return redirect()

            ->route(
                'admin.categories.index'
            )

            ->with(
                'success',
                'Category updated successfully.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Move To Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Category $category
    ): RedirectResponse {

        /*
         * IMPORTANT:
         *
         * Don't delete the image here.
         * Category may be restored later.
         */

        $category->delete();


        return redirect()

            ->route(
                'admin.categories.index'
            )

            ->with(
                'success',
                'Category moved to trash.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Trashed
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $categories = Category::onlyTrashed()

            ->orderByDesc(
                'deleted_at'
            )

            ->paginate(20);


        return view(

            'backend.categories.trashed',

            compact(
                'categories'
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

        $category =
            Category::onlyTrashed()

                ->findOrFail(
                    $id
                );


        $category->restore();


        return redirect()

            ->route(
                'admin.categories.trashed'
            )

            ->with(
                'success',
                'Category restored successfully.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Permanent Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $id
    ): RedirectResponse {

        $category =
            Category::onlyTrashed()

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Delete Physical Public Image
        |--------------------------------------------------------------------------
        */

        ImageHelper::delete(
            $category->image
        );


        /*
        |--------------------------------------------------------------------------
        | Permanently Delete DB Record
        |--------------------------------------------------------------------------
        */

        $category->forceDelete();


        return redirect()

            ->route(
                'admin.categories.trashed'
            )

            ->with(
                'success',
                'Category permanently deleted.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Unique Slug Including Trashed Categories
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
                'category';

        }


        $slug =
            $base;


        $counter =
            2;


        while (

            Category::withTrashed()

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