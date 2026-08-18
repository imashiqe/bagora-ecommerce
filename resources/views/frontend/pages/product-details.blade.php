@extends('frontend.master')

@section('title', $product->meta_title ?: $product->title)

@section('content')

@php
    $regularPrice = (float) $product->regular_price;

    $salePrice = $product->sale_price
        ? (float) $product->sale_price
        : null;

    $currentPrice = $salePrice ?: $regularPrice;

    $hasDiscount =
        $salePrice
        &&
        $salePrice < $regularPrice;

    $discountPercent =
        $hasDiscount && $regularPrice > 0
            ? round(
                (($regularPrice - $salePrice) / $regularPrice) * 100
            )
            : 0;

    /*
    |--------------------------------------------------------------------------
    | Build Product Gallery
    |--------------------------------------------------------------------------
    */

    $galleryImages = collect();

    if ($product->thumbnail) {
        $galleryImages->push([
            'image' => $product->thumbnail,
            'alt' => $product->title,
        ]);
    }

    foreach ($product->images as $image) {
        if ($image->image) {
            $galleryImages->push([
                'image' => $image->image,
                'alt' => $image->alt_text ?: $product->title,
            ]);
        }
    }

    $galleryImages = $galleryImages
        ->unique('image')
        ->values();
@endphp


{{-- ========================================================= --}}
{{-- BREADCRUMB --}}
{{-- ========================================================= --}}

<nav class="pt-6 lg:pt-10">

    <div class="custom-container">

        <ul
            class="
                flex
                flex-wrap
                items-center
                gap-3
                text-sm
                font-normal
            "
        >

            <li>
                <a
                    href="{{ route('home') }}"
                    class="
                        text-gray-secondary
                        transition
                        hover:text-primary-main
                    "
                >
                    Home
                </a>
            </li>


            <li class="flex items-center">
                <span class="bg-gray-tertiary inline-block size-1 rounded-full"></span>
            </li>


            @if($product->category)

                <li>
                    <a
                        href="{{ url('/shop?category=' . $product->category->slug) }}"
                        class="
                            text-gray-secondary
                            transition
                            hover:text-primary-main
                        "
                    >
                        {{ $product->category->name }}
                    </a>
                </li>


                <li class="flex items-center">
                    <span class="bg-gray-tertiary inline-block size-1 rounded-full"></span>
                </li>

            @endif


            <li class="text-gray-tertiary">
                {{ $product->title }}
            </li>

        </ul>

    </div>

</nav>



<main>

    {{-- ========================================================= --}}
    {{-- PRODUCT DETAILS --}}
    {{-- ========================================================= --}}

    <section class="py-6 lg:py-12">

        <div class="custom-container">

            <div
                class="
                    flex
                    flex-col
                    gap-8
                    xl:flex-row
                    xl:gap-12
                "
            >


                {{-- ========================================================= --}}
                {{-- LEFT: PRODUCT GALLERY --}}
                {{-- ========================================================= --}}

                <div class="w-full xl:w-1/2">

                    @if($galleryImages->isNotEmpty())

                        <div
                            class="
                                flex
                                flex-col-reverse
                                gap-5
                                md:flex-row
                                xl:gap-6
                            "
                        >

                            {{-- Thumbnail Slider --}}
                            <div class="w-full shrink-0 md:w-20 lg:w-25">

                                <div
                                    class="
                                        swiper
                                        product-thumbs-slider
                                        h-24
                                        md:h-[620px]
                                    "
                                >

                                    <div class="swiper-wrapper">

                                        @foreach($galleryImages as $galleryImage)

                                            <div
                                                class="
                                                    swiper-slide
                                                    cursor-pointer
                                                    overflow-hidden
                                                    rounded-lg
                                                    border
                                                    border-gray-200
                                                    opacity-50
                                                    transition-all
                                                    duration-200
                                                    hover:opacity-100
                                                    [&.swiper-slide-thumb-active]:border-primary-main
                                                    [&.swiper-slide-thumb-active]:opacity-100
                                                "
                                            >

                                                <img
                                                    src="{{ asset($galleryImage['image']) }}"
                                                    alt="{{ $galleryImage['alt'] }}"
                                                    class="
                                                        h-full
                                                        w-full
                                                        object-cover
                                                    "
                                                >

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            </div>


                            {{-- Main Slider --}}
                            <div class="relative min-w-0 flex-1">

                                <div
                                    class="
                                        swiper
                                        product-main-slider
                                        overflow-hidden
                                        rounded-xl
                                        border
                                        border-gray-200
                                        bg-gray-50
                                        md:h-[620px]
                                    "
                                >

                                    <div class="swiper-wrapper">

                                        @foreach($galleryImages as $galleryImage)

                                            <div
                                                class="
                                                    swiper-slide
                                                    flex
                                                    items-center
                                                    justify-center
                                                    overflow-hidden
                                                "
                                            >

                                                <a
                                                    href="{{ asset($galleryImage['image']) }}"
                                                    class="
                                                        glightbox-gallery
                                                        block
                                                        h-full
                                                        w-full
                                                    "
                                                >

                                                    <img
                                                        src="{{ asset($galleryImage['image']) }}"
                                                        alt="{{ $galleryImage['alt'] }}"
                                                        class="
                                                            h-full
                                                            w-full
                                                            bg-white
                                                            object-contain
                                                            transition-transform
                                                            duration-500
                                                            hover:scale-105
                                                        "
                                                    >

                                                </a>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>


                                @if($galleryImages->count() > 1)

                                    <button
                                        type="button"
                                        aria-label="Previous image"
                                        class="
                                            product-main-prev
                                            absolute
                                            top-1/2
                                            left-4
                                            z-10
                                            flex
                                            size-10
                                            -translate-y-1/2
                                            items-center
                                            justify-center
                                            rounded-full
                                            bg-white/90
                                            text-gray-700
                                            shadow
                                            transition-all
                                            duration-300
                                            hover:bg-primary-main
                                            hover:text-success-light
                                            [&.swiper-button-disabled]:pointer-events-none
                                            [&.swiper-button-disabled]:opacity-0
                                        "
                                    >

                                        <svg
                                            class="size-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 19l-7-7 7-7"
                                            ></path>
                                        </svg>

                                    </button>


                                    <button
                                        type="button"
                                        aria-label="Next image"
                                        class="
                                            product-main-next
                                            absolute
                                            top-1/2
                                            right-4
                                            z-10
                                            flex
                                            size-10
                                            -translate-y-1/2
                                            items-center
                                            justify-center
                                            rounded-full
                                            bg-white/90
                                            text-gray-700
                                            shadow
                                            transition-all
                                            duration-300
                                            hover:bg-primary-main
                                            hover:text-success-light
                                            [&.swiper-button-disabled]:pointer-events-none
                                            [&.swiper-button-disabled]:opacity-0
                                        "
                                    >

                                        <svg
                                            class="size-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 5l7 7-7 7"
                                            ></path>
                                        </svg>

                                    </button>

                                @endif

                            </div>

                        </div>

                    @else

                        <div
                            class="
                                flex
                                min-h-[450px]
                                items-center
                                justify-center
                                rounded-xl
                                border
                                border-gray-200
                                bg-gray-50
                                text-gray-tertiary
                            "
                        >
                            No Product Image
                        </div>

                    @endif

                </div>



                {{-- ========================================================= --}}
                {{-- RIGHT: PRODUCT INFORMATION --}}
                {{-- ========================================================= --}}

                <div class="w-full xl:w-1/2">

                    <div
                        class="
                            divide-gray-tertiary/24
                            divide-y
                            divide-dashed
                            rounded-2xl
                            border
                            border-gray-300
                            p-4
                            sm:p-6
                        "
                    >

                        {{-- Main Info --}}
                        <div class="pb-6">

                            <div class="mb-4 flex flex-wrap items-center gap-2">

                                @if($hasDiscount)

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            rounded-md
                                            bg-error-dark
                                            px-3
                                            py-1.5
                                            text-xs
                                            font-semibold
                                            text-white
                                        "
                                    >
                                        {{ $discountPercent }}% OFF
                                    </span>

                                @endif


                                @if($product->best_seller)

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            rounded-md
                                            bg-primary-main
                                            px-3
                                            py-1.5
                                            text-xs
                                            font-semibold
                                            text-success-light
                                        "
                                    >
                                        Best Seller
                                    </span>

                                @endif


                                @if($product->new_arrival)

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            rounded-md
                                            bg-gray-100
                                            px-3
                                            py-1.5
                                            text-xs
                                            font-semibold
                                            text-gray-primary
                                        "
                                    >
                                        New Arrival
                                    </span>

                                @endif

                            </div>


                            <h1
                                class="
                                    text-gray-primary
                                    text-2xl
                                    leading-9
                                    font-bold
                                    md:text-3xl
                                "
                            >
                                {{ $product->title }}
                            </h1>


                            <div
                                class="
                                    mt-4
                                    flex
                                    flex-wrap
                                    items-center
                                    gap-x-5
                                    gap-y-2
                                    text-sm
                                    text-gray-secondary
                                "
                            >

                                @if($product->brand)

                                    <span>
                                        Brand:
                                        <strong class="text-gray-primary">
                                            {{ $product->brand->name }}
                                        </strong>
                                    </span>

                                @endif


                                @if($product->model_no)

                                    <span>
                                        Model:
                                        <strong class="text-gray-primary">
                                            {{ $product->model_no }}
                                        </strong>
                                    </span>

                                @endif


                                @if($product->sku)

                                    <span>
                                        SKU:
                                        <strong class="text-gray-primary">
                                            {{ $product->sku }}
                                        </strong>
                                    </span>

                                @endif

                            </div>


                            @if($product->short_description)

                                <p
                                    class="
                                        mt-5
                                        text-base
                                        leading-7
                                        text-gray-secondary
                                    "
                                >
                                    {{ $product->short_description }}
                                </p>

                            @endif

                        </div>


                        {{-- Price --}}
                        <div class="py-6">

                            <div
                                class="
                                    flex
                                    flex-wrap
                                    items-end
                                    gap-x-3
                                    gap-y-2
                                "
                            >

                                <span
                                    class="
                                        text-primary-main
                                        text-3xl
                                        font-bold
                                        md:text-4xl
                                    "
                                >
                                    ৳{{ number_format($currentPrice, 0) }}
                                </span>


                                @if($hasDiscount)

                                    <span
                                        class="
                                            pb-1
                                            text-lg
                                            text-gray-tertiary
                                            line-through
                                        "
                                    >
                                        ৳{{ number_format($regularPrice, 0) }}
                                    </span>

                                @endif

                            </div>


                            @if($hasDiscount)

                                <p class="mt-2 text-sm text-success-dark-main">
                                    You save ৳{{ number_format($regularPrice - $salePrice, 0) }}
                                </p>

                            @endif

                        </div>


                        {{-- Key Features --}}
                        @if($product->keyFeatures->isNotEmpty())

                            <div class="py-6">

                                <h3
                                    class="
                                        mb-4
                                        text-lg
                                        font-bold
                                        text-gray-primary
                                    "
                                >
                                    Key Features
                                </h3>


                                <ul class="space-y-3">

                                    @foreach($product->keyFeatures as $feature)

                                        <li
                                            class="
                                                flex
                                                items-start
                                                gap-3
                                                text-sm
                                                leading-6
                                                text-gray-secondary
                                            "
                                        >

                                            <span
                                                class="
                                                    mt-1
                                                    flex
                                                    size-5
                                                    shrink-0
                                                    items-center
                                                    justify-center
                                                    rounded-full
                                                    bg-primary-main
                                                    text-success-light
                                                "
                                            >
                                                ✓
                                            </span>

                                            <span>
                                                {{ $feature->feature }}
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        {{-- Category Information --}}
                        <div class="py-6">

                            <div
                                class="
                                    grid
                                    grid-cols-1
                                    gap-4
                                    text-sm
                                    sm:grid-cols-2
                                "
                            >

                                @if($product->category)

                                    <div>
                                        <span class="text-gray-tertiary">
                                            Category
                                        </span>

                                        <div class="mt-1 font-medium text-gray-primary">
                                            {{ $product->category->name }}
                                        </div>
                                    </div>

                                @endif


                                @if($product->subCategory)

                                    <div>
                                        <span class="text-gray-tertiary">
                                            Sub Category
                                        </span>

                                        <div class="mt-1 font-medium text-gray-primary">
                                            {{ $product->subCategory->name }}
                                        </div>
                                    </div>

                                @endif


                                @if($product->childCategory)

                                    <div>
                                        <span class="text-gray-tertiary">
                                            Type
                                        </span>

                                        <div class="mt-1 font-medium text-gray-primary">
                                            {{ $product->childCategory->name }}
                                        </div>
                                    </div>

                                @endif


                                @if($product->brand)

                                    <div>
                                        <span class="text-gray-tertiary">
                                            Brand
                                        </span>

                                        <div class="mt-1 font-medium text-gray-primary">
                                            {{ $product->brand->name }}
                                        </div>
                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- Quantity + Cart / Buy Now --}}
                        <div
                            class="pt-6"
                            data-product-purchase
                        >

                            <div
                                class="
                                    flex
                                    flex-col
                                    gap-4
                                    sm:flex-row
                                "
                            >

                                {{-- Quantity --}}
                                <div
                                    class="
                                        flex
                                        h-12
                                        w-full
                                        items-center
                                        justify-between
                                        overflow-hidden
                                        rounded-lg
                                        border
                                        border-gray-300
                                        sm:w-[150px]
                                    "
                                    data-product-quantity
                                >

                                    <button
                                        type="button"
                                        class="
                                            flex
                                            h-full
                                            w-12
                                            items-center
                                            justify-center
                                            text-xl
                                            text-gray-primary
                                            transition
                                            hover:bg-gray-100
                                        "
                                        data-quantity-minus
                                        aria-label="Decrease quantity"
                                    >
                                        −
                                    </button>


                                    <input
                                        type="number"
                                        value="1"
                                        min="1"
                                        max="99"
                                        inputmode="numeric"
                                        class="
                                            h-full
                                            w-12
                                            border-0
                                            bg-transparent
                                            text-center
                                            text-base
                                            font-semibold
                                            text-gray-primary
                                            outline-none
                                        "
                                        data-quantity-input
                                    >


                                    <button
                                        type="button"
                                        class="
                                            flex
                                            h-full
                                            w-12
                                            items-center
                                            justify-center
                                            text-xl
                                            text-gray-primary
                                            transition
                                            hover:bg-gray-100
                                        "
                                        data-quantity-plus
                                        aria-label="Increase quantity"
                                    >
                                        +
                                    </button>

                                </div>


                                {{-- Add To Cart --}}
                                <form
                                    method="POST"
                                    action="{{ route('cart.add', ['product' => $product->id]) }}"
                                    class="flex-1"
                                    data-purchase-form
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="quantity"
                                        value="1"
                                        data-quantity-target
                                    >

                                    <input
                                        type="hidden"
                                        name="redirect_to"
                                        value="cart"
                                    >

                                    <button
                                        type="submit"
                                        class="
                                            bg-primary-main
                                            hover:bg-primary-main-dark
                                            text-success-light
                                            flex
                                            h-12
                                            w-full
                                            items-center
                                            justify-center
                                            gap-2
                                            rounded-lg
                                            px-6
                                            text-sm
                                            font-semibold
                                            transition-all
                                            hover:text-white
                                        "
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="20"
                                            height="20"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                        >
                                            <path
                                                d="M6.667 13.333L13.933 12.728C16.207 12.538 16.717 12.042 16.969 9.774L17.5 5"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                d="M5 5H18.333"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <circle
                                                cx="5"
                                                cy="16.667"
                                                r="1.667"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <circle
                                                cx="14.167"
                                                cy="16.667"
                                                r="1.667"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <path
                                                d="M1.667 1.667H2.472C3.259 1.667 3.945 2.187 4.136 2.929L6.615 12.564"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                        </svg>

                                        Add to Cart

                                    </button>

                                </form>

                            </div>


                            {{-- Buy Now --}}
                            <form
                                method="POST"
                                action="{{ route('cart.add', ['product' => $product->id]) }}"
                                class="mt-3"
                                data-purchase-form
                            >
                                @csrf

                                <input
                                    type="hidden"
                                    name="quantity"
                                    value="1"
                                    data-quantity-target
                                >

                                <input
                                    type="hidden"
                                    name="redirect_to"
                                    value="checkout"
                                >

                                <button
                                    type="submit"
                                    class="
                                        flex
                                        h-12
                                        w-full
                                        items-center
                                        justify-center
                                        rounded-lg
                                        border
                                        border-primary-main
                                        px-6
                                        text-sm
                                        font-semibold
                                        text-primary-main
                                        transition-all
                                        hover:bg-primary-main
                                        hover:text-success-light
                                    "
                                >
                                    Buy Now
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- DESCRIPTION / PRODUCT INFORMATION --}}
    {{-- ========================================================= --}}

    <section class="pb-12 lg:pb-16">

        <div class="custom-container">

            <div
                class="
                    grid
                    grid-cols-1
                    gap-8
                    lg:grid-cols-3
                "
            >

                {{-- Description --}}
                <div
                    class="
                        rounded-2xl
                        border
                        border-gray-300
                        bg-white
                        p-5
                        sm:p-7
                        lg:col-span-2
                    "
                >

                    <h2
                        class="
                            mb-5
                            text-2xl
                            font-bold
                            text-gray-primary
                        "
                    >
                        Product Description
                    </h2>


                    @if($product->description)

                        <div
                            class="
                                product-description
                                text-base
                                leading-8
                                text-gray-secondary
                            "
                        >
                            {!! $product->description !!}
                        </div>

                    @else

                        <p class="text-gray-tertiary">
                            Product description is not available.
                        </p>

                    @endif

                </div>


                {{-- Product Information --}}
                <div
                    class="
                        rounded-2xl
                        border
                        border-gray-300
                        bg-white
                        p-5
                        sm:p-7
                    "
                >

                    <h2
                        class="
                            mb-5
                            text-xl
                            font-bold
                            text-gray-primary
                        "
                    >
                        Product Information
                    </h2>


                    <div class="divide-y divide-gray-200">

                        @if($product->sku)

                            <div class="flex justify-between gap-5 py-3">
                                <span class="text-gray-tertiary">
                                    SKU
                                </span>

                                <span class="text-right font-medium text-gray-primary">
                                    {{ $product->sku }}
                                </span>
                            </div>

                        @endif


                        @if($product->model_no)

                            <div class="flex justify-between gap-5 py-3">
                                <span class="text-gray-tertiary">
                                    Model
                                </span>

                                <span class="text-right font-medium text-gray-primary">
                                    {{ $product->model_no }}
                                </span>
                            </div>

                        @endif


                        @if($product->category)

                            <div class="flex justify-between gap-5 py-3">
                                <span class="text-gray-tertiary">
                                    Category
                                </span>

                                <span class="text-right font-medium text-gray-primary">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                        @endif


                        @if($product->subCategory)

                            <div class="flex justify-between gap-5 py-3">
                                <span class="text-gray-tertiary">
                                    Sub Category
                                </span>

                                <span class="text-right font-medium text-gray-primary">
                                    {{ $product->subCategory->name }}
                                </span>
                            </div>

                        @endif


                        @if($product->childCategory)

                            <div class="flex justify-between gap-5 py-3">
                                <span class="text-gray-tertiary">
                                    Type
                                </span>

                                <span class="text-right font-medium text-gray-primary">
                                    {{ $product->childCategory->name }}
                                </span>
                            </div>

                        @endif


                        @if($product->brand)

                            <div class="flex justify-between gap-5 py-3">
                                <span class="text-gray-tertiary">
                                    Brand
                                </span>

                                <span class="text-right font-medium text-gray-primary">
                                    {{ $product->brand->name }}
                                </span>
                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- RELATED PRODUCTS --}}
    {{-- ========================================================= --}}

    @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())

        <section class="bg-gray-50 py-12 lg:py-16">

            <div class="custom-container">

                <div
                    class="
                        mb-8
                        flex
                        items-end
                        justify-between
                        gap-5
                        lg:mb-10
                    "
                >

                    <div>

                        <h2
                            class="
                                text-2xl
                                font-bold
                                text-gray-primary
                                md:text-3xl
                            "
                        >
                            Related Products
                        </h2>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-gray-secondary
                                md:text-base
                            "
                        >
                            More products you may like from the same category.
                        </p>

                    </div>


                    @if($product->category)

                        <a
                            href="{{ url('/shop?category=' . $product->category->slug) }}"
                            class="
                                hidden
                                shrink-0
                                text-sm
                                font-semibold
                                text-primary-main
                                transition
                                hover:opacity-70
                                sm:block
                            "
                        >
                            View All →
                        </a>

                    @endif

                </div>


                <div
                    class="
                        grid
                        grid-cols-2
                        gap-3
                        sm:gap-5
                        md:grid-cols-3
                        lg:grid-cols-4
                        lg:gap-6
                    "
                >

                    @foreach($relatedProducts->take(8) as $relatedProduct)

                        @include('frontend.partials.product-card', [
                            'product' => $relatedProduct
                        ])

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</main>

@endsection



@push('styles')

<style>
    /*
    |--------------------------------------------------------------------------
    | Product Description
    |--------------------------------------------------------------------------
    */

    .product-description p {
        margin-bottom: 1rem;
    }

    .product-description ul,
    .product-description ol {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .product-description ul {
        list-style: disc;
    }

    .product-description ol {
        list-style: decimal;
    }

    .product-description h2,
    .product-description h3,
    .product-description h4 {
        margin-top: 1.5rem;
        margin-bottom: .75rem;
        font-weight: 700;
        color: #212529;
    }

    .product-description img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
    }
</style>

@endpush



@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Product Gallery
    |--------------------------------------------------------------------------
    */

    const thumbElement =
        document.querySelector('.product-thumbs-slider');

    const mainElement =
        document.querySelector('.product-main-slider');


    if (
        thumbElement
        &&
        mainElement
        &&
        typeof window.Swiper !== 'undefined'
    ) {

        if (thumbElement.swiper) {
            thumbElement.swiper.destroy(true, true);
        }

        if (mainElement.swiper) {
            mainElement.swiper.destroy(true, true);
        }


        const thumbSwiper = new Swiper(
            thumbElement,
            {
                spaceBetween: 12,

                slidesPerView: 4,

                watchSlidesProgress: true,

                freeMode: true,

                breakpoints: {

                    768: {
                        direction: 'vertical',
                        slidesPerView: 6,
                        spaceBetween: 12,
                    },

                },
            }
        );


        new Swiper(
            mainElement,
            {
                slidesPerView: 1,

                spaceBetween: 16,

                navigation: {
                    nextEl: '.product-main-next',
                    prevEl: '.product-main-prev',
                },

                thumbs: {
                    swiper: thumbSwiper,
                },
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Quantity + Cart / Buy Now Sync
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-product-purchase]')
        .forEach(function (purchaseWrapper) {

            const quantityWrapper =
                purchaseWrapper.querySelector(
                    '[data-product-quantity]'
                );

            if (!quantityWrapper) {
                return;
            }

            const input =
                quantityWrapper.querySelector(
                    '[data-quantity-input]'
                );

            const minus =
                quantityWrapper.querySelector(
                    '[data-quantity-minus]'
                );

            const plus =
                quantityWrapper.querySelector(
                    '[data-quantity-plus]'
                );

            const targets =
                purchaseWrapper.querySelectorAll(
                    '[data-quantity-target]'
                );


            if (!input) {
                return;
            }


            const normalizeQuantity =
                function (value) {

                    let quantity =
                        parseInt(
                            value || '1',
                            10
                        );

                    if (
                        Number.isNaN(quantity)
                    ) {
                        quantity = 1;
                    }

                    quantity =
                        Math.max(
                            1,
                            Math.min(
                                99,
                                quantity
                            )
                        );

                    return quantity;
                };


            const syncQuantity =
                function () {

                    const quantity =
                        normalizeQuantity(
                            input.value
                        );

                    input.value =
                        quantity;

                    targets.forEach(
                        function (target) {
                            target.value =
                                quantity;
                        }
                    );

                };


            if (minus) {

                minus.addEventListener(
                    'click',
                    function () {

                        input.value =
                            normalizeQuantity(
                                input.value
                            ) - 1;

                        syncQuantity();

                    }
                );

            }


            if (plus) {

                plus.addEventListener(
                    'click',
                    function () {

                        input.value =
                            normalizeQuantity(
                                input.value
                            ) + 1;

                        syncQuantity();

                    }
                );

            }


            input.addEventListener(
                'input',
                syncQuantity
            );


            input.addEventListener(
                'change',
                syncQuantity
            );


            purchaseWrapper
                .querySelectorAll(
                    '[data-purchase-form]'
                )
                .forEach(
                    function (form) {

                        form.addEventListener(
                            'submit',
                            syncQuantity
                        );

                    }
                );


            syncQuantity();

        });

});
</script>

@endpush