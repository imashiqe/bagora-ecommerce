@extends('backend.master')


@section(
    'title',
    'Edit Product - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Edit Product
        </h1>


        <small class="text-secondary">

            {{ $product->title }}

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
    action="{{
        route(
            'admin.products.update',
            $product
        )
    }}"

    method="POST"

    enctype="multipart/form-data"
>

    @csrf

    @method('PUT')


    @include(
        'backend.products._form',
        [
            'product' => $product
        ]
    )


</form>



{{-- ========================================================= --}}
{{-- Separate Gallery Delete Forms --}}
{{-- Avoid nested forms inside Product edit form --}}
{{-- ========================================================= --}}

@foreach($product->images as $image)

    <form
        id="delete-gallery-{{ $image->id }}"

        action="{{
            route(
                'admin.products.gallery.destroy',
                [
                    $product,
                    $image
                ]
            )
        }}"

        method="POST"

        class="d-none"
    >

        @csrf

        @method('DELETE')

    </form>

@endforeach


@endsection