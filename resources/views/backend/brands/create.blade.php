@extends('backend.master')

@section('title', 'Add Brand - Bagora')

@section('page-header')

<div class="row align-items-center">

    <div class="col">
        <h1 class="mb-0 fs-3">
            Add Brand
        </h1>

        <small class="text-secondary">
            Create a new product brand
        </small>
    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.brands.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>

    </div>

</div>

@endsection


@section('content')

<form
    action="{{ route('admin.brands.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @include('backend.brands._form', [
        'brand' => null
    ])

</form>

@endsection