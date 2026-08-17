@extends('backend.master')

@section('title', 'Blogs')

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
            Blogs
        </h1>


        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.blogs.trashed') }}"
                class="btn btn-outline-danger"
            >
                <i class="bi bi-trash"></i>
                Trash
            </a>


            <a
                href="{{ route('admin.blogs.create') }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-circle"></i>
                Add Blog
            </a>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card">

        <div class="card-header">

            <form
                method="GET"
                action="{{ route('admin.blogs.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search blog..."
                        >

                    </div>


                    <div class="col-md-3">

                        <select
                            name="category_id"
                            class="form-select"
                        >

                            <option value="">
                                All Categories
                            </option>


                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        request('category_id')
                                        == $category->id
                                    )
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-2">

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="1"
                                @selected(request('status') === '1')
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                @selected(request('status') === '0')
                            >
                                Inactive
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3">

                        <button
                            class="btn btn-primary"
                        >
                            Filter
                        </button>


                        <a
                            href="{{ route('admin.blogs.index') }}"
                            class="btn btn-secondary"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="
                        table
                        table-hover
                        align-middle
                        mb-0
                    "
                >

                    <thead>

                        <tr>

                            <th width="80">
                                Image
                            </th>

                            <th>
                                Blog
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Publish
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="170">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($blogs as $blog)

                            <tr>

                                <td>

                                    @if($blog->thumbnail)

                                        <img
                                            src="{{ asset($blog->thumbnail) }}"
                                            width="60"
                                            height="45"
                                            style="object-fit:cover;"
                                            class="rounded border"
                                            alt=""
                                        >

                                    @else

                                        <span class="text-muted">
                                            No image
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <strong>
                                        {{ $blog->title }}
                                    </strong>


                                    <div class="small text-muted">

                                        {{ $blog->author_name ?: '—' }}

                                        @if($blog->featured)

                                            <span
                                                class="badge text-bg-warning ms-1"
                                            >
                                                Featured
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                <td>

                                    {{ $blog->category?->name ?? '—' }}

                                </td>


                                <td>

                                    @if($blog->publish_date)

                                        {{ $blog->publish_date->format('d M Y') }}

                                    @else

                                        —

                                    @endif


                                    @if($blog->publish_time)

                                        <div class="small text-muted">

                                            {{ date(
                                                'h:i A',
                                                strtotime(
                                                    $blog->publish_time
                                                )
                                            ) }}

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    @if($blog->status)

                                        <span class="badge text-bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge text-bg-secondary">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.blogs.edit',
                                            $blog
                                        ) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.blogs.destroy',
                                            $blog
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="
                                            return confirm(
                                                'Move this blog to trash?'
                                            )
                                        "
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >
                                    No blogs found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($blogs->hasPages())

            <div class="card-footer">

                {{ $blogs->links() }}

            </div>

        @endif

    </div>

</div>

@endsection