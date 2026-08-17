<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Throwable;
class BlogController extends Controller
{

/*
|--------------------------------------------------------------------------
| CKEDITOR CONTENT IMAGE UPLOAD
|--------------------------------------------------------------------------
*/

public function uploadContentImage(
    Request $request
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Validate Image
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'upload' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:6144',
        ],
    ]);


    try {

        /*
        |--------------------------------------------------------------------------
        | Uploaded File
        |--------------------------------------------------------------------------
        */

        $file = $request->file('upload');


        if (
            !$file
            ||
            !$file->isValid()
        ) {

            return response()->json(
                [
                    'error' => [
                        'message' =>
                            'Invalid image upload.',
                    ],
                ],
                422
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Public Directory
        |--------------------------------------------------------------------------
        */

        $relativeDirectory =
            'uploads/blogs/content';

        $destinationDirectory =
            public_path($relativeDirectory);


        /*
        |--------------------------------------------------------------------------
        | Create Folder
        |--------------------------------------------------------------------------
        */

        if (!is_dir($destinationDirectory)) {

            mkdir(
                $destinationDirectory,
                0755,
                true
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Safe Unique Filename
        |--------------------------------------------------------------------------
        */

        $extension =
            strtolower(
                $file->extension()
            );


        $filename =
            'blog-content-'
            . Str::uuid()
            . '.'
            . $extension;


        /*
        |--------------------------------------------------------------------------
        | Move Directly To Public
        |--------------------------------------------------------------------------
        |
        | No Storage::disk()
        | No storage/app/public
        | No storage:link
        |
        */

        $file->move(
            $destinationDirectory,
            $filename
        );


        /*
        |--------------------------------------------------------------------------
        | Relative Path
        |--------------------------------------------------------------------------
        */

        $relativePath =
            $relativeDirectory
            . '/'
            . $filename;


        /*
        |--------------------------------------------------------------------------
        | CKEditor Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'url' => asset($relativePath),
        ]);

    } catch (Throwable $e) {

        report($e);


        return response()->json(
            [
                'error' => [
                    'message' =>
                        'Image upload failed. Please try again.',
                ],
            ],
            500
        );

    }
}
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = Blog::query()
            ->with('category');


        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {

                        $categoryQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                    });

            });

        }


        if ($request->filled('category_id')) {

            $query->where(
                'blog_category_id',
                $request->category_id
            );

        }


        if ($request->filled('status')) {

            $query->where(
                'status',
                (int) $request->status
            );

        }


        $blogs = $query
            ->orderByDesc('publish_date')
            ->orderByDesc('publish_time')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();


        $categories = BlogCategory::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();


        return view(
            'backend.blogs.index',
            compact(
                'blogs',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $categories = BlogCategory::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'backend.blogs.create',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([

            'blog_category_id' => [
                'required',

                Rule::exists(
                    'blog_categories',
                    'id'
                )->whereNull('deleted_at'),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:blogs,slug',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:6144',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'content' => [
                'required',
                'string',
            ],

            'author_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'publish_date' => [
                'nullable',
                'date',
            ],

            'publish_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug']
            ?? Str::slug($validated['title']);

        $slug = $this->makeUniqueSlug($slug);


        /*
        |--------------------------------------------------------------------------
        | Thumbnail
        |--------------------------------------------------------------------------
        */

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {

            $thumbnail = ImageHelper::uploadLogo(
                $request->file('thumbnail'),
                'uploads/blogs',
                1200,
                800,
                90
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        Blog::create([

            'blog_category_id' =>
                $validated['blog_category_id'],

            'title' =>
                $validated['title'],

            'slug' =>
                $slug,

            'thumbnail' =>
                $thumbnail,

            'short_description' =>
                $validated['short_description'] ?? null,

            'content' =>
                $validated['content'],

            'author_name' =>
                $validated['author_name'] ?? null,

            'publish_date' =>
                $validated['publish_date'] ?? null,

            'publish_time' =>
                $validated['publish_time'] ?? null,

            'featured' =>
                $request->boolean('featured'),

            'status' =>
                $request->boolean('status'),

            'meta_title' =>
                $validated['meta_title'] ?? null,

            'meta_description' =>
                $validated['meta_description'] ?? null,

            'meta_keywords' =>
                $validated['meta_keywords'] ?? null,

            'views' => 0,

        ]);


        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Blog $blog): View
    {
        $categories = BlogCategory::query()
            ->where('status', true)
            ->orWhere(
                'id',
                $blog->blog_category_id
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();


        return view(
            'backend.blogs.edit',
            compact(
                'blog',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Blog $blog
    ): RedirectResponse {

        $validated = $request->validate([

            'blog_category_id' => [
                'required',

                Rule::exists(
                    'blog_categories',
                    'id'
                )->whereNull('deleted_at'),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',

                Rule::unique(
                    'blogs',
                    'slug'
                )->ignore($blog->id),
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:6144',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'content' => [
                'required',
                'string',
            ],

            'author_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'publish_date' => [
                'nullable',
                'date',
            ],

            'publish_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug']
            ?? Str::slug($validated['title']);

        $slug = $this->makeUniqueSlug(
            $slug,
            $blog->id
        );


        /*
        |--------------------------------------------------------------------------
        | Thumbnail
        |--------------------------------------------------------------------------
        */

        $thumbnail = $blog->thumbnail;


        if ($request->hasFile('thumbnail')) {

            $newThumbnail = ImageHelper::uploadLogo(
                $request->file('thumbnail'),
                'uploads/blogs',
                1200,
                800,
                90
            );


            if (
                $newThumbnail
                &&
                $blog->thumbnail
            ) {

                ImageHelper::delete(
                    $blog->thumbnail
                );

            }


            $thumbnail = $newThumbnail;

        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $blog->update([

            'blog_category_id' =>
                $validated['blog_category_id'],

            'title' =>
                $validated['title'],

            'slug' =>
                $slug,

            'thumbnail' =>
                $thumbnail,

            'short_description' =>
                $validated['short_description'] ?? null,

            'content' =>
                $validated['content'],

            'author_name' =>
                $validated['author_name'] ?? null,

            'publish_date' =>
                $validated['publish_date'] ?? null,

            'publish_time' =>
                $validated['publish_time'] ?? null,

            'featured' =>
                $request->boolean('featured'),

            'status' =>
                $request->boolean('status'),

            'meta_title' =>
                $validated['meta_title'] ?? null,

            'meta_description' =>
                $validated['meta_description'] ?? null,

            'meta_keywords' =>
                $validated['meta_keywords'] ?? null,

        ]);


        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SOFT DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Blog $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TRASH
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $blogs = Blog::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(20);


        return view(
            'backend.blogs.trashed',
            compact('blogs')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESTORE
    |--------------------------------------------------------------------------
    */

    public function restore(int $id): RedirectResponse
    {
        $blog = Blog::onlyTrashed()
            ->with('category')
            ->findOrFail($id);


        if (
            !$blog->category
            ||
            $blog->category->trashed()
        ) {

            return back()->with(
                'error',
                'Restore the blog category first.'
            );

        }


        $blog->restore();


        return redirect()
            ->route('admin.blogs.trashed')
            ->with(
                'success',
                'Blog restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORCE DELETE
    |--------------------------------------------------------------------------
    */

    public function forceDelete(int $id): RedirectResponse
    {
        $blog = Blog::onlyTrashed()
            ->findOrFail($id);


        if ($blog->thumbnail) {

            ImageHelper::delete(
                $blog->thumbnail
            );

        }


        $blog->forceDelete();


        return redirect()
            ->route('admin.blogs.trashed')
            ->with(
                'success',
                'Blog permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UNIQUE SLUG
    |--------------------------------------------------------------------------
    */

    private function makeUniqueSlug(
        string $slug,
        ?int $ignoreId = null
    ): string {

        $baseSlug = $slug ?: 'blog';

        $slug = $baseSlug;

        $counter = 1;


        while (

            Blog::withTrashed()
                ->where('slug', $slug)

                ->when(
                    $ignoreId,
                    function ($query) use ($ignoreId) {

                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        );

                    }
                )

                ->exists()

        ) {

            $slug =
                $baseSlug
                . '-'
                . $counter;

            $counter++;

        }


        return $slug;
    }
}