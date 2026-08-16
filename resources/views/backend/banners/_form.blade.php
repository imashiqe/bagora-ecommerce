@php

    $editing =
        isset($banner)
        &&
        $banner;

@endphp


<div class="row">


    <div class="col-lg-8">


        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">

                    Banner Image

                </h3>

            </div>


            <div class="card-body">


                {{-- Preview --}}
                <div class="mb-3">


                    <img
                        id="bannerPreview"

                        src="{{
                            $editing
                            &&
                            $banner->image

                                ? asset($banner->image)

                                : ''
                        }}"

                        class="
                            img-fluid
                            rounded
                            border
                            w-100

                            {{
                                !$editing
                                ||
                                !$banner->image
                                    ? 'd-none'
                                    : ''
                            }}
                        "

                        style="
                            max-height:400px;
                            object-fit:cover;
                        "
                    >

                </div>



                <label
                    for="image"
                    class="form-label"
                >

                    Banner Image

                    @if(!$editing)

                        <span class="text-danger">
                            *
                        </span>

                    @endif

                </label>


                <input
                    type="file"

                    name="image"

                    id="image"

                    accept=".jpg,.jpeg,.png,.webp"

                    class="
                        form-control

                        @error('image')
                            is-invalid
                        @enderror
                    "

                    @required(!$editing)
                >


                @error('image')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                <div class="form-text">

                    Recommended:
                    1920 × 740 px or similar wide banner ratio.

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

                        value="{{ old(
                            'sort_order',
                            $editing
                                ? $banner->sort_order
                                : 0
                        ) }}"

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


                <div class="form-check form-switch mb-4">

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
                                    ? $banner->status
                                    : true
                            )
                        )
                    >


                    <label
                        for="status"
                        class="form-check-label"
                    >

                        Active Banner

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

                    {{
                        $editing
                            ? 'Update Banner'
                            : 'Save Banner'
                    }}

                </button>


                <a
                    href="{{ route('admin.banners.index') }}"

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
                'bannerPreview'
            );


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


                        preview.classList.remove(
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