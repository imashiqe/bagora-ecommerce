@extends('backend.master')


@section(
    'title',
    'Add Child Category - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Add Child Category

        </h1>

    </div>

</div>

@endsection


@section('content')


<form

    action="{{
        route(
            'admin.childcategories.store'
        )
    }}"

    method="POST"

    enctype="multipart/form-data"
>

    @csrf


    @include(
        'backend.childcategories._form',
        [
            'childcategory' => null
        ]
    )


</form>


@endsection