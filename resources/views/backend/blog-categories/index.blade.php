@extends('backend.master')

@section('title', 'Blog Categories')

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
            Blog Categories
        </h1>


        <div>

            <a
                href="{{ route(
                    'admin.blog-categories.trashed'
                ) }}"
                class="btn btn-outline-danger"
            >
                Trash
            </a>


            <a
                href="{{ route(
                    'admin.blog-categories.create'
                ) }}"
                class="btn btn-primary"
            >
                Add Category
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
                action="{{ route(
                    'admin.blog-categories.index'
                ) }}"
            >

                <div class="row g-2">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Search category..."
                        >

                    </div>


                    <div class="col-auto">

                        <button
                            class="btn btn-primary"
                            type="submit"
                        >
                            Search
                        </button>

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
                        table-striped
                        mb-0
                        align-middle
                    "
                >

                    <thead>

                        <tr>
                            <th width="70">ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="100">Order</th>
                            <th width="100">Status</th>
                            <th width="180">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    {{ $category->id }}
                                </td>


                                <td>
                                    <strong>
                                        {{ $category->name }}
                                    </strong>
                                </td>


                                <td>
                                    {{ $category->slug }}
                                </td>


                                <td>
                                    {{ $category->sort_order }}
                                </td>


                                <td>

                                    @if($category->status)

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
                                            'admin.blog-categories.edit',
                                            $category
                                        ) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.blog-categories.destroy',
                                            $category
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Move this category to trash?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
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
                                    class="text-center py-4"
                                >
                                    No blog categories found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($categories->hasPages())

            <div class="card-footer">

                {{ $categories->links() }}

            </div>

        @endif

    </div>

</div>

@endsection