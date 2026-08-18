@extends('frontend.master')

@section('title', 'Shopping Cart')

@section('content')

@php
    $items = $items ?? collect();
    $subtotal = $subtotal ?? 0;
@endphp
{{-- ========================================================= --}}
{{-- BREADCRUMB --}}
{{-- ========================================================= --}}

<nav class="py-6 lg:py-10">

    <div class="custom-container">

        <div class="flex items-center gap-3 text-sm">

            <a
                href="{{ route('home') }}"
                class="
                    text-gray-secondary
                    hover:text-primary-main
                "
            >
                Home
            </a>

            <span>•</span>

            <span class="text-gray-primary">
                Cart
            </span>

        </div>

    </div>

</nav>



<main>

    <section class="pb-12 lg:pb-20">

        <div class="custom-container">


            {{-- Success --}}
            @if(session('success'))

                <div
                    class="
                        mb-5
                        rounded-lg
                        border
                        border-green-200
                        bg-green-50
                        px-4
                        py-3
                        text-sm
                        text-green-700
                    "
                >
                    {{ session('success') }}
                </div>

            @endif



            <div
                class="
                    mb-7
                    flex
                    items-center
                    justify-between
                    gap-4
                "
            >

                <div>

                    <h1
                        class="
                            text-2xl
                            font-bold
                            text-gray-primary
                            md:text-3xl
                        "
                    >
                        Shopping Cart
                    </h1>

                    <p class="mt-1 text-sm text-gray-secondary">
                        {{ $items->sum('quantity') }}
                        item(s)
                    </p>

                </div>


                @if($items->isNotEmpty())

                    <form
                        action="{{ route('cart.clear') }}"
                        method="POST"
                    >

                        @csrf
                        @method('DELETE')


                        <button
                            type="submit"
                            onclick="
                                return confirm(
                                    'Clear cart?'
                                )
                            "
                            class="
                                text-sm
                                font-medium
                                text-error-dark
                                underline
                            "
                        >
                            Clear Cart
                        </button>

                    </form>

                @endif

            </div>



            {{-- Empty --}}
            @if($items->isEmpty())

                <div
                    class="
                        flex
                        min-h-[380px]
                        flex-col
                        items-center
                        justify-center
                        rounded-2xl
                        border
                        border-dashed
                        border-gray-300
                        bg-gray-50
                        px-6
                        text-center
                    "
                >

                    <h2
                        class="
                            text-xl
                            font-bold
                            text-gray-primary
                        "
                    >
                        Your cart is empty
                    </h2>


                    <p
                        class="
                            mt-2
                            text-sm
                            text-gray-secondary
                        "
                    >
                        Add some products first.
                    </p>


                    <a
                        href="{{ route('shop') }}"
                        class="
                            mt-5
                            rounded-lg
                            bg-primary-main
                            px-6
                            py-3
                            text-sm
                            font-semibold
                            text-success-light
                        "
                    >
                        Continue Shopping
                    </a>

                </div>


            @else


                <div
                    class="
                        grid
                        grid-cols-1
                        gap-8
                        lg:grid-cols-12
                    "
                >


                    {{-- ITEMS --}}
                    <div class="lg:col-span-8">

                        <div class="space-y-4">


                            @foreach($items as $item)

                                @php
                                    $product =
                                        $item['product'];
                                @endphp


                                <article
                                    class="
                                        flex
                                        gap-4
                                        rounded-xl
                                        border
                                        border-gray-300
                                        bg-white
                                        p-4
                                    "
                                >


                                    {{-- Image --}}
                                    <a
                                        href="{{
                                            route(
                                                'product.details',
                                                [
                                                    'slug' =>
                                                        $product->slug
                                                ]
                                            )
                                        }}"
                                        class="
                                            size-24
                                            shrink-0
                                            overflow-hidden
                                            rounded-lg
                                            bg-gray-100
                                            sm:size-32
                                        "
                                    >

                                        @if($product->thumbnail)

                                            <img
                                                src="{{
                                                    asset(
                                                        $product->thumbnail
                                                    )
                                                }}"
                                                alt="{{
                                                    $product->title
                                                }}"
                                                class="
                                                    h-full
                                                    w-full
                                                    object-cover
                                                "
                                            >

                                        @endif

                                    </a>



                                    <div
                                        class="
                                            min-w-0
                                            flex-1
                                        "
                                    >


                                        <div
                                            class="
                                                flex
                                                justify-between
                                                gap-4
                                            "
                                        >

                                            <div>

                                                <a
                                                    href="{{
                                                        route(
                                                            'product.details',
                                                            [
                                                                'slug' =>
                                                                    $product->slug
                                                            ]
                                                        )
                                                    }}"
                                                    class="
                                                        line-clamp-2
                                                        font-semibold
                                                        text-gray-primary
                                                        hover:text-primary-main
                                                    "
                                                >
                                                    {{ $product->title }}
                                                </a>


                                                @if($product->model_no)

                                                    <p
                                                        class="
                                                            mt-1
                                                            text-xs
                                                            text-gray-tertiary
                                                        "
                                                    >
                                                        Model:
                                                        {{ $product->model_no }}
                                                    </p>

                                                @endif

                                            </div>



                                            {{-- Remove --}}
                                            <form
                                                action="{{
                                                    route(
                                                        'cart.remove',
                                                        [
                                                            'product' =>
                                                                $product->id
                                                        ]
                                                    )
                                                }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="
                                                        text-sm
                                                        text-error-dark
                                                    "
                                                >
                                                    Remove
                                                </button>

                                            </form>

                                        </div>



                                        <div
                                            class="
                                                mt-4
                                                flex
                                                flex-wrap
                                                items-center
                                                justify-between
                                                gap-4
                                            "
                                        >


                                            {{-- Quantity Update --}}
                                            <form
                                                action="{{
                                                    route(
                                                        'cart.update',
                                                        [
                                                            'product' =>
                                                                $product->id
                                                        ]
                                                    )
                                                }}"
                                                method="POST"
                                                class="
                                                    flex
                                                    items-center
                                                    gap-2
                                                "
                                            >

                                                @csrf
                                                @method('PATCH')


                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    min="1"
                                                    max="99"
                                                    value="{{
                                                        $item['quantity']
                                                    }}"
                                                    class="
                                                        h-10
                                                        w-20
                                                        rounded-lg
                                                        border
                                                        border-gray-300
                                                        px-3
                                                        text-center
                                                    "
                                                >


                                                <button
                                                    type="submit"
                                                    class="
                                                        h-10
                                                        rounded-lg
                                                        border
                                                        border-gray-300
                                                        px-3
                                                        text-xs
                                                        font-semibold
                                                    "
                                                >
                                                    Update
                                                </button>

                                            </form>



                                            {{-- Price --}}
                                            <div class="text-right">

                                                <p
                                                    class="
                                                        text-sm
                                                        text-gray-secondary
                                                    "
                                                >
                                                    ৳{{
                                                        number_format(
                                                            $item['unit_price'],
                                                            0
                                                        )
                                                    }}
                                                    each
                                                </p>


                                                <p
                                                    class="
                                                        mt-1
                                                        text-lg
                                                        font-bold
                                                        text-gray-primary
                                                    "
                                                >
                                                    ৳{{
                                                        number_format(
                                                            $item['subtotal'],
                                                            0
                                                        )
                                                    }}
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </div>



                    {{-- SUMMARY --}}
                    <aside class="lg:col-span-4">

                        <div
                            class="
                                rounded-2xl
                                border
                                border-gray-300
                                bg-white
                                p-5
                                lg:sticky
                                lg:top-24
                            "
                        >

                            <h2
                                class="
                                    text-xl
                                    font-bold
                                    text-gray-primary
                                "
                            >
                                Order Summary
                            </h2>


                            <div
                                class="
                                    mt-5
                                    border-t
                                    border-gray-200
                                    pt-5
                                "
                            >

                                <div
                                    class="
                                        flex
                                        justify-between
                                        gap-4
                                    "
                                >

                                    <span class="text-gray-secondary">
                                        Subtotal
                                    </span>


                                    <span
                                        class="
                                            font-semibold
                                            text-gray-primary
                                        "
                                    >
                                        ৳{{
                                            number_format(
                                                $subtotal,
                                                0
                                            )
                                        }}
                                    </span>

                                </div>


                                <p
                                    class="
                                        mt-3
                                        text-xs
                                        leading-5
                                        text-gray-tertiary
                                    "
                                >
                                    Delivery charge will be calculated at checkout.
                                </p>

                            </div>


                            <a
                                href="{{ route('checkout') }}"
                                class="
                                    mt-6
                                    flex
                                    h-12
                                    w-full
                                    items-center
                                    justify-center
                                    rounded-lg
                                    bg-primary-main
                                    px-5
                                    text-sm
                                    font-semibold
                                    text-success-light
                                    transition
                                    hover:bg-primary-main-dark
                                    hover:text-white
                                "
                            >
                                Proceed to Checkout
                            </a>


                            <a
                                href="{{ route('shop') }}"
                                class="
                                    mt-3
                                    flex
                                    h-11
                                    w-full
                                    items-center
                                    justify-center
                                    rounded-lg
                                    border
                                    border-gray-300
                                    text-sm
                                    font-semibold
                                    text-gray-primary
                                "
                            >
                                Continue Shopping
                            </a>

                        </div>

                    </aside>

                </div>

            @endif

        </div>

    </section>

</main>

@endsection