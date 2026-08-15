<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;


class ColorController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $colors = Color::query()

            ->orderBy('sort_order')

            ->orderBy('name')

            ->paginate(20);


        return view(
            'backend.colors.index',
            compact('colors')
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
            'backend.colors.create'
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


            'hex_code' => [
                'required',
                'string',
                'regex:/^#?[0-9A-Fa-f]{6}$/',
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


        Color::create([

            'name' =>
                $validated['name'],


            'slug' =>
                $this->uniqueSlug(
                    $validated['name']
                ),


            'hex_code' =>
                $this->normalizeHex(
                    $validated['hex_code']
                ),


            'sort_order' =>
                $validated['sort_order']
                ?? 0,


            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()

            ->route(
                'admin.colors.index'
            )

            ->with(
                'success',
                'Color created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Color $color
    ): RedirectResponse {

        return redirect()

            ->route(
                'admin.colors.edit',
                $color
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Color $color
    ): View {

        return view(
            'backend.colors.edit',
            compact('color')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(

        Request $request,

        Color $color

    ): RedirectResponse {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:100',
            ],


            'hex_code' => [
                'required',
                'string',
                'regex:/^#?[0-9A-Fa-f]{6}$/',
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


        $color->update([

            'name' =>
                $validated['name'],


            'slug' =>
                $this->uniqueSlug(
                    $validated['name'],
                    $color->id
                ),


            'hex_code' =>
                $this->normalizeHex(
                    $validated['hex_code']
                ),


            'sort_order' =>
                $validated['sort_order']
                ?? 0,


            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()

            ->route(
                'admin.colors.index'
            )

            ->with(
                'success',
                'Color updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Move To Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Color $color
    ): RedirectResponse {

        $color->delete();


        return redirect()

            ->route(
                'admin.colors.index'
            )

            ->with(
                'success',
                'Color moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trashed
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $colors = Color::onlyTrashed()

            ->orderByDesc('deleted_at')

            ->paginate(20);


        return view(
            'backend.colors.trashed',
            compact('colors')
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

        $color = Color::onlyTrashed()
            ->findOrFail($id);


        $color->restore();


        return redirect()

            ->route(
                'admin.colors.trashed'
            )

            ->with(
                'success',
                'Color restored successfully.'
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

        $color = Color::onlyTrashed()
            ->findOrFail($id);


        $color->forceDelete();


        return redirect()

            ->route(
                'admin.colors.trashed'
            )

            ->with(
                'success',
                'Color permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize HEX
    |--------------------------------------------------------------------------
    |
    | FFFFFF
    | becomes
    | #FFFFFF
    |
    */

    private function normalizeHex(
        string $hex
    ): string {

        $hex = trim($hex);

        $hex = ltrim(
            $hex,
            '#'
        );


        return '#'
            . strtoupper($hex);
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
            Str::slug($name);


        if ($base === '') {

            $base = 'color';

        }


        $slug = $base;

        $counter = 2;


        while (

            Color::withTrashed()

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