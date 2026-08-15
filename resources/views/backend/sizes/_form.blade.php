@php

    $editing =
        isset($size)
        && $size;

@endphp


<div class="row">


    {{-- LEFT --}}
    <div class="col-lg-8">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Size Information

                </h3>

            </div>


            <div class="card-body">


                {{-- Name --}}
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >

                        Size Name

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
                                $size->name ?? ''
                            )
                        }}"

                        class="
                            form-control

                            @error('name')
                                is-invalid
                            @enderror
                        "

                        placeholder="Example: Large"

                        required
                    >


                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <div class="form-text">

                        Example:
                        Small, Medium, Large, XL, 15 Inch

                    </div>

                </div>



                {{-- Size Code --}}
                <div class="mb-3">

                    <label
                        for="code"
                        class="form-label"
                    >

                        Size Code

                    </label>


                    <input

                        type="text"

                        name="code"

                        id="code"

                        value="{{
                            old(
                                'code',
                                $size->code ?? ''
                            )
                        }}"

                        class="
                            form-control

                            @error('code')
                                is-invalid
                            @enderror
                        "

                        placeholder="Example: L"
                    >


                    @error('code')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <div class="form-text">

                        Optional.

                        Example:
                        S, M, L, XL, XXL

                    </div>

                </div>


            </div>


        </div>


    </div>



    {{-- RIGHT --}}
    <div class="col-lg-4">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Publishing

                </h3>

            </div>


            <div class="card-body">


                {{-- Sort Order --}}
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
                                $size->sort_order ?? 0
                            )
                        }}"

                        class="
                            form-control

                            @error('sort_order')
                                is-invalid
                            @enderror
                        "
                    >


                    @error('sort_order')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <div class="form-text">

                        Lower number appears first.

                    </div>

                </div>



                {{-- Hidden Status --}}
                <input
                    type="hidden"
                    name="status"
                    value="0"
                >


                {{-- Status --}}
                <div
                    class="
                        form-check
                        form-switch
                        mb-4
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
                                $size->status ?? true
                            )
                        )
                    >


                    <label
                        for="status"
                        class="form-check-label"
                    >

                        Active Size

                    </label>

                </div>



                {{-- Save --}}
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
                        ? 'Update Size'
                        : 'Save Size'
                    }}

                </button>



                {{-- Cancel --}}
                <a

                    href="{{
                        route(
                            'admin.sizes.index'
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