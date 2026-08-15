@extends('backend.master')


@section(
    'title',
    'Trashed Child Categories'
)


@section('page-header')

<div class="row align-items-center">


    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Child Categories

        </h1>

    </div>


    <div class="col-auto">

        <a

            href="{{
                route(
                    'admin.childcategories.index'
                )
            }}"

            class="
                btn
                btn-outline-secondary
            "
        >

            Back

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

                        <th>Name</th>

                        <th>Category</th>

                        <th>Sub Category</th>

                        <th>Deleted</th>

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

                                    ?? 'Missing'
                                }}

                            </td>


                            <td>

                                {{
                                    $childcategory
                                        ->subCategory
                                        ?->name

                                    ?? 'Missing'
                                }}

                            </td>


                            <td>

                                {{
                                    optional(
                                        $childcategory
                                            ->deleted_at
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
                                                'admin.childcategories.restore',
                                                $childcategory->id
                                            )
                                        }}"

                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')


                                        <button
                                            class="
                                                btn
                                                btn-sm
                                                btn-success
                                            "
                                        >

                                            Restore

                                        </button>


                                    </form>


                                    <form

                                        action="{{
                                            route(
                                                'admin.childcategories.force-delete',
                                                $childcategory->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Delete permanently?'
                                            )
                                        "
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            class="
                                                btn
                                                btn-sm
                                                btn-danger
                                            "
                                        >

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


</div>


@endsection