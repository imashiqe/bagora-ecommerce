@extends('backend.master')

@section(
    'title',
    'Edit Color - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Edit Color

        </h1>

        <small class="text-secondary">

            {{ $color->name }}

        </small>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.colors.index'
                )
            }}"

            class="
                btn
                btn-outline-secondary
            "
        >

            <i
                class="
                    bi
                    bi-arrow-left
                    me-1
                "
            ></i>

            Back

        </a>

    </div>

</div>

@endsection



@section('content')


<form

    action="{{
        route(
            'admin.colors.update',
            $color
        )
    }}"

    method="POST"
>

    @csrf

    @method('PUT')


    @include(
        'backend.colors._form',
        [
            'color' => $color
        ]
    )


</form>


@endsection