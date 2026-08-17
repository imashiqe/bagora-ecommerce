<div class="row">

    {{-- ========================================================= --}}
    {{-- LEFT --}}
    {{-- ========================================================= --}}

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    Blog Content
                </h3>
            </div>


            <div class="card-body">

                {{-- Category --}}
                <div class="mb-3">

                    <label class="form-label">
                        Blog Category
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="blog_category_id"
                        class="
                            form-select
                            @error('blog_category_id')
                                is-invalid
                            @enderror
                        "
                        required
                    >

                        <option value="">
                            Select Category
                        </option>


                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'blog_category_id',
                                        $blog->blog_category_id ?? ''
                                    )
                                    == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>


                    @error('blog_category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Title --}}
                <div class="mb-3">

                    <label class="form-label">
                        Blog Title
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="
                            form-control
                            @error('title')
                                is-invalid
                            @enderror
                        "
                        value="{{ old('title', $blog->title ?? '') }}"
                        required
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Slug --}}
                <div class="mb-3">

                    <label class="form-label">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        class="
                            form-control
                            @error('slug')
                                is-invalid
                            @enderror
                        "
                        value="{{ old('slug', $blog->slug ?? '') }}"
                        placeholder="Leave blank to generate automatically"
                    >

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Short Description --}}
                <div class="mb-3">

                    <label class="form-label">
                        Short Description
                    </label>

          {{-- ========================================================= --}}
{{-- BLOG CONTENT - CKEDITOR --}}
{{-- ========================================================= --}}

<div class="mb-3">

    <label
        for="blog-content"
        class="form-label"
    >
        Blog Content

        <span class="text-danger">
            *
        </span>
    </label>


    <textarea
        id="blog-content"

        name="content"

        data-upload-url="{{
            route(
                'admin.blogs.content-image.upload'
            )
        }}"

        class="
            form-control
            @error('content')
                is-invalid
            @enderror
        "
    >{{ old(
        'content',
        $blog->content ?? ''
    ) }}</textarea>


    @error('content')

        <div class="text-danger small mt-1">
            {{ $message }}
        </div>

    @enderror


    <small class="text-muted d-block mt-2">

        You can drag & drop, paste,
        or upload images directly
        inside the editor.

    </small>

</div>

                    @error('short_description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- CKEditor --}}
                <div class="mb-3">

                    <label class="form-label">
                        Blog Content
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="blog-content"
                        name="content"
                        class="
                            form-control
                            @error('content')
                                is-invalid
                            @enderror
                        "
                    >{{ old(
                        'content',
                        $blog->content ?? ''
                    ) }}</textarea>

                    @error('content')

                        <div
                            class="text-danger small mt-1"
                        >
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- SEO --}}
        {{-- ========================================================= --}}

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    SEO Settings
                </h3>

            </div>


            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">
                        Meta Title
                    </label>

                    <input
                        type="text"
                        name="meta_title"
                        maxlength="255"
                        class="form-control"
                        value="{{ old(
                            'meta_title',
                            $blog->meta_title ?? ''
                        ) }}"
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Meta Description
                    </label>

                    <textarea
                        name="meta_description"
                        rows="3"
                        class="form-control"
                    >{{ old(
                        'meta_description',
                        $blog->meta_description ?? ''
                    ) }}</textarea>

                </div>


                <div class="mb-0">

                    <label class="form-label">
                        Meta Keywords
                    </label>

                    <textarea
                        name="meta_keywords"
                        rows="2"
                        class="form-control"
                        placeholder="backpack, travel bag, laptop bag"
                    >{{ old(
                        'meta_keywords',
                        $blog->meta_keywords ?? ''
                    ) }}</textarea>

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- RIGHT --}}
    {{-- ========================================================= --}}

    <div class="col-lg-4">

        {{-- Thumbnail --}}
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Thumbnail
                </h3>

            </div>


            <div class="card-body">

                @if(
                    isset($blog)
                    &&
                    $blog->thumbnail
                )

                    <div class="mb-3">

                        <img
                            src="{{ asset($blog->thumbnail) }}"
                            alt="{{ $blog->title }}"
                            class="img-fluid rounded border"
                        >

                    </div>

                @endif


                <input
                    type="file"
                    name="thumbnail"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="
                        form-control
                        @error('thumbnail')
                            is-invalid
                        @enderror
                    "
                >


                @error('thumbnail')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror


                <small class="text-muted">
                    Recommended: 1200 × 800
                </small>

            </div>

        </div>


        {{-- Publishing --}}
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Publishing
                </h3>

            </div>


            <div class="card-body">

                {{-- Author --}}
                <div class="mb-3">

                    <label class="form-label">
                        Author
                    </label>

                    <input
                        type="text"
                        name="author_name"
                        class="form-control"
                        value="{{ old(
                            'author_name',
                            $blog->author_name ?? ''
                        ) }}"
                        placeholder="Bagora Team"
                    >

                </div>


                {{-- Date --}}
                <div class="mb-3">

                    <label class="form-label">
                        Publish Date
                    </label>

                    <input
                        type="date"
                        name="publish_date"
                        class="form-control"
                        value="{{ old(
                            'publish_date',
                            isset($blog) && $blog->publish_date
                                ? $blog->publish_date->format('Y-m-d')
                                : now()->format('Y-m-d')
                        ) }}"
                    >

                </div>


                {{-- Time --}}
                <div class="mb-3">

                    <label class="form-label">
                        Publish Time
                    </label>

                    <input
                        type="time"
                        name="publish_time"
                        class="form-control"
                        value="{{ old(
                            'publish_time',
                            isset($blog)
                                ? substr(
                                    (string) $blog->publish_time,
                                    0,
                                    5
                                )
                                : now()->format('H:i')
                        ) }}"
                    >

                </div>


                {{-- Featured --}}
                <div class="form-check form-switch mb-3">

                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        id="featured"
                        class="form-check-input"
                        @checked(
                            old(
                                'featured',
                                $blog->featured ?? false
                            )
                        )
                    >

                    <label
                        class="form-check-label"
                        for="featured"
                    >
                        Featured Blog
                    </label>

                </div>


                {{-- Status --}}
                <div class="form-check form-switch">

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        id="status"
                        class="form-check-input"
                        @checked(
                            old(
                                'status',
                                isset($blog)
                                    ? $blog->status
                                    : true
                            )
                        )
                    >

                    <label
                        class="form-check-label"
                        for="status"
                    >
                        Published / Active
                    </label>

                </div>

            </div>

        </div>


        <button
            type="submit"
            class="btn btn-primary w-100"
        >

            <i class="bi bi-check-circle me-1"></i>

            {{ isset($blog)
                ? 'Update Blog'
                : 'Publish Blog'
            }}

        </button>

    </div>

</div>


{{-- CKEditor --}}
@push('scripts')

    @vite([
        'resources/js/blog-editor.js'
    ])

@endpush