@extends('backend.master')


@section(
    'title',
    'Edit Child Category - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Edit Child Category

        </h1>

    </div>

</div>

@endsection


@section('content')


<form

    action="{{
        route(
            'admin.childcategories.update',
            $childcategory
        )
    }}"

    method="POST"

    enctype="multipart/form-data"
>

    @csrf

    @method('PUT')


    @include(
        'backend.childcategories._form',
        [
            'childcategory' =>
                $childcategory
        ]
    )


</form>


@endsection