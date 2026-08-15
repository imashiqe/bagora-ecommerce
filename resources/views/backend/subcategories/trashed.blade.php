@extends('backend.master')


@section(
    'title',
    'Trashed Sub Categories - Bagora'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Sub Categories

        </h1>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.subcategories.index'
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

            Sub Categories

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
                            Image
                        </th>

                        <th>
                            Sub Category
                        </th>

                        <th>
                            Category
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


                    @forelse(
                        $subcategories
                        as $subcategory
                    )


                        <tr>


                            <td>


                                @if(
                                    $subcategory->image
                                )


                                    <img

                                        src="{{
                                            asset(
                                                $subcategory->image
                                            )
                                        }}"

                                        class="
                                            rounded
                                            border
                                        "

                                        style="
                                            width:55px;
                                            height:55px;
                                            object-fit:cover;
                                        "
                                    >


                                @endif


                            </td>



                            <td>

                                <strong>

                                    {{
                                        $subcategory->name
                                    }}

                                </strong>

                            </td>



                            <td>

                                {{
                                    $subcategory
                                        ->category
                                        ?->name

                                    ?? 'Parent Missing'
                                }}

                            </td>



                            <td>

                                {{

                                    optional(
                                        $subcategory
                                            ->deleted_at
                                    )
                                    ->format(
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
                                                'admin.subcategories.restore',
                                                $subcategory->id
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
                                                'admin.subcategories.force-delete',
                                                $subcategory->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this Sub Category?'
                                            )
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

                                Trash is empty.

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>



    @if(
        $subcategories->hasPages()
    )

        <div class="card-footer">

            {{
                $subcategories->links()
            }}

        </div>

    @endif


</div>


@endsection