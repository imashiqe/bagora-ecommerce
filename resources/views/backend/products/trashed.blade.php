@extends('backend.master')


@section(
    'title',
    'Trashed Products - Bagora'
)


@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">

            Trashed Products

        </h1>


        <small class="text-secondary">

            Restore or permanently delete products

        </small>

    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.products.index') }}"

            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Products

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
            Product Trash
        </h3>


        <span class="badge text-bg-danger">

            {{ $products->total() }}

            Trashed

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

                        <th>
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
                            Deleted
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
                                        src="{{ asset(
                                            $product->thumbnail
                                        ) }}"

                                        class="
                                            rounded
                                            border
                                        "

                                        style="
                                            width:65px;
                                            height:65px;
                                            object-fit:cover;
                                        "
                                    >

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
                                    "
                                >

                                    SKU:
                                    {{ $product->sku }}

                                </div>


                            </td>



                            {{-- Category --}}
                            <td>


                                {{
                                    $product
                                        ->category
                                        ?->name

                                    ?? 'Missing'
                                }}


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



                            {{-- Deleted --}}
                            <td>


                                {{
                                    optional(
                                        $product->deleted_at
                                    )->format(
                                        'd M Y, h:i A'
                                    )
                                }}


                            </td>



                            {{-- Action --}}
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
                                                'admin.products.restore',
                                                $product->id
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
                                                'admin.products.force-delete',
                                                $product->id
                                            )
                                        }}"

                                        method="POST"

                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this product? Thumbnail and gallery images will also be deleted.'
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
                                colspan="6"

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

                                    Product trash is empty

                                </h5>


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