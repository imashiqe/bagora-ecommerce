@extends('backend.master')


@section(
    'title',
    'Add Coupon - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Add Coupon

        </h1>


        <small class="text-secondary">

            Create discount coupon

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
    action="{{ route('admin.coupons.store') }}"

    method="POST"
>

    @csrf


    @include(
        'backend.coupons._form',
        [
            'coupon' => null
        ]
    )


</form>


@endsection