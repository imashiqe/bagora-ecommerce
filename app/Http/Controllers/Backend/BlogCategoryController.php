<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = BlogCategory::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view(
            'backend.blog-categories.index',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('backend.blog-categories.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:blog_categories,slug',
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
        ]);


        $slug = $validated['slug']
            ?? Str::slug($validated['name']);


        /*
        |--------------------------------------------------------------------------
        | Make generated slug unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (
            BlogCategory::query()
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        BlogCategory::create([
            'name' => $validated['name'],

            'slug' => $slug,

            'description' =>
                $validated['description'] ?? null,

            'sort_order' =>
                $validated['sort_order'] ?? 0,

            'status' =>
                $request->boolean('status'),
        ]);


        return redirect()
            ->route('admin.blog-categories.index')
            ->with(
                'success',
                'Blog category created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        BlogCategory $blogCategory
    ): View {
        return view(
            'backend.blog-categories.edit',
            compact('blogCategory')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        BlogCategory $blogCategory
    ): RedirectResponse {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',

                Rule::unique(
                    'blog_categories',
                    'slug'
                )->ignore($blogCategory->id),
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
        ]);


        $slug = $validated['slug']
            ?? Str::slug($validated['name']);


        $originalSlug = $slug;
        $counter = 1;

        while (
            BlogCategory::query()
                ->where('slug', $slug)
                ->where(
                    'id',
                    '!=',
                    $blogCategory->id
                )
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        $blogCategory->update([
            'name' => $validated['name'],

            'slug' => $slug,

            'description' =>
                $validated['description'] ?? null,

            'sort_order' =>
                $validated['sort_order'] ?? 0,

            'status' =>
                $request->boolean('status'),
        ]);


        return redirect()
            ->route('admin.blog-categories.index')
            ->with(
                'success',
                'Blog category updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        BlogCategory $blogCategory
    ): RedirectResponse {

        $blogCategory->delete();

        return redirect()
            ->route('admin.blog-categories.index')
            ->with(
                'success',
                'Blog category moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $categories = BlogCategory::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(20);

        return view(
            'backend.blog-categories.trashed',
            compact('categories')
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

        $category = BlogCategory::onlyTrashed()
            ->findOrFail($id);

        $category->restore();

        return redirect()
            ->route('admin.blog-categories.trashed')
            ->with(
                'success',
                'Blog category restored successfully.'
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

        $category = BlogCategory::onlyTrashed()
            ->findOrFail($id);

        /*
         * Later when blogs are connected,
         * we can prevent force delete if blogs exist.
         */

        $category->forceDelete();

        return redirect()
            ->route('admin.blog-categories.trashed')
            ->with(
                'success',
                'Blog category permanently deleted.'
            );
    }
}