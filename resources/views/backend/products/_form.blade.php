@php

    $editing = isset($product) && $product;


    $selectedCategory = (string) old(
        'category_id',
        $editing ? $product->category_id : ''
    );


    $selectedSubCategory = (string) old(
        'sub_category_id',
        $editing ? $product->sub_category_id : ''
    );


    $selectedChildCategory = (string) old(
        'child_category_id',
        $editing ? $product->child_category_id : ''
    );


    $selectedBrand = (string) old(
        'brand_id',
        $editing ? $product->brand_id : ''
    );


    $featureValues = old(
        'key_features',
        $editing
            ? $product->keyFeatures
                ->pluck('feature')
                ->toArray()
            : ['']
    );


    if (
        !is_array($featureValues)
        ||
        count($featureValues) === 0
    ) {
        $featureValues = [''];
    }

@endphp



<div class="row">

    {{-- ========================================================= --}}
    {{-- LEFT COLUMN --}}
    {{-- ========================================================= --}}

    <div class="col-lg-8">


        {{-- ========================================================= --}}
        {{-- PRODUCT INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Product Information
                </h3>

            </div>


            <div class="card-body">


                {{-- Product Title --}}
                <div class="mb-3">

                    <label
                        for="title"
                        class="form-label"
                    >
                        Product Title

                        <span class="text-danger">*</span>
                    </label>


                    <input
                        type="text"
                        name="title"
                        id="title"

                        value="{{ old(
                            'title',
                            $editing ? $product->title : ''
                        ) }}"

                        class="
                            form-control

                            @error('title')
                                is-invalid
                            @enderror
                        "

                        placeholder="Example: Premium Travel Backpack"

                        required
                    >


                    @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                <div class="row">


                    {{-- SKU --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="sku"
                                class="form-label"
                            >
                                SKU

                                <span class="text-danger">*</span>
                            </label>


                            <input
                                type="text"
                                name="sku"
                                id="sku"

                                value="{{ old(
                                    'sku',
                                    $editing ? $product->sku : ''
                                ) }}"

                                class="
                                    form-control

                                    @error('sku')
                                        is-invalid
                                    @enderror
                                "

                                placeholder="Example: BAG-001"

                                required
                            >


                            @error('sku')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Model Number --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="model_no"
                                class="form-label"
                            >
                                Model Number
                            </label>


                            <input
                                type="text"
                                name="model_no"
                                id="model_no"

                                value="{{ old(
                                    'model_no',
                                    $editing ? $product->model_no : ''
                                ) }}"

                                class="
                                    form-control

                                    @error('model_no')
                                        is-invalid
                                    @enderror
                                "

                                placeholder="Example: R1308"
                            >


                            @error('model_no')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- CLASSIFICATION --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Product Classification
                </h3>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- Category --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="category_id"
                                class="form-label"
                            >
                                Category

                                <span class="text-danger">*</span>
                            </label>


                            <select
                                name="category_id"
                                id="category_id"

                                class="
                                    form-select

                                    @error('category_id')
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
                                            (string) $selectedCategory
                                            ===
                                            (string) $category->id
                                        )
                                    >

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>


                            @error('category_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Sub Category --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="sub_category_id"
                                class="form-label"
                            >
                                Sub Category
                            </label>


                            <select
                                name="sub_category_id"
                                id="sub_category_id"

                                data-selected="{{ $selectedSubCategory }}"

                                class="
                                    form-select

                                    @error('sub_category_id')
                                        is-invalid
                                    @enderror
                                "
                            >

                                <option value="">
                                    Select Sub Category
                                </option>


                                @foreach($subcategories as $subcategory)

                                    <option
                                        value="{{ $subcategory->id }}"

                                        data-category="{{ $subcategory->category_id }}"
                                    >

                                        {{ $subcategory->name }}

                                    </option>

                                @endforeach

                            </select>


                            @error('sub_category_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Child Category --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="child_category_id"
                                class="form-label"
                            >
                                Child Category
                            </label>


                            <select
                                name="child_category_id"
                                id="child_category_id"

                                data-selected="{{ $selectedChildCategory }}"

                                class="
                                    form-select

                                    @error('child_category_id')
                                        is-invalid
                                    @enderror
                                "
                            >

                                <option value="">
                                    Select Child Category
                                </option>


                                @foreach($childcategories as $childcategory)

                                    <option
                                        value="{{ $childcategory->id }}"

                                        data-category="{{ $childcategory->category_id }}"

                                        data-subcategory="{{ $childcategory->sub_category_id }}"
                                    >

                                        {{ $childcategory->name }}

                                    </option>

                                @endforeach

                            </select>


                            @error('child_category_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Brand --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="brand_id"
                                class="form-label"
                            >
                                Brand
                            </label>


                            <select
                                name="brand_id"
                                id="brand_id"

                                class="
                                    form-select

                                    @error('brand_id')
                                        is-invalid
                                    @enderror
                                "
                            >

                                <option value="">
                                    No Brand
                                </option>


                                @foreach($brands as $brand)

                                    <option
                                        value="{{ $brand->id }}"

                                        @selected(
                                            (string) $selectedBrand
                                            ===
                                            (string) $brand->id
                                        )
                                    >

                                        {{ $brand->name }}

                                    </option>

                                @endforeach

                            </select>


                            @error('brand_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- DESCRIPTION --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Product Description
                </h3>

            </div>


            <div class="card-body">


                {{-- Short Description --}}
                <div class="mb-3">

                    <label
                        for="short_description"
                        class="form-label"
                    >
                        Short Description
                    </label>


                    <textarea
                        name="short_description"
                        id="short_description"

                        rows="4"

                        class="
                            form-control

                            @error('short_description')
                                is-invalid
                            @enderror
                        "

                        placeholder="Short product description..."
                    >{{ old(
                        'short_description',
                        $editing
                            ? $product->short_description
                            : ''
                    ) }}</textarea>


                    @error('short_description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- Full Description --}}
                <div>

                    <label
                        for="description"
                        class="form-label"
                    >
                        Full Description
                    </label>


                    <textarea
                        name="description"
                        id="description"

                        rows="10"

                        class="
                            form-control

                            @error('description')
                                is-invalid
                            @enderror
                        "

                        placeholder="Complete product description..."
                    >{{ old(
                        'description',
                        $editing
                            ? $product->description
                            : ''
                    ) }}</textarea>


                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- KEY FEATURES --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div
                class="
                    card-header
                    d-flex
                    align-items-center
                    justify-content-between
                "
            >

                <h3 class="card-title mb-0">
                    Key Features
                </h3>


                <button
                    type="button"
                    id="addFeature"

                    class="
                        btn
                        btn-sm
                        btn-outline-primary
                    "
                >

                    <i class="bi bi-plus-circle me-1"></i>

                    Add Feature

                </button>

            </div>


            <div class="card-body">


                <div id="featureContainer">


                    @foreach($featureValues as $feature)

                        <div
                            class="
                                feature-row
                                input-group
                                mb-2
                            "
                        >

                            <span class="input-group-text">

                                <i class="bi bi-check2-circle"></i>

                            </span>


                            <input
                                type="text"

                                name="key_features[]"

                                value="{{ $feature }}"

                                class="form-control"

                                placeholder="Example: Water Resistant Premium Fabric"
                            >


                            <button
                                type="button"

                                class="
                                    btn
                                    btn-outline-danger
                                    remove-feature
                                "
                            >

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    @endforeach


                </div>


                @error('key_features')

                    <div class="text-danger small mt-2">

                        {{ $message }}

                    </div>

                @enderror


                @error('key_features.*')

                    <div class="text-danger small mt-2">

                        {{ $message }}

                    </div>

                @enderror


                <div class="form-text">

                    Maximum 20 features.

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- EXISTING GALLERY --}}
        {{-- ========================================================= --}}

        @if(
            $editing
            &&
            $product->images->count()
        )

            <div class="card mb-4">

                <div class="card-header">

                    <h3 class="card-title mb-0">
                        Current Gallery
                    </h3>

                </div>


                <div class="card-body">

                    <div class="row g-3">


                        @foreach($product->images as $image)

                            <div
                                class="
                                    col-6
                                    col-md-4
                                    col-xl-3
                                "
                            >

                                <div
                                    class="
                                        border
                                        rounded
                                        p-2
                                        position-relative
                                    "
                                >

                                    <img
                                        src="{{ asset($image->image) }}"

                                        alt="{{ $image->alt_text ?? $product->title }}"

                                        class="
                                            img-fluid
                                            rounded
                                        "

                                        style="
                                            width:100%;
                                            height:150px;
                                            object-fit:cover;
                                        "
                                    >


                                    <button
                                        type="submit"

                                        form="delete-gallery-{{ $image->id }}"

                                        class="
                                            btn
                                            btn-sm
                                            btn-danger
                                            position-absolute
                                            top-0
                                            end-0
                                            m-2
                                        "

                                        onclick="
                                            return confirm(
                                                'Delete this gallery image?'
                                            );
                                        "
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>

                            </div>

                        @endforeach


                    </div>

                </div>

            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- NEW GALLERY --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Product Gallery
                </h3>

            </div>


            <div class="card-body">


                <input
                    type="file"

                    name="gallery[]"

                    id="gallery"

                    multiple

                    accept=".jpg,.jpeg,.png,.webp"

                    class="
                        form-control

                        @error('gallery')
                            is-invalid
                        @enderror
                    "
                >


                @error('gallery')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                @error('gallery.*')

                    <div class="text-danger small mt-2">

                        {{ $message }}

                    </div>

                @enderror


                <div class="form-text">

                    Select up to 10 product images.
                    Maximum 5MB each.

                </div>


                <div
                    id="galleryPreview"

                    class="
                        row
                        g-2
                        mt-2
                    "
                ></div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- SEO --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    SEO Information
                </h3>

            </div>


            <div class="card-body">


                {{-- Meta Title --}}
                <div class="mb-3">

                    <label
                        for="meta_title"
                        class="form-label"
                    >
                        Meta Title
                    </label>


                    <input
                        type="text"

                        name="meta_title"

                        id="meta_title"

                        value="{{ old(
                            'meta_title',
                            $editing
                                ? $product->meta_title
                                : ''
                        ) }}"

                        class="
                            form-control

                            @error('meta_title')
                                is-invalid
                            @enderror
                        "
                    >


                    @error('meta_title')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- Meta Description --}}
                <div class="mb-3">

                    <label
                        for="meta_description"
                        class="form-label"
                    >
                        Meta Description
                    </label>


                    <textarea
                        name="meta_description"

                        id="meta_description"

                        rows="4"

                        class="
                            form-control

                            @error('meta_description')
                                is-invalid
                            @enderror
                        "
                    >{{ old(
                        'meta_description',
                        $editing
                            ? $product->meta_description
                            : ''
                    ) }}</textarea>


                    @error('meta_description')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- Keywords --}}
                <div>

                    <label
                        for="keywords"
                        class="form-label"
                    >
                        Keywords
                    </label>


                    <textarea
                        name="keywords"

                        id="keywords"

                        rows="3"

                        class="
                            form-control

                            @error('keywords')
                                is-invalid
                            @enderror
                        "

                        placeholder="backpack, travel bag, laptop bag"
                    >{{ old(
                        'keywords',
                        $editing
                            ? $product->keywords
                            : ''
                    ) }}</textarea>


                    @error('keywords')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- RIGHT COLUMN --}}
    {{-- ========================================================= --}}

    <div class="col-lg-4">


        {{-- ========================================================= --}}
        {{-- THUMBNAIL --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Product Thumbnail
                </h3>

            </div>


            <div class="card-body">


                <div class="text-center mb-3">


                    <img
                        id="thumbnailPreview"

                        src="{{
                            $editing
                            &&
                            $product->thumbnail

                                ? asset(
                                    $product->thumbnail
                                )

                                : ''
                        }}"

                        alt="Product Thumbnail"

                        class="
                            img-fluid
                            rounded
                            border

                            {{
                                !$editing
                                ||
                                !$product->thumbnail

                                    ? 'd-none'

                                    : ''
                            }}
                        "

                        style="
                            width:100%;
                            max-height:320px;
                            object-fit:cover;
                        "
                    >


                </div>


                <input
                    type="file"

                    name="thumbnail"

                    id="thumbnail"

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


                <div class="form-text">

                    Recommended square product image.

                    Maximum 5MB.

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- PRICE --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Pricing
                </h3>

            </div>


            <div class="card-body">


                {{-- Cost --}}
                <div class="mb-3">

                    <label
                        for="cost_price"
                        class="form-label"
                    >
                        Cost Price
                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            ৳
                        </span>


                        <input
                            type="number"

                            name="cost_price"

                            id="cost_price"

                            min="0"

                            step="0.01"

                            value="{{ old(
                                'cost_price',
                                $editing
                                    ? $product->cost_price
                                    : 0
                            ) }}"

                            class="
                                form-control

                                @error('cost_price')
                                    is-invalid
                                @enderror
                            "
                        >

                    </div>


                    @error('cost_price')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- Regular Price --}}
                <div class="mb-3">

                    <label
                        for="regular_price"
                        class="form-label"
                    >
                        Regular Price

                        <span class="text-danger">*</span>
                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            ৳
                        </span>


                        <input
                            type="number"

                            name="regular_price"

                            id="regular_price"

                            min="0"

                            step="0.01"

                            value="{{ old(
                                'regular_price',
                                $editing
                                    ? $product->regular_price
                                    : ''
                            ) }}"

                            class="
                                form-control

                                @error('regular_price')
                                    is-invalid
                                @enderror
                            "

                            required
                        >

                    </div>


                    @error('regular_price')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- Sale Price --}}
                <div>

                    <label
                        for="sale_price"
                        class="form-label"
                    >
                        Sale Price
                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            ৳
                        </span>


                        <input
                            type="number"

                            name="sale_price"

                            id="sale_price"

                            min="0"

                            step="0.01"

                            value="{{ old(
                                'sale_price',
                                $editing
                                    ? $product->sale_price
                                    : ''
                            ) }}"

                            class="
                                form-control

                                @error('sale_price')
                                    is-invalid
                                @enderror
                            "
                        >

                    </div>


                    @error('sale_price')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- PRODUCT OPTIONS --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Product Options
                </h3>

            </div>


            <div class="card-body">


                {{-- Featured --}}
                <input
                    type="hidden"
                    name="featured"
                    value="0"
                >


                <div class="form-check form-switch mb-3">

                    <input
                        type="checkbox"

                        name="featured"

                        id="featured"

                        value="1"

                        class="form-check-input"

                        @checked(
                            (bool) old(
                                'featured',
                                $editing
                                    ? $product->featured
                                    : false
                            )
                        )
                    >


                    <label
                        for="featured"

                        class="form-check-label"
                    >

                        Featured Product

                    </label>

                </div>



                {{-- Best Seller --}}
                <input
                    type="hidden"
                    name="best_seller"
                    value="0"
                >


                <div class="form-check form-switch mb-3">

                    <input
                        type="checkbox"

                        name="best_seller"

                        id="best_seller"

                        value="1"

                        class="form-check-input"

                        @checked(
                            (bool) old(
                                'best_seller',
                                $editing
                                    ? $product->best_seller
                                    : false
                            )
                        )
                    >


                    <label
                        for="best_seller"

                        class="form-check-label"
                    >

                        Best Seller

                    </label>

                </div>



                {{-- New Arrival --}}
                <input
                    type="hidden"
                    name="new_arrival"
                    value="0"
                >


                <div class="form-check form-switch mb-3">

                    <input
                        type="checkbox"

                        name="new_arrival"

                        id="new_arrival"

                        value="1"

                        class="form-check-input"

                        @checked(
                            (bool) old(
                                'new_arrival',
                                $editing
                                    ? $product->new_arrival
                                    : false
                            )
                        )
                    >


                    <label
                        for="new_arrival"

                        class="form-check-label"
                    >

                        New Arrival

                    </label>

                </div>



                {{-- Status --}}
                <input
                    type="hidden"
                    name="status"
                    value="0"
                >


                <div class="form-check form-switch">

                    <input
                        type="checkbox"

                        name="status"

                        id="status"

                        value="1"

                        class="form-check-input"

                        @checked(
                            (bool) old(
                                'status',
                                $editing
                                    ? $product->status
                                    : true
                            )
                        )
                    >


                    <label
                        for="status"

                        class="form-check-label"
                    >

                        Active Product

                    </label>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- SAVE --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-body">


                <button
                    type="submit"

                    class="
                        btn
                        btn-primary
                        w-100
                    "
                >

                    <i class="bi bi-check-circle me-1"></i>


                    {{
                        $editing
                            ? 'Update Product'
                            : 'Save Product'
                    }}

                </button>



                <a
                    href="{{ route('admin.products.index') }}"

                    class="
                        btn
                        btn-outline-secondary
                        w-100
                        mt-2
                    "
                >

                    Cancel

                </a>

            </div>

        </div>


    </div>

</div>



{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Category Dropdowns
        |--------------------------------------------------------------------------
        */

        const categorySelect =
            document.getElementById(
                'category_id'
            );


        const subCategorySelect =
            document.getElementById(
                'sub_category_id'
            );


        const childCategorySelect =
            document.getElementById(
                'child_category_id'
            );


        /*
        |--------------------------------------------------------------------------
        | Save Original Options
        |--------------------------------------------------------------------------
        */

        const originalSubOptions =

            Array.from(
                subCategorySelect.options
            )

            .map(
                function (option) {

                    return option.cloneNode(
                        true
                    );

                }
            );


        const originalChildOptions =

            Array.from(
                childCategorySelect.options
            )

            .map(
                function (option) {

                    return option.cloneNode(
                        true
                    );

                }
            );


        const initialSubCategory =
            String(
                subCategorySelect.dataset.selected
                || ''
            );


        const initialChildCategory =
            String(
                childCategorySelect.dataset.selected
                || ''
            );


        /*
        |--------------------------------------------------------------------------
        | Sub Category Filter
        |--------------------------------------------------------------------------
        */

        function populateSubCategories(
            selectedValue = ''
        ) {

            const categoryId =
                String(
                    categorySelect.value
                    || ''
                );


            subCategorySelect.innerHTML =
                '';


            originalSubOptions.forEach(
                function (option) {

                    const optionCategory =
                        option.dataset.category
                        || '';


                    if (
                        option.value === ''
                        ||
                        optionCategory === categoryId
                    ) {

                        const clone =
                            option.cloneNode(
                                true
                            );


                        clone.selected =
                            String(clone.value)
                            ===
                            String(selectedValue);


                        subCategorySelect
                            .appendChild(
                                clone
                            );

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | If old selected option doesn't exist
            |--------------------------------------------------------------------------
            */

            if (
                !Array.from(
                    subCategorySelect.options
                ).some(
                    function (option) {

                        return String(
                            option.value
                        )
                        ===
                        String(
                            selectedValue
                        );

                    }
                )
            ) {

                subCategorySelect.value =
                    '';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Child Category Filter
        |--------------------------------------------------------------------------
        */

        function populateChildCategories(
            selectedValue = ''
        ) {

            const categoryId =
                String(
                    categorySelect.value
                    || ''
                );


            const subCategoryId =
                String(
                    subCategorySelect.value
                    || ''
                );


            childCategorySelect.innerHTML =
                '';


            originalChildOptions.forEach(
                function (option) {

                    const optionCategory =
                        option.dataset.category
                        || '';


                    const optionSubCategory =
                        option.dataset.subcategory
                        || '';


                    if (
                        option.value === ''
                        ||
                        (
                            optionCategory ===
                            categoryId

                            &&

                            optionSubCategory ===
                            subCategoryId
                        )
                    ) {

                        const clone =
                            option.cloneNode(
                                true
                            );


                        clone.selected =
                            String(
                                clone.value
                            )
                            ===
                            String(
                                selectedValue
                            );


                        childCategorySelect
                            .appendChild(
                                clone
                            );

                    }

                }
            );


            if (
                !Array.from(
                    childCategorySelect.options
                ).some(
                    function (option) {

                        return String(
                            option.value
                        )
                        ===
                        String(
                            selectedValue
                        );

                    }
                )
            ) {

                childCategorySelect.value =
                    '';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Initial State
        |--------------------------------------------------------------------------
        */

        populateSubCategories(
            initialSubCategory
        );


        populateChildCategories(
            initialChildCategory
        );



        /*
        |--------------------------------------------------------------------------
        | Category Changed
        |--------------------------------------------------------------------------
        */

        categorySelect.addEventListener(
            'change',
            function () {

                populateSubCategories(
                    ''
                );


                populateChildCategories(
                    ''
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Sub Category Changed
        |--------------------------------------------------------------------------
        */

        subCategorySelect.addEventListener(
            'change',
            function () {

                populateChildCategories(
                    ''
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Thumbnail Preview
        |--------------------------------------------------------------------------
        */

        const thumbnailInput =
            document.getElementById(
                'thumbnail'
            );


        const thumbnailPreview =
            document.getElementById(
                'thumbnailPreview'
            );


        if (
            thumbnailInput
            &&
            thumbnailPreview
        ) {

            thumbnailInput.addEventListener(
                'change',
                function () {

                    const file =
                        this.files[0];


                    if (!file) {

                        return;

                    }


                    if (
                        !file.type.startsWith(
                            'image/'
                        )
                    ) {

                        return;

                    }


                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            thumbnailPreview.src =
                                event.target.result;


                            thumbnailPreview
                                .classList
                                .remove(
                                    'd-none'
                                );

                        };


                    reader.readAsDataURL(
                        file
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | Gallery Preview
        |--------------------------------------------------------------------------
        */

        const galleryInput =
            document.getElementById(
                'gallery'
            );


        const galleryPreview =
            document.getElementById(
                'galleryPreview'
            );


        if (
            galleryInput
            &&
            galleryPreview
        ) {

            galleryInput.addEventListener(
                'change',
                function () {

                    galleryPreview.innerHTML =
                        '';


                    const files =
                        Array.from(
                            this.files
                        );


                    if (
                        files.length > 10
                    ) {

                        alert(
                            'Maximum 10 gallery images per upload.'
                        );

                        this.value = '';

                        return;

                    }


                    files.forEach(
                        function (file) {

                            if (
                                !file.type
                                    .startsWith(
                                        'image/'
                                    )
                            ) {

                                return;

                            }


                            const reader =
                                new FileReader();


                            reader.onload =
                                function (event) {

                                    const column =
                                        document.createElement(
                                            'div'
                                        );


                                    column.className =
                                        'col-6 col-md-4 col-xl-3';


                                    const wrapper =
                                        document.createElement(
                                            'div'
                                        );


                                    wrapper.className =
                                        'border rounded p-1';


                                    const image =
                                        document.createElement(
                                            'img'
                                        );


                                    image.src =
                                        event.target.result;


                                    image.className =
                                        'rounded';


                                    image.style.width =
                                        '100%';


                                    image.style.height =
                                        '120px';


                                    image.style.objectFit =
                                        'cover';


                                    wrapper.appendChild(
                                        image
                                    );


                                    column.appendChild(
                                        wrapper
                                    );


                                    galleryPreview
                                        .appendChild(
                                            column
                                        );

                                };


                            reader.readAsDataURL(
                                file
                            );

                        }
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | Key Features
        |--------------------------------------------------------------------------
        */

        const featureContainer =
            document.getElementById(
                'featureContainer'
            );


        const addFeatureButton =
            document.getElementById(
                'addFeature'
            );


        if (
            featureContainer
            &&
            addFeatureButton
        ) {

            /*
            |--------------------------------------------------------------------------
            | Add Feature
            |--------------------------------------------------------------------------
            */

            addFeatureButton.addEventListener(
                'click',
                function () {

                    const rows =
                        featureContainer
                            .querySelectorAll(
                                '.feature-row'
                            );


                    if (
                        rows.length >= 20
                    ) {

                        alert(
                            'Maximum 20 key features allowed.'
                        );

                        return;

                    }


                    const row =
                        document.createElement(
                            'div'
                        );


                    row.className =
                        'feature-row input-group mb-2';


                    const icon =
                        document.createElement(
                            'span'
                        );


                    icon.className =
                        'input-group-text';


                    icon.innerHTML =
                        '<i class="bi bi-check2-circle"></i>';


                    const input =
                        document.createElement(
                            'input'
                        );


                    input.type =
                        'text';


                    input.name =
                        'key_features[]';


                    input.className =
                        'form-control';


                    input.placeholder =
                        'Example: Heavy Duty Zipper';


                    const removeButton =
                        document.createElement(
                            'button'
                        );


                    removeButton.type =
                        'button';


                    removeButton.className =
                        'btn btn-outline-danger remove-feature';


                    removeButton.innerHTML =
                        '<i class="bi bi-trash"></i>';


                    row.appendChild(
                        icon
                    );


                    row.appendChild(
                        input
                    );


                    row.appendChild(
                        removeButton
                    );


                    featureContainer
                        .appendChild(
                            row
                        );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | Remove Feature
            |--------------------------------------------------------------------------
            */

            featureContainer.addEventListener(
                'click',
                function (event) {

                    const button =
                        event.target.closest(
                            '.remove-feature'
                        );


                    if (!button) {

                        return;

                    }


                    const row =
                        button.closest(
                            '.feature-row'
                        );


                    if (row) {

                        row.remove();

                    }

                }
            );

        }

    }
);

</script>

@endpush