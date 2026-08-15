@extends('backend.master')


@section(
    'title',
    'Trashed Categories - Bagora'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Categories

        </h1>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.categories.index'
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

            Categories

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
                            Name
                        </th>

                        <th>
                            Slug
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
                        $categories
                        as $category
                    )


                        <tr>


                            <td>


                                @if(
                                    $category->image
                                )


                                    <img

                                        src="{{
                                            asset(
                                                $category->image
                                            )
                                        }}"

                                        alt="{{
                                            $category->name
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
                                        $category->name
                                    }}

                                </strong>

                            </td>



                            <td>

                                <code>

                                    {{
                                        $category->slug
                                    }}

                                </code>

                            </td>



                            <td>

                                {{

                                    optional(
                                        $category->deleted_at
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
                                                'admin.categories.restore',
                                                $category->id
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



                                    {{-- Force Delete --}}
                                    <form

                                        action="{{
                                            route(
                                                'admin.categories.force-delete',
                                                $category->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this category?'
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
        $categories->hasPages()
    )

        <div class="card-footer">

            {{
                $categories->links()
            }}

        </div>

    @endif


</div>


@endsection