@extends('backend.master')

@section('title', 'Create Blog Category')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h1 class="h3 mb-0">
                Create Blog Category
            </h1>
        </div>

        <a
            href="{{ route('admin.blog-categories.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>


    <form
        action="{{ route('admin.blog-categories.store') }}"
        method="POST"
    >

        @csrf

        @include('backend.blog-categories._form')

    </form>

</div>

@endsection