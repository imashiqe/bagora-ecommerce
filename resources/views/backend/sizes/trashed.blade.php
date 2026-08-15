@extends('backend.master')

@section(
    'title',
    'Trashed Sizes - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Sizes

        </h1>

        <small class="text-secondary">

            Restore or permanently delete sizes

        </small>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.sizes.index'
                )
            }}"

            class="
                btn
                btn-outline-secondary
            "
        >

            <i class="bi bi-arrow-left me-1"></i>

            Sizes

        </a>

    </div>

</div>

@endsection



@section('content')


<div class="card">


    <div
        class="
            card-header
            d-flex
            align-items-center
            justify-content-between
        "
    >

        <h3 class="card-title mb-0">

            Trash

        </h3>


        <span class="badge text-bg-danger">

            {{ $sizes->total() }} Trashed

        </span>

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

                        <th>
                            Size
                        </th>

                        <th>
                            Code
                        </th>

                        <th>
                            Slug
                        </th>

                        <th>
                            Deleted At
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse(
                        $sizes
                        as $size
                    )


                        <tr>


                            <td>

                                <strong>

                                    {{ $size->name }}

                                </strong>

                            </td>


                            <td>

                                @if($size->code)

                                    <span
                                        class="
                                            badge
                                            text-bg-light
                                            border
                                        "
                                    >

                                        {{ $size->code }}

                                    </span>

                                @else

                                    —

                                @endif

                            </td>


                            <td>

                                <code>

                                    {{ $size->slug }}

                                </code>

                            </td>


                            <td>

                                {{
                                    optional(
                                        $size->deleted_at
                                    )->format(
                                        'd M Y, h:i A'
                                    )
                                }}

                            </td>


                            <td class="text-end">


                                <div
                                    class="
                                        d-inline-flex
                                        gap-2
                                    "
                                >


                                    {{-- Restore --}}
                                    <form

                                        action="{{
                                            route(
                                                'admin.sizes.restore',
                                                $size->id
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

                                            <i
                                                class="
                                                    bi
                                                    bi-arrow-counterclockwise
                                                    me-1
                                                "
                                            ></i>

                                            Restore

                                        </button>

                                    </form>



                                    {{-- Delete Forever --}}
                                    <form

                                        action="{{
                                            route(
                                                'admin.sizes.force-delete',
                                                $size->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this size?'
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

                                            <i
                                                class="
                                                    bi
                                                    bi-trash3
                                                    me-1
                                                "
                                            ></i>

                                            Delete Forever

                                        </button>

                                    </form>


                                </div>


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="5"
                                class="
                                    text-center
                                    py-5
                                    text-secondary
                                "
                            >

                                <i
                                    class="
                                        bi
                                        bi-trash
                                        fs-1
                                    "
                                ></i>


                                <h5 class="mt-3">

                                    Trash is empty

                                </h5>

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>


    @if($sizes->hasPages())

        <div class="card-footer">

            {{ $sizes->links() }}

        </div>

    @endif


</div>


@endsection