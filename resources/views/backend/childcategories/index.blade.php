@extends('backend.master')


@section(
    'title',
    'Child Categories - Bagora'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Child Categories

        </h1>

    </div>


    <div class="col-auto d-flex gap-2">


        <a

            href="{{
                route(
                    'admin.childcategories.trashed'
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
                    'admin.childcategories.create'
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

            Add Child Category

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

                        <th>Image</th>

                        <th>
                            Child Category
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Sub Category
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


                    @forelse(
                        $childcategories
                        as $childcategory
                    )


                        <tr>


                            <td>


                                @if(
                                    $childcategory->image
                                )


                                    <img

                                        src="{{
                                            asset(
                                                $childcategory->image
                                            )
                                        }}"

                                        style="
                                            width:55px;
                                            height:55px;
                                            object-fit:cover;
                                        "

                                        class="
                                            rounded
                                            border
                                        "
                                    >


                                @endif


                            </td>


                            <td>

                                <strong>

                                    {{
                                        $childcategory
                                            ->name
                                    }}

                                </strong>

                            </td>


                            <td>

                                {{
                                    $childcategory
                                        ->category
                                        ?->name

                                    ?? '-'
                                }}

                            </td>


                            <td>

                                {{
                                    $childcategory
                                        ->subCategory
                                        ?->name

                                    ?? '-'
                                }}

                            </td>


                            <td>


                                @if(
                                    $childcategory->status
                                )

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
                                                'admin.childcategories.edit',
                                                $childcategory
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
                                                'admin.childcategories.destroy',
                                                $childcategory
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move Child Category to trash?'
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
                                colspan="6"
                                class="
                                    text-center
                                    py-5
                                    text-secondary
                                "
                            >

                                No Child Categories found.

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>


    @if(
        $childcategories->hasPages()
    )

        <div class="card-footer">

            {{
                $childcategories->links()
            }}

        </div>

    @endif


</div>


@endsection