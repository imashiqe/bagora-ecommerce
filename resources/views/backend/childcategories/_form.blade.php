@php

    $editing =
        isset($childcategory)
        && $childcategory;

@endphp


<div class="row">


    <div class="col-lg-8">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Child Category Information

                </h3>

            </div>


            <div class="card-body">


                {{-- Category --}}
                <div class="mb-3">


                    <label
                        for="category_id"
                        class="form-label"
                    >

                        Category

                        <span class="text-danger">
                            *
                        </span>

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


                        @foreach(
                            $categories
                            as $category
                        )

                            <option

                                value="{{
                                    $category->id
                                }}"

                                @selected(

                                    old(
                                        'category_id',
                                        $childcategory
                                            ->category_id
                                        ?? ''
                                    )

                                    ==

                                    $category->id

                                )
                            >

                                {{
                                    $category->name
                                }}

                            </option>

                        @endforeach


                    </select>


                    @error('category_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                </div>



                {{-- Sub Category --}}
                <div class="mb-3">


                    <label
                        for="sub_category_id"
                        class="form-label"
                    >

                        Sub Category

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <select

                        name="sub_category_id"

                        id="sub_category_id"

                        class="
                            form-select
                            @error('sub_category_id')
                                is-invalid
                            @enderror
                        "

                        required
                    >


                        <option value="">

                            Select Sub Category

                        </option>


                        @foreach(
                            $subcategories
                            as $subcategory
                        )

                            <option

                                value="{{
                                    $subcategory->id
                                }}"

                                data-category="{{
                                    $subcategory
                                        ->category_id
                                }}"

                                @selected(

                                    old(
                                        'sub_category_id',
                                        $childcategory
                                            ->sub_category_id
                                        ?? ''
                                    )

                                    ==

                                    $subcategory->id

                                )
                            >

                                {{
                                    $subcategory->name
                                }}

                            </option>

                        @endforeach


                    </select>


                    @error('sub_category_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                </div>



                {{-- Name --}}
                <div class="mb-3">


                    <label
                        for="name"
                        class="form-label"
                    >

                        Child Category Name

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <input

                        type="text"

                        name="name"

                        id="name"

                        class="
                            form-control
                            @error('name')
                                is-invalid
                            @enderror
                        "

                        value="{{
                            old(
                                'name',
                                $childcategory->name
                                ?? ''
                            )
                        }}"

                        placeholder="Example: Kids School Backpack"

                        required
                    >


                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                </div>



                {{-- Description --}}
                <div class="mb-3">


                    <label
                        for="description"
                        class="form-label"
                    >

                        Description

                    </label>


                    <textarea

                        name="description"

                        id="description"

                        rows="6"

                        class="form-control"

                    >{{ old(
                        'description',
                        $childcategory->description
                        ?? ''
                    ) }}</textarea>


                </div>


            </div>


        </div>


    </div>



    <div class="col-lg-4">


        {{-- Image --}}
        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Child Category Image

                </h3>

            </div>


            <div class="card-body">


                <div class="text-center mb-3">


                    <img

                        id="imagePreview"

                        src="{{
                            !empty(
                                $childcategory?->image
                            )

                            ? asset(
                                $childcategory->image
                            )

                            : ''
                        }}"

                        class="
                            img-fluid
                            rounded
                            border

                            {{
                                empty(
                                    $childcategory?->image
                                )
                                ? 'd-none'
                                : ''
                            }}
                        "

                        style="
                            max-height:220px;
                            object-fit:cover;
                        "
                    >


                </div>


                <input

                    type="file"

                    name="image"

                    id="image"

                    accept=".jpg,.jpeg,.png,.webp"

                    class="form-control"
                >


                <div class="form-text">

                    JPG, PNG, WebP. Max 3MB.

                </div>


            </div>


        </div>



        {{-- Publishing --}}
        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Publishing

                </h3>

            </div>


            <div class="card-body">


                <div class="mb-3">


                    <label
                        for="sort_order"
                        class="form-label"
                    >

                        Sort Order

                    </label>


                    <input

                        type="number"

                        name="sort_order"

                        id="sort_order"

                        min="0"

                        value="{{
                            old(
                                'sort_order',
                                $childcategory->sort_order
                                ?? 0
                            )
                        }}"

                        class="form-control"
                    >


                </div>



                <input
                    type="hidden"
                    name="status"
                    value="0"
                >


                <div
                    class="
                        form-check
                        form-switch
                        mb-3
                    "
                >


                    <input

                        type="checkbox"

                        name="status"

                        id="status"

                        value="1"

                        class="form-check-input"

                        @checked(
                            (bool) old(
                                'status',
                                $childcategory->status
                                ?? true
                            )
                        )
                    >


                    <label
                        for="status"
                        class="form-check-label"
                    >

                        Active

                    </label>


                </div>



                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >

                    <i
                        class="
                            bi
                            bi-check-circle
                            me-1
                        "
                    ></i>


                    {{
                        $editing
                        ? 'Update Child Category'
                        : 'Save Child Category'
                    }}

                </button>


            </div>


        </div>


    </div>


</div>



@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Category → Sub Category Filter
        |--------------------------------------------------------------------------
        */

        const category =
            document.getElementById(
                'category_id'
            );


        const subcategory =
            document.getElementById(
                'sub_category_id'
            );


        const originalOptions =

            Array.from(
                subcategory.options
            )

            .map(
                option =>
                    option.cloneNode(true)
            );


        function filterSubCategories() {

            const categoryId =
                category.value;


            const selected =
                subcategory.value;


            subcategory.innerHTML = '';


            originalOptions.forEach(
                function (option) {


                    if (
                        !option.value
                        ||
                        option.dataset.category
                        === categoryId
                    ) {

                        subcategory.appendChild(
                            option.cloneNode(true)
                        );

                    }

                }
            );


            const selectedOption =
                Array.from(
                    subcategory.options
                )
                .find(
                    option =>
                        option.value === selected
                );


            if (selectedOption) {

                subcategory.value =
                    selected;

            }

        }


        category.addEventListener(
            'change',
            function () {

                subcategory.value = '';

                filterSubCategories();

            }
        );


        filterSubCategories();



        /*
        |--------------------------------------------------------------------------
        | Image Preview
        |--------------------------------------------------------------------------
        */

        const image =
            document.getElementById(
                'image'
            );


        const preview =
            document.getElementById(
                'imagePreview'
            );


        image.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];


                if (!file) {

                    return;

                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        preview.src =
                            event.target.result;

                        preview.classList
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
);

</script>

@endpush