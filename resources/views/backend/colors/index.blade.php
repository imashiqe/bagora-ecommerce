@extends('backend.master')

@section(
    'title',
    'Colors - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Colors
        </h1>

        <small class="text-secondary">
            Manage product variant colors
        </small>

    </div>


    <div class="col-auto d-flex gap-2">

        <a
            href="{{
                route(
                    'admin.colors.trashed'
                )
            }}"
            class="btn btn-outline-danger"
        >

            <i class="bi bi-trash me-1"></i>

            Trashed

        </a>


        <a
            href="{{
                route(
                    'admin.colors.create'
                )
            }}"
            class="btn btn-primary"
        >

            <i
                class="
                    bi
                    bi-plus-circle
                    me-1
                "
            ></i>

            Add Color

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

            Color List

        </h3>


        <span class="badge text-bg-secondary">

            Total:
            {{ $colors->total() }}

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

                        <th style="width:80px;">
                            ID
                        </th>

                        <th style="width:100px;">
                            Color
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            HEX Code
                        </th>

                        <th>
                            Slug
                        </th>

                        <th style="width:90px;">
                            Order
                        </th>

                        <th style="width:110px;">
                            Status
                        </th>

                        <th
                            class="text-end"
                            style="width:150px;"
                        >
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse(
                        $colors
                        as $color
                    )


                        <tr>


                            <td>

                                #{{ $color->id }}

                            </td>


                            {{-- Swatch --}}
                            <td>

                                <div

                                    class="
                                        rounded-circle
                                        border
                                        shadow-sm
                                    "

                                    style="
                                        width:42px;
                                        height:42px;
                                        background-color:
                                        {{ $color->hex_code }};
                                    "

                                    title="{{
                                        $color->hex_code
                                    }}"
                                ></div>

                            </td>


                            <td>

                                <strong>

                                    {{ $color->name }}

                                </strong>

                            </td>


                            <td>

                                <code>

                                    {{ $color->hex_code }}

                                </code>

                            </td>


                            <td>

                                <code>

                                    {{ $color->slug }}

                                </code>

                            </td>


                            <td>

                                {{ $color->sort_order }}

                            </td>


                            <td>

                                @if($color->status)

                                    <span
                                        class="
                                            badge
                                            text-bg-success
                                        "
                                    >

                                        Active

                                    </span>

                                @else

                                    <span
                                        class="
                                            badge
                                            text-bg-secondary
                                        "
                                    >

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            <td class="text-end">

                                <div
                                    class="
                                        d-inline-flex
                                        gap-1
                                    "
                                >

                                    <a

                                        href="{{
                                            route(
                                                'admin.colors.edit',
                                                $color
                                            )
                                        }}"

                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "
                                    >

                                        <i
                                            class="
                                                bi
                                                bi-pencil-square
                                            "
                                        ></i>

                                    </a>


                                    <form

                                        action="{{
                                            route(
                                                'admin.colors.destroy',
                                                $color
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move this color to trash?'
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

                                            <i
                                                class="
                                                    bi
                                                    bi-trash
                                                "
                                            ></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="8"
                                class="
                                    text-center
                                    py-5
                                "
                            >

                                <i
                                    class="
                                        bi
                                        bi-palette
                                        fs-1
                                        text-secondary
                                    "
                                ></i>


                                <h5 class="mt-3">

                                    No colors found

                                </h5>


                                <a

                                    href="{{
                                        route(
                                            'admin.colors.create'
                                        )
                                    }}"

                                    class="
                                        btn
                                        btn-primary
                                        mt-2
                                    "
                                >

                                    Add Color

                                </a>

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>


    @if($colors->hasPages())

        <div class="card-footer">

            {{ $colors->links() }}

        </div>

    @endif


</div>


@endsection