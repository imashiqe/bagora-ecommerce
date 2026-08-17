@extends('backend.master')

@section('title', 'Trashed Blogs')

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
            Trashed Blogs
        </h1>


        <a
            href="{{ route('admin.blogs.index') }}"
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


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
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

                            <th>
                                Blog
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Deleted
                            </th>

                            <th width="250">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($blogs as $blog)

                            <tr>

                                <td>
                                    {{ $blog->title }}
                                </td>


                                <td>
                                    {{ $blog->category?->name ?? '—' }}
                                </td>


                                <td>
                                    {{ $blog->deleted_at?->format(
                                        'd M Y h:i A'
                                    ) }}
                                </td>


                                <td>

                                    <form
                                        action="{{ route(
                                            'admin.blogs.restore',
                                            $blog->id
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-success"
                                        >
                                            Restore
                                        </button>

                                    </form>


                                    <form
                                        action="{{ route(
                                            'admin.blogs.force-delete',
                                            $blog->id
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="
                                            return confirm(
                                                'Delete permanently?'
                                            )
                                        "
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
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
                                    class="text-center py-5"
                                >
                                    Trash is empty.
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