@extends('backend.master')


@section(
    'title',
    'Add Banner - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Add Banner
        </h1>

    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.banners.index') }}"

            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Banners

        </a>

    </div>

</div>

@endsection



@section('content')


<form
    action="{{ route('admin.banners.store') }}"

    method="POST"

    enctype="multipart/form-data"
>

    @csrf


    @include(
        'backend.banners._form',
        [
            'banner' => null
        ]
    )


</form>


@endsection