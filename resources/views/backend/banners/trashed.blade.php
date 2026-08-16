@extends('backend.master')


@section(
    'title',
    'Trashed Banners - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Banners

        </h1>

    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.banners.index') }}"

            class="btn btn-outline-secondary"
        >

            Banners

        </a>

    </div>

</div>

@endsection



@section('content')


<div class="card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>
                            Image
                        </th>

                        <th>
                            Deleted
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($banners as $banner)

                        <tr>


                            <td>

                                <img
                                    src="{{ asset($banner->image) }}"

                                    style="
                                        width:220px;
                                        height:90px;
                                        object-fit:cover;
                                    "

                                    class="rounded border"
                                >

                            </td>


                            <td>

                                {{
                                    optional(
                                        $banner->deleted_at
                                    )->format(
                                        'd M Y, h:i A'
                                    )
                                }}

                            </td>


                            <td class="text-end">

                                <div class="d-inline-flex gap-2">


                                    <form
                                        action="{{
                                            route(
                                                'admin.banners.restore',
                                                $banner->id
                                            )
                                        }}"

                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')


                                        <button
                                            type="submit"

                                            class="
                                                btn
                                                btn-sm
                                                btn-success
                                            "
                                        >

                                            Restore

                                        </button>

                                    </form>



                                    <form
                                        action="{{
                                            route(
                                                'admin.banners.force-delete',
                                                $banner->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Delete this banner forever?'
                                            );
                                        "
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"

                                            class="
                                                btn
                                                btn-sm
                                                btn-danger
                                            "
                                        >

                                            Delete Forever

                                        </button>

                                    </form>


                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="3"

                                class="
                                    text-center
                                    py-5
                                "
                            >

                                Trash is empty.

                            </td>

                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>

    </div>


    @if($banners->hasPages())

        <div class="card-footer">

            {{ $banners->links() }}

        </div>

    @endif


</div>


@endsection