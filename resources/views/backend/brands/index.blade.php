@extends('backend.master')

@section('title', 'Brands - Bagora')

@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Brands
        </h1>

        <small class="text-secondary">
            Manage product brands
        </small>

    </div>


    <div class="col-auto d-flex gap-2">

        <a
            href="{{ route('admin.brands.trashed') }}"
            class="btn btn-outline-danger"
        >
            <i class="bi bi-trash me-1"></i>
            Trashed
        </a>


        <a
            href="{{ route('admin.brands.create') }}"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-circle me-1"></i>
            Add Brand
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
            Brand List
        </h3>


        <span class="badge text-bg-secondary">

            Total:
            {{ $brands->total() }}

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

                        <th style="width: 90px;">
                            ID
                        </th>

                        <th style="width: 130px;">
                            Logo
                        </th>

                        <th>
                            Brand Name
                        </th>

                        <th>
                            Slug
                        </th>

                        <th style="width: 100px;">
                            Order
                        </th>

                        <th style="width: 110px;">
                            Status
                        </th>

                        <th
                            class="text-end"
                            style="width: 160px;"
                        >
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($brands as $brand)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="text-secondary">
                                    #{{ $brand->id }}
                                </span>

                            </td>


                            {{-- Logo --}}
                            <td>

                                @if($brand->logo)

                                    <div
                                        class="
                                            border
                                            rounded
                                            bg-white
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                            p-1
                                        "
                                        style="
                                            width: 95px;
                                            height: 60px;
                                        "
                                    >

                                        <img
                                            src="{{ asset($brand->logo) }}"
                                            alt="{{ $brand->name }}"
                                            style="
                                                max-width: 100%;
                                                max-height: 100%;
                                                object-fit: contain;
                                            "
                                        >

                                    </div>

                                @else

                                    <div
                                        class="
                                            border
                                            rounded
                                            bg-body-secondary
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                            text-secondary
                                        "
                                        style="
                                            width: 95px;
                                            height: 60px;
                                        "
                                    >

                                        <i class="bi bi-image fs-4"></i>

                                    </div>

                                @endif

                            </td>


                            {{-- Name --}}
                            <td>

                                <strong>
                                    {{ $brand->name }}
                                </strong>


                                @if($brand->description)

                                    <div
                                        class="
                                            small
                                            text-secondary
                                            mt-1
                                        "
                                    >

                                        {{
                                            \Illuminate\Support\Str::limit(
                                                $brand->description,
                                                60
                                            )
                                        }}

                                    </div>

                                @endif

                            </td>


                            {{-- Slug --}}
                            <td>

                                <code>
                                    {{ $brand->slug }}
                                </code>

                            </td>


                            {{-- Sort --}}
                            <td>

                                {{ $brand->sort_order }}

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($brand->status)

                                    <span
                                        class="
                                            badge
                                            text-bg-success
                                        "
                                    >
                                        <i
                                            class="
                                                bi
                                                bi-check-circle
                                                me-1
                                            "
                                        ></i>

                                        Active
                                    </span>

                                @else

                                    <span
                                        class="
                                            badge
                                            text-bg-secondary
                                        "
                                    >
                                        <i
                                            class="
                                                bi
                                                bi-x-circle
                                                me-1
                                            "
                                        ></i>

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
                                                'admin.brands.edit',
                                                $brand
                                            )
                                        }}"
                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "
                                        title="Edit Brand"
                                    >

                                        <i
                                            class="
                                                bi
                                                bi-pencil-square
                                            "
                                        ></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{
                                            route(
                                                'admin.brands.destroy',
                                                $brand
                                            )
                                        }}"
                                        method="POST"
                                        onsubmit="
                                            return confirm(
                                                'Move this brand to trash?'
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

                                <div
                                    class="
                                        text-secondary
                                        mb-3
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-award
                                            fs-1
                                        "
                                    ></i>

                                </div>


                                <h5>
                                    No brands found
                                </h5>


                                <p class="text-secondary">

                                    Add your first product brand.

                                </p>


                                <a
                                    href="{{
                                        route(
                                            'admin.brands.create'
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

                                    Add Brand

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    @if($brands->hasPages())

        <div class="card-footer">

            {{ $brands->links() }}

        </div>

    @endif

</div>

@endsection