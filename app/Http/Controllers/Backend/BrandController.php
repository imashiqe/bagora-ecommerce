<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;



class BrandController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $brands = Brand::query()

            ->orderBy(
                'sort_order'
            )

            ->orderBy(
                'name'
            )

            ->paginate(20);


        return view(
            'backend.brands.index',
            compact('brands')
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
            'backend.brands.create'
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
                    'max:255',
                ],


                'logo' => [
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
        | Upload Logo
        |--------------------------------------------------------------------------
        */

        $logo = null;


        if (
            $request->hasFile('logo')
        ) {

            $logo =
                ImageHelper::uploadLogo(

                    $request->file(
                        'logo'
                    ),

                    'uploads/brands',

                    600,

                    400

                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Brand
        |--------------------------------------------------------------------------
        */

        Brand::create([

            'name' =>
                $validated['name'],


            'slug' =>
                $this->uniqueSlug(
                    $validated['name']
                ),


            'logo' =>
                $logo,


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
                'admin.brands.index'
            )

            ->with(
                'success',
                'Brand created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Brand $brand
    ): RedirectResponse {

        return redirect()

            ->route(
                'admin.brands.edit',
                $brand
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Brand $brand
    ): View {

        return view(
            'backend.brands.edit',
            compact('brand')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(

        Request $request,

        Brand $brand

    ): RedirectResponse {

        $validated =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],


                'logo' => [
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
        | Existing Logo
        |--------------------------------------------------------------------------
        */

        $logo =
            $brand->logo;


        /*
        |--------------------------------------------------------------------------
        | Replace Logo
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('logo')
        ) {

            $newLogo =
                ImageHelper::uploadLogo(

                    $request->file(
                        'logo'
                    ),

                    'uploads/brands',

                    600,

                    400

                );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Logo
            |--------------------------------------------------------------------------
            */

            ImageHelper::delete(
                $brand->logo
            );


            $logo =
                $newLogo;
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $brand->update([

            'name' =>
                $validated['name'],


            'slug' =>
                $this->uniqueSlug(

                    $validated['name'],

                    $brand->id

                ),


            'logo' =>
                $logo,


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
                'admin.brands.index'
            )

            ->with(
                'success',
                'Brand updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Brand $brand
    ): RedirectResponse {

        /*
         * Do not delete physical logo.
         * Brand can be restored.
         */

        $brand->delete();


        return redirect()

            ->route(
                'admin.brands.index'
            )

            ->with(
                'success',
                'Brand moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trashed
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $brands =
            Brand::onlyTrashed()

                ->orderByDesc(
                    'deleted_at'
                )

                ->paginate(20);


        return view(
            'backend.brands.trashed',
            compact('brands')
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

        $brand =
            Brand::onlyTrashed()

                ->findOrFail(
                    $id
                );


        $brand->restore();


        return redirect()

            ->route(
                'admin.brands.trashed'
            )

            ->with(
                'success',
                'Brand restored successfully.'
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

        $brand =
            Brand::onlyTrashed()

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Delete Logo
        |--------------------------------------------------------------------------
        */

        ImageHelper::delete(
            $brand->logo
        );


        /*
        |--------------------------------------------------------------------------
        | Delete DB Row
        |--------------------------------------------------------------------------
        */

        $brand->forceDelete();


        return redirect()

            ->route(
                'admin.brands.trashed'
            )

            ->with(
                'success',
                'Brand permanently deleted.'
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
                'brand';
        }


        $slug =
            $base;


        $counter =
            2;


        while (

            Brand::withTrashed()

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