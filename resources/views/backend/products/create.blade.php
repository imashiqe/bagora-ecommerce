@extends('backend.master')


@section(
    'title',
    'Add Product - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Add Product
        </h1>

        <small class="text-secondary">
            Create a new Bagora product
        </small>

    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.products.index') }}"

            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Products

        </a>

    </div>

</div>

@endsection



@section('content')


<form
    action="{{ route('admin.products.store') }}"

    method="POST"

    enctype="multipart/form-data"
>

    @csrf


    @include(
        'backend.products._form',
        [
            'product' => null
        ]
    )


</form>


@endsection