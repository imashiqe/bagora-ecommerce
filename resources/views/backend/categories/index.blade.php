@extends('backend.master')


@section(
    'title',
    'Categories - Bagora'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Categories

        </h1>

        <small class="text-secondary">

            Manage Bagora categories

        </small>

    </div>


    <div class="col-auto d-flex gap-2">


        <a

            href="{{
                route(
                    'admin.categories.trashed'
                )
            }}"

            class="
                btn
                btn-outline-danger
            "
        >

            <i
                class="
                    bi
                    bi-trash
                    me-1
                "
            ></i>

            Trashed

        </a>



        <a

            href="{{
                route(
                    'admin.categories.create'
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

            Add Category

        </a>


    </div>


</div>

@endsection



@section('content')


<div class="card">


    <div class="card-header">

        <h3 class="card-title mb-0">

            Category List

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

                        <th style="width:80px;">
                            Image
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Slug
                        </th>

                        <th style="width:100px;">
                            Order
                        </th>

                        <th style="width:100px;">
                            Status
                        </th>

                        <th
                            style="width:170px;"
                            class="text-end"
                        >
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


                                @else


                                    <div

                                        class="
                                            bg-body-secondary
                                            border
                                            rounded
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                        "

                                        style="
                                            width:55px;
                                            height:55px;
                                        "
                                    >

                                        <i
                                            class="
                                                bi
                                                bi-image
                                                text-secondary
                                            "
                                        ></i>

                                    </div>


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
                                    $category->sort_order
                                }}

                            </td>



                            <td>


                                @if(
                                    $category->status
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
                                                'admin.categories.edit',
                                                $category
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
                                                'admin.categories.destroy',
                                                $category
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move this category to trash?'
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

                                No categories found.

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