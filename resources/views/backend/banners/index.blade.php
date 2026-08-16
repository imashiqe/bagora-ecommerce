@extends('backend.master')


@section(
    'title',
    'Banners - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Banners

        </h1>

    </div>


    <div class="col-auto d-flex gap-2">

        <a
            href="{{ route('admin.banners.trashed') }}"

            class="btn btn-outline-danger"
        >

            <i class="bi bi-trash me-1"></i>

            Trashed

        </a>


        <a
            href="{{ route('admin.banners.create') }}"

            class="btn btn-primary"
        >

            <i class="bi bi-plus-circle me-1"></i>

            Add Banner

        </a>

    </div>

</div>

@endsection



@section('content')


<div class="card">


    <div class="card-header">

        <h3 class="card-title mb-0">

            Banner List

        </h3>

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

                        <th style="width:300px;">
                            Image
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Status
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
                                        width:260px;
                                        height:100px;
                                        object-fit:cover;
                                    "

                                    class="
                                        rounded
                                        border
                                    "
                                >

                            </td>


                            <td>

                                {{ $banner->sort_order }}

                            </td>


                            <td>

                                @if($banner->status)

                                    <span class="badge text-bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge text-bg-secondary">

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            <td class="text-end">


                                <div class="d-inline-flex gap-1">


                                    <a
                                        href="{{
                                            route(
                                                'admin.banners.edit',
                                                $banner
                                            )
                                        }}"

                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "
                                    >

                                        <i class="bi bi-pencil-square"></i>

                                    </a>


                                    <form
                                        action="{{
                                            route(
                                                'admin.banners.destroy',
                                                $banner
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move this banner to trash?'
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
                                                btn-outline-danger
                                            "
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>


                                </div>


                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="4"

                                class="
                                    text-center
                                    py-5
                                "
                            >

                                No banners found.

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