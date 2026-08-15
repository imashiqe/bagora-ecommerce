@php

    $editing =
        isset($coupon)
        &&
        $coupon;


    $selectedType = old(
        'type',
        $editing
            ? $coupon->type
            : 'fixed'
    );

@endphp



<div class="row">


    {{-- ========================================================= --}}
    {{-- LEFT --}}
    {{-- ========================================================= --}}

    <div class="col-lg-8">


        {{-- BASIC --}}
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">
                    Coupon Information
                </h3>

            </div>


            <div class="card-body">


                <div class="row">


                    {{-- Name --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >

                                Coupon Name

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"

                                name="name"

                                id="name"

                                value="{{ old(
                                    'name',
                                    $editing
                                        ? $coupon->name
                                        : ''
                                ) }}"

                                class="
                                    form-control

                                    @error('name')
                                        is-invalid
                                    @enderror
                                "

                                placeholder="Example: Eid Sale 10%"

                                required
                            >


                            @error('name')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Code --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="code"
                                class="form-label"
                            >

                                Coupon Code

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"

                                name="code"

                                id="code"

                                value="{{ old(
                                    'code',
                                    $editing
                                        ? $coupon->code
                                        : ''
                                ) }}"

                                class="
                                    form-control
                                    text-uppercase

                                    @error('code')
                                        is-invalid
                                    @enderror
                                "

                                placeholder="Example: EID10"

                                required
                            >


                            @error('code')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror


                            <div class="form-text">

                                Letters, numbers, underscore and hyphen only.

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Description --}}
                <div>

                    <label
                        for="description"
                        class="form-label"
                    >

                        Description

                    </label>


                    <textarea
                        name="description"

                        id="description"

                        rows="4"

                        class="
                            form-control

                            @error('description')
                                is-invalid
                            @enderror
                        "

                        placeholder="Internal coupon description..."
                    >{{ old(
                        'description',
                        $editing
                            ? $coupon->description
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



        {{-- DISCOUNT --}}
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">

                    Discount Rules

                </h3>

            </div>


            <div class="card-body">


                <div class="row">


                    {{-- Type --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="type"
                                class="form-label"
                            >

                                Discount Type

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <select
                                name="type"

                                id="type"

                                class="
                                    form-select

                                    @error('type')
                                        is-invalid
                                    @enderror
                                "

                                required
                            >

                                <option
                                    value="fixed"

                                    @selected(
                                        $selectedType
                                        ===
                                        'fixed'
                                    )
                                >

                                    Fixed Amount

                                </option>


                                <option
                                    value="percentage"

                                    @selected(
                                        $selectedType
                                        ===
                                        'percentage'
                                    )
                                >

                                    Percentage

                                </option>

                            </select>


                            @error('type')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Value --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="value"
                                class="form-label"
                            >

                                Discount Value

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <div class="input-group">

                                <span
                                    class="input-group-text"
                                    id="discountPrefix"
                                >

                                    ৳

                                </span>


                                <input
                                    type="number"

                                    name="value"

                                    id="value"

                                    step="0.01"

                                    min="0.01"

                                    value="{{ old(
                                        'value',
                                        $editing
                                            ? $coupon->value
                                            : ''
                                    ) }}"

                                    class="
                                        form-control

                                        @error('value')
                                            is-invalid
                                        @enderror
                                    "

                                    required
                                >


                                <span
                                    class="
                                        input-group-text
                                        d-none
                                    "

                                    id="discountPercentage"
                                >

                                    %

                                </span>

                            </div>


                            @error('value')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Minimum Order --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="min_order_amount"
                                class="form-label"
                            >

                                Minimum Order Amount

                            </label>


                            <div class="input-group">

                                <span class="input-group-text">

                                    ৳

                                </span>


                                <input
                                    type="number"

                                    name="min_order_amount"

                                    id="min_order_amount"

                                    min="0"

                                    step="0.01"

                                    value="{{ old(
                                        'min_order_amount',
                                        $editing
                                            ? $coupon->min_order_amount
                                            : 0
                                    ) }}"

                                    class="
                                        form-control

                                        @error('min_order_amount')
                                            is-invalid
                                        @enderror
                                    "
                                >

                            </div>


                            @error('min_order_amount')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Maximum Discount --}}
                    <div
                        class="col-md-6"

                        id="maxDiscountWrapper"
                    >

                        <div class="mb-3">

                            <label
                                for="max_discount_amount"
                                class="form-label"
                            >

                                Maximum Discount

                            </label>


                            <div class="input-group">

                                <span class="input-group-text">

                                    ৳

                                </span>


                                <input
                                    type="number"

                                    name="max_discount_amount"

                                    id="max_discount_amount"

                                    min="0"

                                    step="0.01"

                                    value="{{ old(
                                        'max_discount_amount',
                                        $editing
                                            ? $coupon->max_discount_amount
                                            : ''
                                    ) }}"

                                    class="
                                        form-control

                                        @error('max_discount_amount')
                                            is-invalid
                                        @enderror
                                    "
                                >

                            </div>


                            @error('max_discount_amount')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror


                            <div class="form-text">

                                Used for percentage coupons.

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- USAGE --}}
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">

                    Usage Limits

                </h3>

            </div>


            <div class="card-body">


                <div class="row">


                    {{-- Overall Limit --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="usage_limit"
                                class="form-label"
                            >

                                Total Usage Limit

                            </label>


                            <input
                                type="number"

                                name="usage_limit"

                                id="usage_limit"

                                min="1"

                                value="{{ old(
                                    'usage_limit',
                                    $editing
                                        ? $coupon->usage_limit
                                        : ''
                                ) }}"

                                class="
                                    form-control

                                    @error('usage_limit')
                                        is-invalid
                                    @enderror
                                "

                                placeholder="Unlimited"
                            >


                            @error('usage_limit')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror


                            <div class="form-text">

                                Leave blank for unlimited usage.

                            </div>

                        </div>

                    </div>



                    {{-- Per Customer --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="per_customer_limit"
                                class="form-label"
                            >

                                Per Customer Limit

                            </label>


                            <input
                                type="number"

                                name="per_customer_limit"

                                id="per_customer_limit"

                                min="1"

                                value="{{ old(
                                    'per_customer_limit',
                                    $editing
                                        ? $coupon->per_customer_limit
                                        : 1
                                ) }}"

                                class="
                                    form-control

                                    @error('per_customer_limit')
                                        is-invalid
                                    @enderror
                                "
                            >


                            @error('per_customer_limit')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>

                </div>



                @if($editing)

                    <div
                        class="
                            alert
                            alert-light
                            border
                            mb-0
                        "
                    >

                        <strong>
                            Used:
                        </strong>

                        {{ $coupon->usage_count }}

                        @if($coupon->usage_limit)

                            /

                            {{ $coupon->usage_limit }}

                        @else

                            / Unlimited

                        @endif

                    </div>

                @endif

            </div>

        </div>



        {{-- VALIDITY --}}
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">

                    Coupon Validity

                </h3>

            </div>


            <div class="card-body">


                <div class="row">


                    {{-- Start --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="starts_at"
                                class="form-label"
                            >

                                Start Date & Time

                            </label>


                            <input
                                type="datetime-local"

                                name="starts_at"

                                id="starts_at"

                                value="{{ old(
                                    'starts_at',
                                    (
                                        $editing
                                        &&
                                        $coupon->starts_at
                                    )
                                        ? $coupon
                                            ->starts_at
                                            ->format(
                                                'Y-m-d\TH:i'
                                            )
                                        : ''
                                ) }}"

                                class="
                                    form-control

                                    @error('starts_at')
                                        is-invalid
                                    @enderror
                                "
                            >


                            @error('starts_at')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- Expiry --}}
                    <div class="col-md-6">

                        <div class="mb-3">

                            <label
                                for="expires_at"
                                class="form-label"
                            >

                                Expiry Date & Time

                            </label>


                            <input
                                type="datetime-local"

                                name="expires_at"

                                id="expires_at"

                                value="{{ old(
                                    'expires_at',
                                    (
                                        $editing
                                        &&
                                        $coupon->expires_at
                                    )
                                        ? $coupon
                                            ->expires_at
                                            ->format(
                                                'Y-m-d\TH:i'
                                            )
                                        : ''
                                ) }}"

                                class="
                                    form-control

                                    @error('expires_at')
                                        is-invalid
                                    @enderror
                                "
                            >


                            @error('expires_at')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                <div class="form-text">

                    Leave empty if the coupon has no fixed start or expiry time.

                </div>

            </div>

        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- RIGHT --}}
    {{-- ========================================================= --}}

    <div class="col-lg-4">


        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title mb-0">

                    Publishing

                </h3>

            </div>


            <div class="card-body">


                <input
                    type="hidden"

                    name="status"

                    value="0"
                >


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

                        class="form-check-input"

                        @checked(
                            (bool) old(
                                'status',
                                $editing
                                    ? $coupon->status
                                    : true
                            )
                        )
                    >


                    <label
                        for="status"

                        class="form-check-label"
                    >

                        Active Coupon

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

                    <i class="bi bi-check-circle me-1"></i>


                    {{
                        $editing
                            ? 'Update Coupon'
                            : 'Save Coupon'
                    }}

                </button>



                <a
                    href="{{ route('admin.coupons.index') }}"

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

        const type =
            document.getElementById(
                'type'
            );


        const prefix =
            document.getElementById(
                'discountPrefix'
            );


        const percentage =
            document.getElementById(
                'discountPercentage'
            );


        const maxDiscount =
            document.getElementById(
                'maxDiscountWrapper'
            );


        const code =
            document.getElementById(
                'code'
            );


        function updateDiscountType() {

            if (
                type.value ===
                'percentage'
            ) {

                prefix.classList.add(
                    'd-none'
                );


                percentage.classList.remove(
                    'd-none'
                );


                maxDiscount.classList.remove(
                    'd-none'
                );

            } else {

                prefix.classList.remove(
                    'd-none'
                );


                percentage.classList.add(
                    'd-none'
                );


                maxDiscount.classList.add(
                    'd-none'
                );

            }

        }


        type.addEventListener(
            'change',
            updateDiscountType
        );


        updateDiscountType();


        /*
        |--------------------------------------------------------------------------
        | Uppercase Code
        |--------------------------------------------------------------------------
        */

        code.addEventListener(
            'input',
            function () {

                this.value =
                    this.value
                        .toUpperCase()
                        .replace(
                            /\s+/g,
                            '-'
                        );

            }
        );

    }
);

</script>

@endpush