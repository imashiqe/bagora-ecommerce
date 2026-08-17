@extends('backend.master')

@section('title', 'Create Blog')

@section('content')

<div class="container-fluid">

    <div
        class="
            d-flex
            justify-content-between
            align-items-center
            mb-3
        "
    >

        <h1 class="h3 mb-0">
            Create Blog
        </h1>


        <a
            href="{{ route('admin.blogs.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>


    <form
        action="{{ route('admin.blogs.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        @include('backend.blogs._form')

    </form>

</div>

@endsection