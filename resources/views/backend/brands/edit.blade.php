@extends('backend.master')

@section('title', 'Edit Brand - Bagora')

@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Edit Brand
        </h1>

        <small class="text-secondary">
            {{ $brand->name }}
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
    action="{{ route('admin.brands.update', $brand) }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf
    @method('PUT')

    @include('backend.brands._form', [
        'brand' => $brand
    ])

</form>

@endsection