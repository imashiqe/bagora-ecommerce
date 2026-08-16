<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $banners = Banner::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20);

        return view(
            'backend.banners.index',
            compact('banners')
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
            'backend.banners.create'
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

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:6144',
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
        | Upload directly to public/uploads/banners
        |--------------------------------------------------------------------------
        |
        | uploadLogo() preserves aspect ratio using your existing ImageHelper.
        |
        */

        $image = ImageHelper::uploadLogo(

            $request->file('image'),

            'uploads/banners',

            1920,

            900,

            90

        );


        Banner::create([

            'image' => $image,

            'sort_order' =>
                $validated['sort_order']
                ?? 0,

            'status' =>
                $request->boolean('status'),

        ]);


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Banner $banner
    ): RedirectResponse {

        return redirect()
            ->route(
                'admin.banners.edit',
                $banner
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Banner $banner
    ): View {

        return view(
            'backend.banners.edit',
            compact('banner')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Banner $banner
    ): RedirectResponse {

        $validated = $request->validate([

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:6144',
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


        $oldImage = $banner->image;

        $newImage = null;


        if (
            $request->hasFile('image')
        ) {

            $newImage = ImageHelper::uploadLogo(

                $request->file('image'),

                'uploads/banners',

                1920,

                900,

                90

            );
        }


        $banner->update([

            'image' =>
                $newImage
                ?: $oldImage,

            'sort_order' =>
                $validated['sort_order']
                ?? 0,

            'status' =>
                $request->boolean('status'),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Delete old image only after successful update
        |--------------------------------------------------------------------------
        */

        if ($newImage) {

            ImageHelper::delete(
                $oldImage
            );
        }


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Banner $banner
    ): RedirectResponse {

        /*
        | Do not delete image.
        | Banner may be restored.
        */

        $banner->delete();


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $banners = Banner::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(20);


        return view(
            'backend.banners.trashed',
            compact('banners')
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

        $banner = Banner::onlyTrashed()
            ->findOrFail($id);


        $banner->restore();


        return redirect()
            ->route('admin.banners.trashed')
            ->with(
                'success',
                'Banner restored successfully.'
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

        $banner = Banner::onlyTrashed()
            ->findOrFail($id);


        ImageHelper::delete(
            $banner->image
        );


        $banner->forceDelete();


        return redirect()
            ->route('admin.banners.trashed')
            ->with(
                'success',
                'Banner permanently deleted.'
            );
    }
}