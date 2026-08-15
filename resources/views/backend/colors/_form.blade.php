@php

    $editing =
        isset($color)
        && $color;

    $currentHex =
        old(
            'hex_code',
            $color->hex_code ?? '#000000'
        );

@endphp


<div class="row">


    <div class="col-lg-8">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Color Information

                </h3>

            </div>


            <div class="card-body">


                {{-- Color Name --}}
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >

                        Color Name

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
                                $color->name ?? ''
                            )
                        }}"

                        class="
                            form-control

                            @error('name')
                                is-invalid
                            @enderror
                        "

                        placeholder="Example: Midnight Black"

                        required
                    >


                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- Hex Code --}}
                <div class="mb-3">

                    <label
                        for="hex_code"
                        class="form-label"
                    >

                        HEX Color Code

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <div class="input-group">


                        <span
                            class="input-group-text p-1"
                        >

                            <input
                                type="color"
                                id="colorPicker"
                                value="{{ $currentHex }}"
                                style="
                                    width: 45px;
                                    height: 34px;
                                    border: 0;
                                    padding: 0;
                                    cursor: pointer;
                                "
                            >

                        </span>


                        <input

                            type="text"

                            name="hex_code"

                            id="hex_code"

                            value="{{ $currentHex }}"

                            class="
                                form-control

                                @error('hex_code')
                                    is-invalid
                                @enderror
                            "

                            placeholder="#000000"

                            maxlength="7"

                            required
                        >


                        @error('hex_code')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror


                    </div>


                    <div class="form-text">

                        Example:
                        #000000,
                        #FFFFFF,
                        #E63946

                    </div>

                </div>



                {{-- Large Preview --}}
                <div class="mb-3">

                    <label class="form-label">

                        Preview

                    </label>


                    <div

                        id="colorPreview"

                        class="
                            border
                            rounded
                            d-flex
                            align-items-center
                            justify-content-center
                        "

                        style="
                            height: 120px;
                            background-color: {{ $currentHex }};
                        "
                    >

                        <span

                            id="previewCode"

                            class="
                                badge
                                text-bg-light
                                border
                                fs-6
                            "
                        >

                            {{ strtoupper($currentHex) }}

                        </span>

                    </div>

                </div>


            </div>


        </div>


    </div>



    <div class="col-lg-4">


        <div class="card mb-4">


            <div class="card-header">

                <h3 class="card-title mb-0">

                    Publishing

                </h3>

            </div>


            <div class="card-body">


                {{-- Sort --}}
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
                                $color->sort_order ?? 0
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

                        class="form-check-input"

                        name="status"

                        id="status"

                        value="1"

                        @checked(
                            (bool) old(
                                'status',
                                $color->status ?? true
                            )
                        )
                    >


                    <label
                        for="status"
                        class="form-check-label"
                    >

                        Active Color

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
                        ? 'Update Color'
                        : 'Save Color'
                    }}

                </button>



                <a

                    href="{{
                        route(
                            'admin.colors.index'
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

        const picker =
            document.getElementById(
                'colorPicker'
            );

        const hexInput =
            document.getElementById(
                'hex_code'
            );

        const preview =
            document.getElementById(
                'colorPreview'
            );

        const previewCode =
            document.getElementById(
                'previewCode'
            );


        /*
        |--------------------------------------------------------------------------
        | Picker → Text
        |--------------------------------------------------------------------------
        */

        picker.addEventListener(
            'input',
            function () {

                const value =
                    this.value.toUpperCase();


                hexInput.value =
                    value;


                preview.style.backgroundColor =
                    value;


                previewCode.textContent =
                    value;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Text → Picker
        |--------------------------------------------------------------------------
        */

        hexInput.addEventListener(
            'input',
            function () {

                let value =
                    this.value.trim();


                if (
                    value.length === 6
                    &&
                    !value.startsWith('#')
                ) {

                    value =
                        '#'
                        + value;

                }


                const valid =
                    /^#[0-9A-Fa-f]{6}$/
                        .test(value);


                if (valid) {

                    const upper =
                        value.toUpperCase();


                    picker.value =
                        upper;


                    preview.style.backgroundColor =
                        upper;


                    previewCode.textContent =
                        upper;

                }

            }
        );

    }
);

</script>

@endpush