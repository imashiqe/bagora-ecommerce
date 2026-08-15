@extends('backend.master')

@section(
    'title',
    'Edit Size - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Edit Size

        </h1>

        <small class="text-secondary">

            {{ $size->name }}

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
            'admin.sizes.update',
            $size
        )
    }}"

    method="POST"
>

    @csrf

    @method('PUT')


    @include(
        'backend.sizes._form',
        [
            'size' => $size
        ]
    )


</form>


@endsection