@extends('backend.master')

@section(
    'title',
    'Sizes - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Sizes

        </h1>

        <small class="text-secondary">

            Manage product variant sizes

        </small>

    </div>


    <div class="col-auto d-flex gap-2">

        <a

            href="{{
                route(
                    'admin.sizes.trashed'
                )
            }}"

            class="
                btn
                btn-outline-danger
            "
        >

            <i class="bi bi-trash me-1"></i>

            Trashed

        </a>


        <a

            href="{{
                route(
                    'admin.sizes.create'
                )
            }}"

            class="
                btn
                btn-primary
            "
        >

            <i class="bi bi-plus-circle me-1"></i>

            Add Size

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

            Size List

        </h3>


        <span class="badge text-bg-secondary">

            Total:
            {{ $sizes->total() }}

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

                        <th>
                            Size
                        </th>

                        <th style="width:130px;">
                            Code
                        </th>

                        <th>
                            Slug
                        </th>

                        <th style="width:100px;">
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
                        $sizes
                        as $size
                    )


                        <tr>


                            <td>

                                <span class="text-secondary">

                                    #{{ $size->id }}

                                </span>

                            </td>


                            {{-- Size Name --}}
                            <td>

                                <strong>

                                    {{ $size->name }}

                                </strong>

                            </td>


                            {{-- Code --}}
                            <td>

                                @if($size->code)

                                    <span
                                        class="
                                            badge
                                            text-bg-light
                                            border
                                            fs-6
                                        "
                                    >

                                        {{ $size->code }}

                                    </span>

                                @else

                                    <span class="text-secondary">

                                        —

                                    </span>

                                @endif

                            </td>


                            {{-- Slug --}}
                            <td>

                                <code>

                                    {{ $size->slug }}

                                </code>

                            </td>


                            {{-- Sort --}}
                            <td>

                                {{ $size->sort_order }}

                            </td>


                            {{-- Status --}}
                            <td>


                                @if($size->status)

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


                            {{-- Actions --}}
                            <td class="text-end">


                                <div
                                    class="
                                        d-inline-flex
                                        gap-1
                                    "
                                >


                                    {{-- Edit --}}
                                    <a

                                        href="{{
                                            route(
                                                'admin.sizes.edit',
                                                $size
                                            )
                                        }}"

                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "

                                        title="Edit Size"
                                    >

                                        <i
                                            class="
                                                bi
                                                bi-pencil-square
                                            "
                                        ></i>

                                    </a>



                                    {{-- Trash --}}
                                    <form

                                        action="{{
                                            route(
                                                'admin.sizes.destroy',
                                                $size
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move this size to trash?'
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

                                            title="Move to Trash"
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
                                colspan="7"
                                class="
                                    text-center
                                    py-5
                                "
                            >

                                <div class="text-secondary">

                                    <i
                                        class="
                                            bi
                                            bi-rulers
                                            fs-1
                                        "
                                    ></i>

                                </div>


                                <h5 class="mt-3">

                                    No sizes found

                                </h5>


                                <a

                                    href="{{
                                        route(
                                            'admin.sizes.create'
                                        )
                                    }}"

                                    class="
                                        btn
                                        btn-primary
                                        mt-2
                                    "
                                >

                                    Add Size

                                </a>

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