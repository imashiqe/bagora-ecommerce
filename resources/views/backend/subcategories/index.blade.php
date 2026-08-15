@extends('backend.master')


@section(
    'title',
    'Sub Categories - Bagora'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Sub Categories

        </h1>


        <small class="text-secondary">

            Manage Bagora Sub Categories

        </small>

    </div>


    <div class="col-auto d-flex gap-2">


        <a

            href="{{
                route(
                    'admin.subcategories.trashed'
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
                    'admin.subcategories.create'
                )
            }}"

            class="
                btn
                btn-primary
            "
        >

            <i
                class="
                    bi
                    bi-plus-circle
                    me-1
                "
            ></i>

            Add Sub Category

        </a>


    </div>


</div>

@endsection



@section('content')


<div class="card">


    <div class="card-header">

        <h3 class="card-title mb-0">

            Sub Category List

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
                            Sub Category
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Slug
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

                                        alt="{{
                                            $subcategory->name
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

                                <span
                                    class="
                                        badge
                                        text-bg-light
                                        border
                                    "
                                >

                                    {{
                                        $subcategory
                                            ->category
                                            ?->name

                                        ?? 'No Category'
                                    }}

                                </span>

                            </td>



                            <td>

                                <code>

                                    {{
                                        $subcategory->slug
                                    }}

                                </code>

                            </td>



                            <td>

                                {{
                                    $subcategory->sort_order
                                }}

                            </td>



                            <td>


                                @if(
                                    $subcategory->status
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
                                                'admin.subcategories.edit',
                                                $subcategory
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
                                                'admin.subcategories.destroy',
                                                $subcategory
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move this Sub Category to trash?'
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
                                colspan="7"
                                class="
                                    text-center
                                    py-5
                                    text-secondary
                                "
                            >

                                No Sub Categories found.

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