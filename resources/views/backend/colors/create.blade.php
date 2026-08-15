@extends('backend.master')

@section(
    'title',
    'Add Color - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Add Color

        </h1>

        <small class="text-secondary">

            Create a product variant color

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
            'admin.colors.store'
        )
    }}"

    method="POST"
>

    @csrf


    @include(
        'backend.colors._form',
        [
            'color' => null
        ]
    )


</form>


@endsection