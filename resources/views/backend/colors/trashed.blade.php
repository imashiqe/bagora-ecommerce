@extends('backend.master')

@section(
    'title',
    'Trashed Colors - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Colors

        </h1>

        <small class="text-secondary">

            Restore or permanently delete colors

        </small>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.colors.index'
                )
            }}"

            class="
                btn
                btn-outline-secondary
            "
        >

            <i
                class="
                    bi
                    bi-arrow-left
                    me-1
                "
            ></i>

            Colors

        </a>

    </div>

</div>

@endsection



@section('content')


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
                            Color
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            HEX Code
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
                        $colors
                        as $color
                    )


                        <tr>


                            <td>

                                <div

                                    class="
                                        rounded-circle
                                        border
                                    "

                                    style="
                                        width:42px;
                                        height:42px;
                                        background-color:
                                        {{ $color->hex_code }};
                                    "
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

                                {{
                                    optional(
                                        $color->deleted_at
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


                                    <form

                                        action="{{
                                            route(
                                                'admin.colors.restore',
                                                $color->id
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


                                    <form

                                        action="{{
                                            route(
                                                'admin.colors.force-delete',
                                                $color->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this color?'
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


    @if($colors->hasPages())

        <div class="card-footer">

            {{ $colors->links() }}

        </div>

    @endif


</div>


@endsection