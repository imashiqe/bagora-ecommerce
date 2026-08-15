@extends('backend.master')


@section(
    'title',
    'Products - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Products
        </h1>


        <small class="text-secondary">
            Manage Bagora products
        </small>

    </div>


    <div class="col-auto d-flex gap-2">

        <a
            href="{{ route('admin.products.trashed') }}"

            class="btn btn-outline-danger"
        >

            <i class="bi bi-trash me-1"></i>

            Trashed

        </a>


        <a
            href="{{ route('admin.products.create') }}"

            class="btn btn-primary"
        >

            <i class="bi bi-plus-circle me-1"></i>

            Add Product

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
            justify-content-between
            align-items-center
        "
    >

        <h3 class="card-title mb-0">
            Product List
        </h3>


        <span class="badge text-bg-secondary">

            Total:
            {{ $products->total() }}

        </span>

    </div>


    {{-- ========================================================= --}}
{{-- PRODUCT SEARCH --}}
{{-- ========================================================= --}}

<div class="card-body border-bottom">

    <form
        action="{{ route('admin.products.index') }}"
        method="GET"
    >

        <div class="row g-2 align-items-center">


            {{-- Search Input --}}
            <div class="col-md-8 col-lg-6">

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>


                    <input
                        type="text"

                        name="search"

                        value="{{ request('search') }}"

                        class="form-control"

                        placeholder="Search product, SKU, model, category or brand..."

                        autocomplete="off"
                    >

                </div>

            </div>



            {{-- Search Button --}}
            <div class="col-auto">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-search me-1"></i>

                    Search

                </button>

            </div>



            {{-- Clear Button --}}
            @if(request()->filled('search'))

                <div class="col-auto">

                    <a
                        href="{{ route('admin.products.index') }}"

                        class="btn btn-outline-secondary"
                    >

                        <i class="bi bi-x-circle me-1"></i>

                        Clear

                    </a>

                </div>

            @endif


        </div>


        {{-- Search Result Text --}}
        @if(request()->filled('search'))

            <div class="mt-2 small text-secondary">

                Search results for:

                <strong>
                    "{{ request('search') }}"
                </strong>

                —

                {{ $products->total() }}

                product(s) found.

            </div>

        @endif

    </form>

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

                        <th style="width:90px;">
                            Image
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Brand
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Flags
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


                    @forelse($products as $product)


                        <tr>


                            {{-- Thumbnail --}}
                            <td>


                                @if($product->thumbnail)

                                    <img
                                        src="{{ asset($product->thumbnail) }}"

                                        alt="{{ $product->title }}"

                                        class="
                                            rounded
                                            border
                                        "

                                        style="
                                            width:70px;
                                            height:70px;
                                            object-fit:cover;
                                        "
                                    >

                                @else

                                    <div
                                        class="
                                            border
                                            rounded
                                            bg-body-secondary
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                        "

                                        style="
                                            width:70px;
                                            height:70px;
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



                            {{-- Product --}}
                            <td>


                                <strong>
                                    {{ $product->title }}
                                </strong>


                                <div
                                    class="
                                        small
                                        text-secondary
                                        mt-1
                                    "
                                >

                                    SKU:
                                    {{ $product->sku }}

                                </div>


                                @if($product->model_no)

                                    <div
                                        class="
                                            small
                                            text-secondary
                                        "
                                    >

                                        Model:
                                        {{ $product->model_no }}

                                    </div>

                                @endif


                            </td>



                            {{-- Category --}}
                            <td>


                                <div>

                                    <strong>

                                        {{
                                            $product
                                                ->category
                                                ?->name

                                            ?? '-'
                                        }}

                                    </strong>

                                </div>


                                @if(
                                    $product
                                        ->subCategory
                                )

                                    <div class="small text-secondary">

                                        {{
                                            $product
                                                ->subCategory
                                                ->name
                                        }}

                                    </div>

                                @endif


                                @if(
                                    $product
                                        ->childCategory
                                )

                                    <div class="small text-secondary">

                                        →

                                        {{
                                            $product
                                                ->childCategory
                                                ->name
                                        }}

                                    </div>

                                @endif


                            </td>



                            {{-- Brand --}}
                            <td>

                                {{
                                    $product
                                        ->brand
                                        ?->name

                                    ?? 'No Brand'
                                }}

                            </td>



                            {{-- Price --}}
                            <td>


                                @if(
                                    $product->sale_price
                                    !== null
                                )

                                    <div>

                                        <strong
                                            class="text-danger"
                                        >

                                            ৳{{
                                                number_format(
                                                    (float)
                                                    $product
                                                        ->sale_price,
                                                    2
                                                )
                                            }}

                                        </strong>

                                    </div>


                                    <small
                                        class="
                                            text-secondary
                                            text-decoration-line-through
                                        "
                                    >

                                        ৳{{
                                            number_format(
                                                (float)
                                                $product
                                                    ->regular_price,
                                                2
                                            )
                                        }}

                                    </small>

                                @else

                                    <strong>

                                        ৳{{
                                            number_format(
                                                (float)
                                                $product
                                                    ->regular_price,
                                                2
                                            )
                                        }}

                                    </strong>

                                @endif


                            </td>



                            {{-- Flags --}}
                            <td>


                                <div
                                    class="
                                        d-flex
                                        flex-wrap
                                        gap-1
                                    "
                                >


                                    @if($product->featured)

                                        <span
                                            class="
                                                badge
                                                text-bg-primary
                                            "
                                        >
                                            Featured
                                        </span>

                                    @endif


                                    @if($product->best_seller)

                                        <span
                                            class="
                                                badge
                                                text-bg-warning
                                            "
                                        >
                                            Best Seller
                                        </span>

                                    @endif


                                    @if($product->new_arrival)

                                        <span
                                            class="
                                                badge
                                                text-bg-info
                                            "
                                        >
                                            New
                                        </span>

                                    @endif


                                    @if(
                                        !$product->featured
                                        &&
                                        !$product->best_seller
                                        &&
                                        !$product->new_arrival
                                    )

                                        <span class="text-secondary">
                                            —
                                        </span>

                                    @endif


                                </div>


                            </td>



                            {{-- Status --}}
                            <td>


                                @if($product->status)

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


                                    <a
                                        href="{{
                                            route(
                                                'admin.products.edit',
                                                $product
                                            )
                                        }}"

                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "

                                        title="Edit"
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
                                                'admin.products.destroy',
                                                $product
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Move this product to trash?'
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

                                            title="Trash"
                                        >

                                            <i class="bi bi-trash"></i>

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
                                        bi-box-seam
                                        fs-1
                                        text-secondary
                                    "
                                ></i>


                                <h5 class="mt-3">

                                    No products found

                                </h5>


                                <a
                                    href="{{
                                        route(
                                            'admin.products.create'
                                        )
                                    }}"

                                    class="
                                        btn
                                        btn-primary
                                        mt-2
                                    "
                                >

                                    Add Product

                                </a>


                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>



    @if($products->hasPages())

        <div class="card-footer">

            {{ $products->links() }}

        </div>

    @endif


</div>


@endsection