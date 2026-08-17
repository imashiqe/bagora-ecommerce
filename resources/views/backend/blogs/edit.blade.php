@extends('backend.master')

@section('title', 'Edit Blog')

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
            Edit Blog
        </h1>


        <a
            href="{{ route('admin.blogs.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>


    <form
        action="{{ route(
            'admin.blogs.update',
            $blog
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')

        @include('backend.blogs._form')

    </form>

</div>

@endsection