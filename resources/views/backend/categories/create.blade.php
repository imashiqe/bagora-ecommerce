@extends('backend.master')


@section(
    'title',
    'Add Category - Bagora'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Add Category

        </h1>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.categories.index'
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
            'admin.categories.store'
        )
    }}"

    method="POST"

    enctype="multipart/form-data"
>

    @csrf


    @include(
        'backend.categories._form',
        [
            'category' => null
        ]
    )


</form>


@endsection