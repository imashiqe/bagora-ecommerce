@php
    $editing = isset($brand) && $brand;
@endphp


<div class="row">

    {{-- LEFT SIDE --}}
    <div class="col-lg-8">

        <div class="card mb-4">

            <div class="card-header">
                <h3 class="card-title mb-0">
                    Brand Information
                </h3>
            </div>

            <div class="card-body">

                {{-- Brand Name --}}
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Brand Name

                        <span class="text-danger">*</span>
                    </label>


                    <input
                        type="text"
                        name="name"
                        id="name"

                        value="{{
                            old(
                                'name',
                                $brand->name ?? ''
                            )
                        }}"

                        class="
                            form-control

                            @error('name')
                                is-invalid
                            @enderror
                        "

                        placeholder="Example: Bagora"

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

                        placeholder="Write a short description about this brand..."
                    >{{ old(
                        'description',
                        $brand->description ?? ''
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



    {{-- RIGHT SIDE --}}
    <div class="col-lg-4">

        {{-- Brand Logo --}}
        <div class="card mb-4">

            <div class="card-header">
                <h3 class="card-title mb-0">
                    Brand Logo
                </h3>
            </div>


            <div class="card-body">

                {{-- Existing / Preview Logo --}}
                <div class="text-center mb-3">

                    <div
                        id="logoPreviewWrapper"

                        class="
                            border
                            rounded
                            bg-white
                            p-3
                            d-flex
                            align-items-center
                            justify-content-center

                            {{
                                empty($brand?->logo)
                                ? 'd-none'
                                : ''
                            }}
                        "

                        style="
                            min-height: 170px;
                        "
                    >

                        <img
                            id="logoPreview"

                            src="{{
                                !empty($brand?->logo)
                                ? asset($brand->logo)
                                : ''
                            }}"

                            alt="Brand Logo Preview"

                            style="
                                max-width: 100%;
                                max-height: 150px;
                                object-fit: contain;
                            "
                        >

                    </div>

                </div>



                {{-- Logo Input --}}
                <div class="mb-2">

                    <input
                        type="file"
                        name="logo"
                        id="logo"

                        accept=".jpg,.jpeg,.png,.webp"

                        class="
                            form-control

                            @error('logo')
                                is-invalid
                            @enderror
                        "
                    >


                    @error('logo')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="form-text">

                    Recommended:
                    transparent PNG or WebP.

                    Maximum 3MB.

                </div>


                @if($editing && $brand->logo)

                    <div class="mt-3">

                        <small class="text-secondary">

                            Current logo will remain unless you upload a new one.

                        </small>

                    </div>

                @endif

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
                                $brand->sort_order ?? 0
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

                        Lower number will appear first.

                    </div>

                </div>



                {{-- Status Hidden Value --}}
                <input
                    type="hidden"
                    name="status"
                    value="0"
                >


                {{-- Status --}}
                <div class="form-check form-switch mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"

                        name="status"
                        id="status"

                        value="1"

                        @checked(
                            (bool) old(
                                'status',
                                $brand->status ?? true
                            )
                        )
                    >


                    <label
                        class="form-check-label"
                        for="status"
                    >
                        Active Brand
                    </label>

                </div>



                {{-- Submit --}}
                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >

                    <i class="bi bi-check-circle me-1"></i>


                    {{
                        $editing
                        ? 'Update Brand'
                        : 'Save Brand'
                    }}

                </button>



                {{-- Cancel --}}
                <a
                    href="{{ route('admin.brands.index') }}"

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

        const logoInput =
            document.getElementById('logo');

        const logoPreview =
            document.getElementById('logoPreview');

        const logoPreviewWrapper =
            document.getElementById(
                'logoPreviewWrapper'
            );


        if (
            !logoInput ||
            !logoPreview ||
            !logoPreviewWrapper
        ) {
            return;
        }


        logoInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];


                if (!file) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Basic browser-side image check
                |--------------------------------------------------------------------------
                */

                if (
                    !file.type.startsWith(
                        'image/'
                    )
                ) {

                    alert(
                        'Please select a valid image file.'
                    );

                    this.value = '';

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Preview
                |--------------------------------------------------------------------------
                */

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        logoPreview.src =
                            event.target.result;

                        logoPreviewWrapper
                            .classList
                            .remove('d-none');

                    };


                reader.readAsDataURL(file);

            }

        );

    }
);

</script>

@endpush