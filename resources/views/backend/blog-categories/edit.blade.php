@extends('backend.master')

@section('title', 'Edit Blog Category')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h1 class="h3 mb-0">
            Edit Blog Category
        </h1>

        <a
            href="{{ route('admin.blog-categories.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>


    <form
        action="{{ route(
            'admin.blog-categories.update',
            $blogCategory
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        @include('backend.blog-categories._form')

    </form>

</div>

@endsection