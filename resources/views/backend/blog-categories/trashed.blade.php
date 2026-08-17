@extends('backend.master')

@section('title', 'Trashed Blog Categories')

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
            Trashed Blog Categories
        </h1>


        <a
            href="{{ route(
                'admin.blog-categories.index'
            ) }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card">

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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Deleted</th>
                            <th width="230">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    {{ $category->id }}
                                </td>


                                <td>
                                    {{ $category->name }}
                                </td>


                                <td>
                                    {{ $category->deleted_at }}
                                </td>


                                <td>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.blog-categories.restore',
                                            $category->id
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="btn btn-sm btn-success"
                                        >
                                            Restore
                                        </button>

                                    </form>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.blog-categories.force-delete',
                                            $category->id
                                        ) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Permanently delete this category?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-sm btn-danger"
                                        >
                                            Delete Forever
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center py-4"
                                >
                                    Trash is empty.
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