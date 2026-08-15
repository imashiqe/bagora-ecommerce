<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SizeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $sizes = Size::query()

            ->orderBy('sort_order')

            ->orderBy('name')

            ->paginate(20);


        return view(
            'backend.sizes.index',
            compact('sizes')
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
            'backend.sizes.create'
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

            'name' => [
                'required',
                'string',
                'max:100',
            ],


            'code' => [
                'nullable',
                'string',
                'max:50',
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


        Size::create([

            'name' =>
                $validated['name'],


            'code' =>
                !empty($validated['code'])
                    ? trim($validated['code'])
                    : null,


            'slug' =>
                $this->uniqueSlug(
                    $validated['name']
                ),


            'sort_order' =>
                $validated['sort_order']
                ?? 0,


            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()

            ->route(
                'admin.sizes.index'
            )

            ->with(
                'success',
                'Size created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Size $size
    ): RedirectResponse {

        return redirect()

            ->route(
                'admin.sizes.edit',
                $size
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Size $size
    ): View {

        return view(
            'backend.sizes.edit',
            compact('size')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(

        Request $request,

        Size $size

    ): RedirectResponse {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:100',
            ],


            'code' => [
                'nullable',
                'string',
                'max:50',
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


        $size->update([

            'name' =>
                $validated['name'],


            'code' =>
                !empty($validated['code'])
                    ? trim($validated['code'])
                    : null,


            'slug' =>
                $this->uniqueSlug(
                    $validated['name'],
                    $size->id
                ),


            'sort_order' =>
                $validated['sort_order']
                ?? 0,


            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()

            ->route(
                'admin.sizes.index'
            )

            ->with(
                'success',
                'Size updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Move To Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Size $size
    ): RedirectResponse {

        $size->delete();


        return redirect()

            ->route(
                'admin.sizes.index'
            )

            ->with(
                'success',
                'Size moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $sizes = Size::onlyTrashed()

            ->orderByDesc('deleted_at')

            ->paginate(20);


        return view(
            'backend.sizes.trashed',
            compact('sizes')
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

        $size = Size::onlyTrashed()
            ->findOrFail($id);


        $size->restore();


        return redirect()

            ->route(
                'admin.sizes.trashed'
            )

            ->with(
                'success',
                'Size restored successfully.'
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

        $size = Size::onlyTrashed()
            ->findOrFail($id);


        $size->forceDelete();


        return redirect()

            ->route(
                'admin.sizes.trashed'
            )

            ->with(
                'success',
                'Size permanently deleted.'
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

        $base = Str::slug($name);


        if ($base === '') {

            $base = 'size';

        }


        $slug = $base;

        $counter = 2;


        while (

            Size::withTrashed()

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