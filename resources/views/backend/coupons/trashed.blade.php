@extends('backend.master')


@section(
    'title',
    'Trashed Coupons - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Coupons

        </h1>

    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.coupons.index') }}"

            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Coupons

        </a>

    </div>

</div>

@endsection



@section('content')


<div class="card">


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
                            Deleted
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


                                <div>

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

                                    {{ $coupon->value }}%

                                @else

                                    ৳{{ $coupon->value }}

                                @endif

                            </td>



                            <td>

                                {{
                                    optional(
                                        $coupon->deleted_at
                                    )->format(
                                        'd M Y, h:i A'
                                    )
                                }}

                            </td>



                            <td class="text-end">

                                <div class="d-inline-flex gap-2">


                                    <form
                                        action="{{
                                            route(
                                                'admin.coupons.restore',
                                                $coupon->id
                                            )
                                        }}"

                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')


                                        <button
                                            type="submit"

                                            class="
                                                btn
                                                btn-sm
                                                btn-success
                                            "
                                        >

                                            <i
                                                class="
                                                    bi
                                                    bi-arrow-counterclockwise
                                                    me-1
                                                "
                                            ></i>

                                            Restore

                                        </button>

                                    </form>



                                    <form
                                        action="{{
                                            route(
                                                'admin.coupons.force-delete',
                                                $coupon->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this coupon?'
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
                                                btn-danger
                                            "
                                        >

                                            Delete Forever

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="4"

                                class="
                                    text-center
                                    py-5
                                    text-secondary
                                "
                            >

                                Coupon trash is empty.

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