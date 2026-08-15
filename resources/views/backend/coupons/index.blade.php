@extends('backend.master')


@section(
    'title',
    'Coupons - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Coupons

        </h1>


        <small class="text-secondary">

            Manage discount coupons

        </small>

    </div>


    <div class="col-auto d-flex gap-2">

        <a
            href="{{ route('admin.coupons.trashed') }}"

            class="btn btn-outline-danger"
        >

            <i class="bi bi-trash me-1"></i>

            Trashed

        </a>


        <a
            href="{{ route('admin.coupons.create') }}"

            class="btn btn-primary"
        >

            <i class="bi bi-plus-circle me-1"></i>

            Add Coupon

        </a>

    </div>

</div>

@endsection



@section('content')


<div class="card">


    <div
        class="
            card-header
            d-flex
            justify-content-between
            align-items-center
        "
    >

        <h3 class="card-title mb-0">

            Coupon List

        </h3>


        <span class="badge text-bg-secondary">

            Total:
            {{ $coupons->total() }}

        </span>

    </div>



    {{-- Search --}}
    <div class="card-body border-bottom">

        <form
            action="{{ route('admin.coupons.index') }}"

            method="GET"
        >

            <div class="row g-2">


                <div class="col-md-6">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-search"></i>

                        </span>


                        <input
                            type="text"

                            name="search"

                            value="{{ request('search') }}"

                            class="form-control"

                            placeholder="Search coupon name or code..."
                        >

                    </div>

                </div>


                <div class="col-auto">

                    <button
                        type="submit"

                        class="btn btn-primary"
                    >

                        Search

                    </button>

                </div>


                @if(request()->filled('search'))

                    <div class="col-auto">

                        <a
                            href="{{ route('admin.coupons.index') }}"

                            class="btn btn-outline-secondary"
                        >

                            Clear

                        </a>

                    </div>

                @endif

            </div>

        </form>

    </div>



    <div class="card-body p-0">

        <div class="table-responsive">

            <table
                class="
                    table
                    table-hover
                    align-middle
                    mb-0
                "
            >

                <thead>

                    <tr>

                        <th>
                            Coupon
                        </th>

                        <th>
                            Discount
                        </th>

                        <th>
                            Minimum
                        </th>

                        <th>
                            Usage
                        </th>

                        <th>
                            Validity
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($coupons as $coupon)

                        <tr>


                            <td>

                                <strong>

                                    {{ $coupon->name }}

                                </strong>


                                <div class="mt-1">

                                    <code>

                                        {{ $coupon->code }}

                                    </code>

                                </div>

                            </td>



                            <td>

                                @if(
                                    $coupon->type
                                    ===
                                    'percentage'
                                )

                                    <strong>

                                        {{ number_format(
                                            (float) $coupon->value,
                                            2
                                        ) }}%

                                    </strong>


                                    @if($coupon->max_discount_amount)

                                        <div class="small text-secondary">

                                            Max ৳{{
                                                number_format(
                                                    (float)
                                                    $coupon
                                                        ->max_discount_amount,
                                                    2
                                                )
                                            }}

                                        </div>

                                    @endif

                                @else

                                    <strong>

                                        ৳{{
                                            number_format(
                                                (float)
                                                $coupon->value,
                                                2
                                            )
                                        }}

                                    </strong>

                                @endif

                            </td>



                            <td>

                                ৳{{
                                    number_format(
                                        (float)
                                        $coupon->min_order_amount,
                                        2
                                    )
                                }}

                            </td>



                            <td>

                                {{ $coupon->usage_count }}

                                /

                                {{
                                    $coupon->usage_limit
                                        ?? '∞'
                                }}

                            </td>



                            <td>

                                @if($coupon->starts_at)

                                    <div class="small">

                                        From:

                                        {{
                                            $coupon
                                                ->starts_at
                                                ->format(
                                                    'd M Y'
                                                )
                                        }}

                                    </div>

                                @endif


                                @if($coupon->expires_at)

                                    <div class="small">

                                        Until:

                                        {{
                                            $coupon
                                                ->expires_at
                                                ->format(
                                                    'd M Y'
                                                )
                                        }}

                                    </div>

                                @endif


                                @if(
                                    !$coupon->starts_at
                                    &&
                                    !$coupon->expires_at
                                )

                                    <span class="text-secondary">

                                        No limit

                                    </span>

                                @endif

                            </td>



                            <td>

                                @if($coupon->status)

                                    <span
                                        class="
                                            badge
                                            text-bg-success
                                        "
                                    >

                                        Active

                                    </span>

                                @else

                                    <span
                                        class="
                                            badge
                                            text-bg-secondary
                                        "
                                    >

                                        Inactive

                                    </span>

                                @endif

                            </td>



                            <td class="text-end">

                                <div class="d-inline-flex gap-1">


                                    <a
                                        href="{{
                                            route(
                                                'admin.coupons.edit',
                                                $coupon
                                            )
                                        }}"

                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "
                                    >

                                        <i class="bi bi-pencil-square"></i>

                                    </a>



                                    <form
                                        action="{{
                                            route(
                                                'admin.coupons.destroy',
                                                $coupon
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move coupon to trash?'
                                            );
                                        "
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"

                                            class="
                                                btn
                                                btn-sm
                                                btn-outline-danger
                                            "
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"

                                class="
                                    text-center
                                    py-5
                                "
                            >

                                <i
                                    class="
                                        bi
                                        bi-ticket-perforated
                                        fs-1
                                        text-secondary
                                    "
                                ></i>


                                <h5 class="mt-3">

                                    No coupons found

                                </h5>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    @if($coupons->hasPages())

        <div class="card-footer">

            {{ $coupons->links() }}

        </div>

    @endif

</div>


@endsection