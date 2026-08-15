@extends('backend.master')

@section('title', 'Trashed Brands - Bagora')

@section('page-header')

<div class="row align-items-center">

    <div class="col">

        <h1 class="mb-0 fs-3">
            Trashed Brands
        </h1>

        <small class="text-secondary">
            Restore or permanently delete brands
        </small>

    </div>


    <div class="col-auto">

        <a
            href="{{ route('admin.brands.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Brands

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

            Trash

        </h3>


        <span class="badge text-bg-danger">

            {{ $brands->total() }}

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

                        <th style="width: 90px;">
                            ID
                        </th>

                        <th style="width: 130px;">
                            Logo
                        </th>

                        <th>
                            Brand
                        </th>

                        <th>
                            Slug
                        </th>

                        <th>
                            Deleted At
                        </th>

                        <th
                            class="text-end"
                            style="width: 300px;"
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

                                #{{ $brand->id }}

                            </td>


                            {{-- Logo --}}
                            <td>

                                @if($brand->logo)

                                    <div
                                        class="
                                            border
                                            rounded
                                            bg-white
                                            p-1
                                            d-flex
                                            justify-content-center
                                            align-items-center
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

                                        <i class="bi bi-image"></i>

                                    </div>

                                @endif

                            </td>


                            {{-- Brand --}}
                            <td>

                                <strong>
                                    {{ $brand->name }}
                                </strong>

                            </td>


                            {{-- Slug --}}
                            <td>

                                <code>
                                    {{ $brand->slug }}
                                </code>

                            </td>


                            {{-- Deleted --}}
                            <td>

                                <span class="text-secondary">

                                    {{
                                        optional(
                                            $brand->deleted_at
                                        )->format(
                                            'd M Y, h:i A'
                                        )
                                    }}

                                </span>

                            </td>


                            {{-- Actions --}}
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
                                                'admin.brands.restore',
                                                $brand->id
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


                                    {{-- Permanent Delete --}}
                                    <form
                                        action="{{
                                            route(
                                                'admin.brands.force-delete',
                                                $brand->id
                                            )
                                        }}"
                                        method="POST"
                                        onsubmit="
                                            return confirm(
                                                'Permanently delete this brand? The logo file will also be deleted. This cannot be undone.'
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
                                "
                            >

                                <div
                                    class="
                                        text-secondary
                                        mb-2
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-trash
                                            fs-1
                                        "
                                    ></i>

                                </div>


                                <h5>
                                    Trash is empty
                                </h5>


                                <a
                                    href="{{
                                        route(
                                            'admin.brands.index'
                                        )
                                    }}"
                                    class="
                                        btn
                                        btn-outline-secondary
                                        mt-2
                                    "
                                >

                                    Back to Brands

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