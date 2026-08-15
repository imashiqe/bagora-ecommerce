@extends('backend.master')

@section(
    'title',
    'Add Size - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Add Size

        </h1>

        <small class="text-secondary">

            Create a product variant size

        </small>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.sizes.index'
                )
            }}"

            class="
                btn
                btn-outline-secondary
            "
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back

        </a>

    </div>

</div>

@endsection



@section('content')


<form

    action="{{
        route(
            'admin.sizes.store'
        )
    }}"

    method="POST"
>

    @csrf


    @include(
        'backend.sizes._form',
        [
            'size' => null
        ]
    )


</form>


@endsection