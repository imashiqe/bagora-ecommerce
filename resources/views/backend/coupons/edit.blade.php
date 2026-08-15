@extends('backend.master')


@section(
    'title',
    'Edit Coupon - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Edit Coupon

        </h1>


        <small class="text-secondary">

            {{ $coupon->code }}

        </small>

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


<form
    action="{{
        route(
            'admin.coupons.update',
            $coupon
        )
    }}"

    method="POST"
>

    @csrf

    @method('PUT')


    @include(
        'backend.coupons._form',
        [
            'coupon' => $coupon
        ]
    )


</form>


@endsection