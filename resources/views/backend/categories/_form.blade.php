@php

    $editing =
        isset($category)
        && $category;

@endphp


<div class="row">


    <div class="col-lg-8">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Category Information

                </h3>

            </div>


            <div class="card-body">


                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >

                        Category Name

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <input

                        type="text"

                        id="name"

                        name="name"

                        class="
                            form-control

                            @error('name')
                                is-invalid
                            @enderror
                        "

                        value="{{
                            old(
                                'name',
                                $category->name ?? ''
                            )
                        }}"

                        placeholder="Example: Backpacks"

                        required
                    >


                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                <div class="mb-3">


                    <label
                        for="description"
                        class="form-label"
                    >

                        Description

                    </label>


                    <textarea

                        id="description"

                        name="description"

                        rows="6"

                        class="
                            form-control

                            @error('description')
                                is-invalid
                            @enderror
                        "

                        placeholder="Category description..."
                    >{{ old(
                        'description',
                        $category->description ?? ''
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

                    Category Image

                </h3>

            </div>


            <div class="card-body">


                <div class="text-center mb-3">


                    <img

                        id="imagePreview"

                        src="{{
                            !empty(
                                $category?->image
                            )

                            ? asset(
                                $category->image
                            )

                            : ''
                        }}"

                        alt="Preview"

                        class="
                            img-fluid
                            rounded
                            border

                            {{
                                empty(
                                    $category?->image
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

                    id="image"

                    name="image"

                    accept=".jpg,.jpeg,.png,.webp"

                    class="
                        form-control

                        @error('image')
                            is-invalid
                        @enderror
                    "
                >


                <div class="form-text">

                    JPG, PNG, WebP.
                    Maximum 3MB.

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

                        min="0"

                        id="sort_order"

                        name="sort_order"

                        class="form-control"

                        value="{{
                            old(
                                'sort_order',
                                $category->sort_order ?? 0
                            )
                        }}"
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

                        class="form-check-input"

                        id="status"

                        name="status"

                        value="1"

                        @checked(
                            (bool) old(
                                'status',
                                $category->status ?? true
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

                        ? 'Update Category'

                        : 'Save Category'

                    }}

                </button>



                <a

                    href="{{
                        route(
                            'admin.categories.index'
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

        const input =
            document.getElementById(
                'image'
            );


        const preview =
            document.getElementById(
                'imagePreview'
            );


        if (
            !input ||
            !preview
        ) {

            return;

        }


        input.addEventListener(
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