@php

    $editing =
        isset($subcategory)
        && $subcategory;

@endphp


<div class="row">


    <div class="col-lg-8">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Sub Category Information

                </h3>

            </div>


            <div class="card-body">


                {{-- Parent Category --}}
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
                                        $subcategory->category_id
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



                {{-- Name --}}
                <div class="mb-3">


                    <label
                        for="name"
                        class="form-label"
                    >

                        Sub Category Name

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <input

                        type="text"

                        name="name"

                        id="name"

                        value="{{
                            old(
                                'name',
                                $subcategory->name
                                ?? ''
                            )
                        }}"

                        class="
                            form-control

                            @error('name')
                                is-invalid
                            @enderror
                        "

                        placeholder="
                            Example: School Backpacks
                        "

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

                        class="
                            form-control

                            @error('description')
                                is-invalid
                            @enderror
                        "

                        placeholder="
                            Sub Category description...
                        "
                    >{{ old(
                        'description',
                        $subcategory->description
                        ?? ''
                    ) }}</textarea>


                    @error('description')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                </div>


            </div>


        </div>


    </div>



    <div class="col-lg-4">


        {{-- Image --}}
        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Sub Category Image

                </h3>

            </div>


            <div class="card-body">


                <div class="text-center mb-3">


                    <img

                        id="imagePreview"

                        src="{{
                            !empty(
                                $subcategory?->image
                            )

                            ? asset(
                                $subcategory->image
                            )

                            : ''
                        }}"

                        alt="Preview"

                        class="
                            img-fluid
                            border
                            rounded

                            {{
                                empty(
                                    $subcategory?->image
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

                    accept="
                        .jpg,
                        .jpeg,
                        .png,
                        .webp
                    "

                    class="
                        form-control

                        @error('image')
                            is-invalid
                        @enderror
                    "
                >


                <div class="form-text">

                    JPG, PNG or WebP.

                    Max 3MB.

                </div>


                @error('image')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


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
                                $subcategory->sort_order
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

                        class="
                            form-check-input
                        "

                        @checked(

                            (bool) old(
                                'status',
                                $subcategory->status
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

                    class="
                        btn
                        btn-primary
                        w-100
                    "
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

                        ? 'Update Sub Category'

                        : 'Save Sub Category'

                    }}

                </button>



                <a

                    href="{{
                        route(
                            'admin.subcategories.index'
                        )
                    }}"

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



@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const image =
            document.getElementById(
                'image'
            );


        const preview =
            document.getElementById(
                'imagePreview'
            );


        if (
            !image ||
            !preview
        ) {

            return;

        }


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