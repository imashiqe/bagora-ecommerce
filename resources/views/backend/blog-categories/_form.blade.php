<div class="row">

    <div class="col-md-8">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    Category Information
                </h3>
            </div>


            <div class="card-body">

                {{-- Name --}}
                <div class="mb-3">

                    <label class="form-label">
                        Category Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $blogCategory->name ?? '') }}"
                        required
                    >

                    @error('name')
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
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $blogCategory->slug ?? '') }}"
                        placeholder="Leave empty to generate automatically"
                    >

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                    >{{ old('description', $blogCategory->description ?? '') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Settings
                </h3>

            </div>


            <div class="card-body">

                {{-- Sort --}}
                <div class="mb-3">

                    <label class="form-label">
                        Sort Order
                    </label>

                    <input
                        type="number"
                        min="0"
                        name="sort_order"
                        class="form-control"
                        value="{{ old('sort_order', $blogCategory->sort_order ?? 0) }}"
                    >

                </div>


                {{-- Status --}}
                <div class="form-check form-switch">

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        class="form-check-input"
                        id="status"
                        @checked(
                            old(
                                'status',
                                isset($blogCategory)
                                    ? $blogCategory->status
                                    : true
                            )
                        )
                    >

                    <label
                        class="form-check-label"
                        for="status"
                    >
                        Active
                    </label>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="mt-3">

    <button
        type="submit"
        class="btn btn-primary"
    >
        <i class="bi bi-check-circle me-1"></i>

        {{ isset($blogCategory)
            ? 'Update Category'
            : 'Create Category'
        }}
    </button>


    <a
        href="{{ route('admin.blog-categories.index') }}"
        class="btn btn-secondary"
    >
        Cancel
    </a>

</div>