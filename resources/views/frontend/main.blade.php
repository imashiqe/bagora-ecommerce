@extends('frontend.master')

@section('content')
{{-- Bagora homepage. Static template content prepared for later Category/Product database binding. --}}
<main>
@if(
    isset($banners)
    &&
    $banners->isNotEmpty()
)

<section
    class="
        group
        relative
        overflow-hidden
    "
>


    {{-- ========================================================= --}}
    {{-- SWIPER --}}
    {{-- ========================================================= --}}

    <div
        class="
            swiper
            hero-slider
            h-[220px]
            overflow-hidden
            sm:h-[300px]
            md:h-[380px]
            lg:h-[460px]
            xl:h-[740px]
        "
    >


        <div class="swiper-wrapper">


            @foreach($banners as $banner)


                <div
                    class="
                        swiper-slide
                        h-full
                        w-full
                    "
                >


                    <img
                        src="{{ asset($banner->image) }}"

                        alt="Bagora Banner"

                        class="
                            block
                            h-full
                            w-full
                            object-cover
                        "
                    >


                </div>


            @endforeach


        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- PREVIOUS --}}
    {{-- ========================================================= --}}

    @if($banners->count() > 1)

        <button
            type="button"

            class="
                hero-prev
                bg-black/20
                hover:bg-black/50
                absolute
                top-1/2
                left-2
                z-20
                hidden
                size-10
                -translate-y-1/2
                cursor-pointer
                items-center
                justify-center
                rounded-full
                text-white
                opacity-0
                transition-all
                duration-300
                group-hover:opacity-100
                md:size-12
                xl:flex
                2xl:left-10
            "
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"

                width="24"
                height="24"

                viewBox="0 0 24 24"

                fill="none"
            >

                <path
                    d="
                        M15 6L9.70711 11.2929
                        C9.37377 11.6262
                        9.20711 11.7929
                        9.20711 12
                        C9.20711 12.2071
                        9.37377 12.3738
                        9.70711 12.7071
                        L15 18
                    "

                    stroke="currentColor"

                    stroke-width="1.5"

                    stroke-linecap="round"

                    stroke-linejoin="round"
                />

            </svg>

        </button>



        {{-- ========================================================= --}}
        {{-- NEXT --}}
        {{-- ========================================================= --}}

        <button
            type="button"

            class="
                hero-next
                bg-black/20
                hover:bg-black/50
                absolute
                top-1/2
                right-2
                z-20
                hidden
                size-10
                -translate-y-1/2
                cursor-pointer
                items-center
                justify-center
                rounded-full
                text-white
                opacity-0
                transition-all
                duration-300
                group-hover:opacity-100
                md:size-12
                xl:flex
                2xl:right-10
            "
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"

                width="24"
                height="24"

                viewBox="0 0 24 24"

                fill="none"
            >

                <path
                    d="
                        M9 18L14.2929 12.7071
                        C14.6262 12.3738
                        14.7929 12.2071
                        14.7929 12
                        C14.7929 11.7929
                        14.6262 11.6262
                        14.2929 11.2929
                        L9 6.00002
                    "

                    stroke="currentColor"

                    stroke-width="1.5"

                    stroke-linecap="round"

                    stroke-linejoin="round"
                />

            </svg>

        </button>



        {{-- ========================================================= --}}
        {{-- PAGINATION --}}
        {{-- ========================================================= --}}

        <div
            class="
                hero-pagination
                absolute
                !right-0
                !bottom-3
                !left-0
                z-20
                !mx-auto
                flex
                !w-max
                items-center
                justify-center
                gap-2
                rounded-full
                bg-black/20
                px-3
                py-2
                lg:!bottom-5
            "
        ></div>

    @endif


</section>

@endif

{{-- slider end --}}
{{-- ========================================================= --}}
{{-- DYNAMIC CATEGORY SHOWCASE --}}
{{-- ========================================================= --}}

@if(isset($categories) && $categories->isNotEmpty())

<section
    id="category-showcase"
    class="overflow-hidden bg-white py-8 md:py-10 lg:py-12"
>

    <div class="custom-container relative">

        {{-- ========================================================= --}}
        {{-- SWIPER --}}
        {{-- ========================================================= --}}

        <div
            class="
                swiper
                category-showcase-slider
                !overflow-visible
            "
        >

            <div class="swiper-wrapper">


                @foreach($categories as $category)

                    <div
                        class="
                            swiper-slide
                            !h-auto
                        "
                    >

                        <a
                            href="{{ url('/shop?category=' . $category->slug) }}"

                            class="
                                group
                                block
                                w-full
                                overflow-hidden
                                rounded-[10px]
                                bg-gray-100
                            "
                        >

                            @if($category->image)

                                <div
                                    class="
                                        category-showcase-media
                                        relative
                                        w-full
                                        overflow-hidden
                                    "
                                >

                                    <img
                                        src="{{ asset($category->image) }}"

                                        alt="{{ $category->name }}"

                                        loading="lazy"

                                        class="
                                            block
                                            h-full
                                            w-full
                                            object-cover
                                            transition-transform
                                            duration-500
                                            ease-out
                                            group-hover:scale-[1.025]
                                        "
                                    >

                                </div>

                            @else

                                <div
                                    class="
                                        category-showcase-media
                                        flex
                                        w-full
                                        items-center
                                        justify-center
                                        bg-gray-100
                                    "
                                >

                                    <div class="text-center">

                                        <i
                                            class="
                                                bi
                                                bi-image
                                                text-5xl
                                                text-gray-300
                                            "
                                        ></i>

                                        <div
                                            class="
                                                mt-3
                                                text-sm
                                                text-gray-400
                                            "
                                        >

                                            {{ $category->name }}

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </a>

                    </div>

                @endforeach


            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- DESKTOP INVISIBLE DRAG AREA --}}
        {{-- ========================================================= --}}

        <div
            class="
                pointer-events-none
                absolute
                inset-0
                z-10
                hidden
                lg:block
            "
        ></div>

    </div>



    {{-- ========================================================= --}}
    {{-- DRAG INDICATOR --}}
    {{-- ========================================================= --}}

    @if($categories->count() > 1)

        <div
            class="
                mt-7
                flex
                select-none
                items-center
                justify-center
                gap-3
                text-[11px]
                font-bold
                uppercase
                tracking-[0.13em]
                text-[#3d3d3d]
            "
        >

            <span
                class="
                    text-base
                    font-normal
                    leading-none
                "
            >
                ←
            </span>


            <span>
                DRAG
            </span>


            <span
                class="
                    text-base
                    font-normal
                    leading-none
                "
            >
                →
            </span>

        </div>

    @endif

</section>

@endif



{{-- ========================================================= --}}
{{-- CATEGORY SHOWCASE STYLE --}}
{{-- ========================================================= --}}

@push('styles')

<style>
    /*
    |--------------------------------------------------------------------------
    | Category Showcase
    |--------------------------------------------------------------------------
    */

    #category-showcase {
        width: 100%;
        overflow: hidden;
    }

    #category-showcase .category-showcase-slider {
        width: 100%;
        overflow: hidden !important;
        cursor: grab;
    }

    #category-showcase .category-showcase-slider:active {
        cursor: grabbing;
    }

    #category-showcase .swiper-wrapper {
        align-items: stretch;
        transition-timing-function: linear !important;
    }

    #category-showcase .swiper-slide {
        height: auto !important;
        min-width: 0;
    }

    #category-showcase .category-showcase-media {
        width: 100%;
        aspect-ratio: 310 / 393;
    }

    #category-showcase .category-showcase-media img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        user-select: none;
        -webkit-user-drag: none;
    }

    @media (max-width: 639px) {
        #category-showcase {
            padding-left: 0;
            padding-right: 0;
        }
    }
</style>

@endpush



{{-- ========================================================= --}}
{{-- CATEGORY SHOWCASE SWIPER --}}
{{-- ========================================================= --}}

{{-- ========================================================= --}}
{{-- LATEST PRODUCTS --}}
{{-- ========================================================= --}}

@if(isset($latestProducts) && $latestProducts->isNotEmpty())

<section
    id="latest-products"
    class="bg-white py-10 lg:py-16"
>

    <div class="custom-container">

        {{-- Heading --}}
        <div
            class="
                mb-7
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
                    Latest Products
                </h2>

                <p
                    class="
                        mt-2
                        text-sm
                        text-gray-secondary
                        md:text-base
                    "
                >
                    Discover our newest Bagora bags and latest additions.
                </p>

            </div>


            <a
                href="{{ url('/shop') }}"
                class="
                    hidden
                    shrink-0
                    items-center
                    gap-2
                    text-sm
                    font-semibold
                    text-primary-main
                    transition
                    hover:opacity-70
                    sm:inline-flex
                "
            >
                View All
                <span>→</span>
            </a>

        </div>


        {{-- Products --}}
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

            @foreach($latestProducts->take(8) as $product)

                @include('frontend.partials.product-card', [
                    'product' => $product
                ])

            @endforeach

        </div>


        {{-- Mobile View All --}}
        <div class="mt-7 flex justify-center sm:hidden">

            <a
                href="{{ url('/shop') }}"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-full
                    border
                    border-primary-main
                    px-6
                    py-2.5
                    text-sm
                    font-semibold
                    text-primary-main
                    transition
                    hover:bg-primary-main
                    hover:text-white
                "
            >
                View All Products
                <span>→</span>
            </a>

        </div>

    </div>

</section>

@endif

{{-- category slider end --}}

{{-- ========================================================= --}}
{{-- BEST SELLING PRODUCTS --}}
{{-- ========================================================= --}}

@if(isset($bestSellingProducts) && $bestSellingProducts->isNotEmpty())

<section id="best-selling-section" class="bg-white py-12 lg:py-16">

    <div class="custom-container">

        {{-- Heading --}}
        <div class="mb-8 flex items-end justify-between gap-5 lg:mb-10">

            <div>

                <h2 class="text-2xl font-bold text-gray-primary md:text-3xl">
                    Best Selling Bags
                </h2>

                <p class="mt-2 text-sm text-gray-secondary md:text-base">
                    Customer-favorite Bagora styles for work, study and travel.
                </p>

            </div>


            <a
                href="{{ url('/shop') }}"
                class="
                    hidden
                    items-center
                    gap-2
                    text-sm
                    font-semibold
                    text-primary-main
                    transition
                    hover:opacity-70
                    sm:flex
                "
            >
                View All

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <path
                        d="M5 12H19M14 7L19 12L14 17"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </a>

        </div>


        {{-- Product Grid --}}
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

            @foreach($bestSellingProducts->take(8) as $product)

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

                    $discountPercent = $hasDiscount && $regularPrice > 0
                        ? round((($regularPrice - $salePrice) / $regularPrice) * 100)
                        : 0;

                @endphp


                <article
                    class="
                        group
                        flex
                        min-w-0
                        flex-col
                        overflow-hidden
                        rounded-xl
                        border
                        border-gray-300
                        bg-white
                        transition-all
                        duration-300
                        hover:-translate-y-1
                        hover:shadow-lg
                    "
                >

                    {{-- Image --}}
                    <div class="relative overflow-hidden bg-gray-100">

                        <a
                            href="{{ url('/shop?product=' . $product->slug) }}"
                            class="block aspect-square overflow-hidden"
                        >

                            @if($product->thumbnail)

                                <img
                                    src="{{ asset($product->thumbnail) }}"
                                    alt="{{ $product->title }}"
                                    loading="lazy"
                                    class="
                                        h-full
                                        w-full
                                        object-cover
                                        transition-transform
                                        duration-500
                                        ease-out
                                        group-hover:scale-105
                                    "
                                >

                            @else

                                <div
                                    class="
                                        flex
                                        h-full
                                        w-full
                                        items-center
                                        justify-center
                                        bg-gray-100
                                        text-sm
                                        text-gray-400
                                    "
                                >
                                    No Image
                                </div>

                            @endif

                        </a>


                        {{-- Discount --}}
                        @if($hasDiscount)

                            <div
                                class="
                                    absolute
                                    top-3
                                    left-3
                                    rounded-md
                                    bg-error-dark
                                    px-2.5
                                    py-1
                                    text-[11px]
                                    font-bold
                                    text-white
                                "
                            >
                                -{{ $discountPercent }}%
                            </div>

                        @endif


                        {{-- Bestseller badge --}}
                        <div
                            class="
                                absolute
                                bottom-3
                                left-3
                                rounded-full
                                bg-white/95
                                px-2.5
                                py-1
                                text-[10px]
                                font-semibold
                                tracking-wide
                                text-primary-main
                                shadow-sm
                                backdrop-blur
                            "
                        >
                            BEST SELLER
                        </div>


                        {{-- Wishlist --}}
                        <button
                            type="button"
                            class="
                                absolute
                                top-3
                                right-3
                                flex
                                size-9
                                items-center
                                justify-center
                                rounded-full
                                bg-white
                                text-gray-secondary
                                shadow-sm
                                transition
                                hover:bg-error-dark
                                hover:text-white
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M20.84 4.61A5.5 5.5 0 0013.06 4L12 5.06 10.94 4A5.5 5.5 0 003.16 11.78L12 20.62l8.84-8.84a5.5 5.5 0 000-7.17Z"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>

                        </button>

                    </div>


                    {{-- Content --}}
                    <div class="flex flex-1 flex-col p-3 sm:p-4">


                        {{-- Category / Brand --}}
                        <div
                            class="
                                mb-2
                                flex
                                min-w-0
                                items-center
                                gap-2
                                text-[11px]
                                text-gray-tertiary
                                sm:text-xs
                            "
                        >

                            @if($product->category)

                                <span class="truncate">
                                    {{ $product->category->name }}
                                </span>

                            @endif


                            @if($product->category && $product->brand)

                                <span>•</span>

                            @endif


                            @if($product->brand)

                                <span class="truncate">
                                    {{ $product->brand->name }}
                                </span>

                            @endif

                        </div>


                        {{-- Product Title --}}
                        <h3
                            class="
                                mb-3
                                line-clamp-2
                                min-h-[40px]
                                text-sm
                                leading-5
                                font-semibold
                                text-gray-primary
                                transition
                                group-hover:text-primary-main
                                sm:text-base
                                sm:leading-6
                            "
                        >

                            <a
                                href="{{ url('/shop?product=' . $product->slug) }}"
                            >
                                {{ $product->title }}
                            </a>

                        </h3>


                        {{-- Price --}}
                        <div class="mt-auto">

                            <div
                                class="
                                    flex
                                    flex-wrap
                                    items-center
                                    gap-x-2
                                    gap-y-1
                                "
                            >

                                <span
                                    class="
                                        text-base
                                        font-bold
                                        text-gray-primary
                                        sm:text-lg
                                    "
                                >
                                    ৳{{ number_format($currentPrice, 0) }}
                                </span>


                                @if($hasDiscount)

                                    <span
                                        class="
                                            text-xs
                                            text-gray-tertiary
                                            line-through
                                            sm:text-sm
                                        "
                                    >
                                        ৳{{ number_format($regularPrice, 0) }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Add to Cart --}}
                        <a
                            href="{{ url('/shop?product=' . $product->slug) }}"
                            class="
                                mt-4
                                flex
                                w-full
                                items-center
                                justify-center
                                gap-2
                                rounded-lg
                                bg-primary-main
                                px-3
                                py-2.5
                                text-xs
                                font-semibold
                                text-success-light
                                transition-all
                                duration-300
                                hover:bg-primary-main-dark
                                hover:text-white
                                sm:text-sm
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
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

                        </a>

                    </div>

                </article>

            @endforeach

        </div>


        {{-- Mobile View All --}}
        <div class="mt-7 flex justify-center sm:hidden">

            <a
                href="{{ url('/shop') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    rounded-full
                    border
                    border-primary-main
                    px-6
                    py-2.5
                    text-sm
                    font-semibold
                    text-primary-main
                "
            >
                View All Products →

            </a>

        </div>

    </div>

</section>

@endif
{{-- best selling end --}}


<section class="py-12">
  <div class="custom-container">
    <div
      class="flex snap-x snap-mandatory gap-6 overflow-x-auto xl:grid xl:grid-cols-3 [&::-webkit-scrollbar]:hidden"
    >
      <article
        class="wow animate__fadeInUp shrink-0 snap-start overflow-hidden rounded-2xl sm:w-[400px] xl:w-auto"
        data-wow-duration="1.2s"
      >
        <div class="relative">
          <img
            src="{{ asset('frontend/assets/images/home-1/three-col-cta/one.jpg') }}"
            class="h-full w-full rounded-2xl object-cover transition-transform duration-300 hover:scale-110"
            alt=""
          />
          <div
            class="absolute right-6 bottom-6 left-6 rounded-3xl bg-white p-6"
          >
            <h3
              class="lg:text-32 text-primary-main mb-2 text-2xl font-bold lg:leading-12"
            >
              Smart Way to Shop Bags Online
            </h3>
            <p class="text-primary-main mb-6 text-base">
              Comprehensive Healthcare Solutions Delivered with Care and
              Precision
            </p>
            <a
              href="{{ url('/blog') }}"
              class="group bg-primary-main hover:bg-primary-main-dark text-success-light inline-flex items-center justify-center gap-2 rounded-lg px-5 py-3 text-base font-medium transition-all hover:text-white"
            >
              Shop Bags
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                class="transition-transform duration-500 group-hover:rotate-45"
              >
                <path
                  d="M15.5833 6.41406L5.5 16.4974"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
                <path
                  d="M10.0835 5.5H15.8335C16.1478 5.5 16.3049 5.5 16.4025 5.59763C16.5002 5.69526 16.5002 5.8524 16.5002 6.16667V11.9167"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>
          </div>
        </div>
      </article>
      <article
        class="wow animate__fadeInUp shrink-0 snap-start overflow-hidden rounded-2xl sm:w-[400px] xl:w-auto"
        data-wow-duration="1.2s"
        data-wow-delay="0.1s"
      >
        <div class="relative">
          <img
            src="{{ asset('frontend/assets/images/home-1/three-col-cta/two.jpg') }}"
            class="h-full w-full rounded-2xl object-cover transition-transform duration-300 hover:scale-110"
            alt=""
          />
          <div
            class="absolute right-6 bottom-6 left-6 rounded-3xl bg-white p-6"
          >
            <h3
              class="lg:text-32 text-primary-main mb-2 text-2xl font-bold lg:leading-12"
            >
              Great Value on Everyday Bags
            </h3>
            <p class="text-primary-main mb-6 text-base">
              Comprehensive Healthcare Solutions Delivered with Care and
              Precision
            </p>
            <a
              href="{{ url('/blog') }}"
              class="group bg-primary-main hover:bg-primary-main-dark text-success-light inline-flex items-center justify-center gap-2 rounded-lg px-5 py-3 text-base font-medium transition-all hover:text-white"
            >
              Shop Bags
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                class="transition-transform duration-500 group-hover:rotate-45"
              >
                <path
                  d="M15.5833 6.41406L5.5 16.4974"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
                <path
                  d="M10.0835 5.5H15.8335C16.1478 5.5 16.3049 5.5 16.4025 5.59763C16.5002 5.69526 16.5002 5.8524 16.5002 6.16667V11.9167"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>
          </div>
        </div>
      </article>
      <article
        class="wow animate__fadeInUp shrink-0 snap-start overflow-hidden rounded-2xl sm:w-[400px] xl:w-auto"
        data-wow-duration="1.2s"
        data-wow-delay="0.2s"
      >
        <div class="relative">
          <img
            src="{{ asset('frontend/assets/images/home-1/three-col-cta/three.jpg') }}"
            class="h-full w-full rounded-2xl object-cover transition-transform duration-300 hover:scale-110"
            alt=""
          />
          <div
            class="absolute right-6 bottom-6 left-6 rounded-3xl bg-white p-6"
          >
            <h3
              class="lg:text-32 text-primary-main mb-2 text-2xl font-bold lg:leading-12"
            >
              Upgrade Your Everyday Carry with Bagora
            </h3>
            <p class="text-primary-main mb-6 text-base">
              Comprehensive Healthcare Solutions Delivered with Care and
              Precision
            </p>
            <a
              href="{{ url('/blog') }}"
              class="group bg-primary-main hover:bg-primary-main-dark text-success-light inline-flex items-center justify-center gap-2 rounded-lg px-5 py-3 text-base font-medium transition-all hover:text-white"
            >
              Shop Bags
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                class="transition-transform duration-500 group-hover:rotate-45"
              >
                <path
                  d="M15.5833 6.41406L5.5 16.4974"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
                <path
                  d="M10.0835 5.5H15.8335C16.1478 5.5 16.3049 5.5 16.4025 5.59763C16.5002 5.69526 16.5002 5.8524 16.5002 6.16667V11.9167"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

{{-- category wise products --}}
<section class="py-12">
  <div class="custom-container">
    <div class="wow animate__fadeInUp mx-auto mb-12 max-w-md text-center">
      <h2 class="text-32 text-gray-primary mb-2 font-bold">Backpack</h2>
      <p class="text-gray-secondary text-base">
        Premium staples, thoughtfully priced for a limited time
      </p>
    </div>

    <div class="swiper new-item-product-slider">
      <div class="swiper-wrapper">
        <article
          class="wow animate__fadeInUp swiper-slide"
          data-wow-duration="1.2s"
        >
          <div
            class="flex flex-col gap-3.5 rounded-xl border border-gray-300 p-4"
          >
            <div class="relative">
              <a
                href="{{ url('/shop') }}"
                class="relative block overflow-hidden rounded-lg"
              >
                <img
                  src="{{ asset('frontend/assets/images/home-1/new-item/product-1.webp') }}"
                  class="w-full rounded-lg transition-transform duration-300 hover:scale-110"
                  alt="Bagora Bag"
                />
              </a>
              <!-- Discount Badge -->
              <div class="absolute top-2 left-0 inline-block">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="67"
                  height="22"
                  viewBox="0 0 67 22"
                  fill="none"
                >
                  <path
                    d="M67 0L65.2314 1.86426L67 3.54199L65.2314 5.59277L67 7.27148L65.2314 9.13574L67 11L65.2314 12.8643L67 14.7285L65.2314 16.5928L67 18.458L65.2314 20.1357L67 22H0V0H67Z"
                    fill="#CB0233"
                  />
                </svg>
                <span
                  class="absolute inset-0 z-10 flex items-center justify-center text-xs font-medium text-white uppercase"
                >
                  15% off
                </span>
              </div>
              <!-- Wishlist -->
              <div x-data="{ liked: false }">
                <button
                  @click="liked = !liked"
                  :class="liked
      ? 'bg-error-dark text-white'
      : 'bg-white text-gray-secondary'"
                  class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full transition-all duration-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                  >
                    <path
                      d="M14.5969 2.99561C12.5857 1.76192 10.8303 2.25909 9.77576 3.05101C9.34339 3.37572 9.1272 3.53807 9 3.53807C8.8728 3.53807 8.65661 3.37572 8.22424 3.05101C7.16971 2.25909 5.41431 1.76192 3.40308 2.99561C0.763551 4.6147 0.166291 9.95614 6.25465 14.4625C7.41429 15.3208 7.99411 15.75 9 15.75C10.0059 15.75 10.5857 15.3208 11.7454 14.4625C17.8337 9.95614 17.2364 4.6147 14.5969 2.99561Z"
                      stroke="currentColor"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
            <h3
              class="text-gray-primary hover:text-primary-main line-clamp-2 text-base leading-6 font-medium"
            >
              <a href="{{ url('/shop') }}">
                Bagora Executive Laptop Bag
              </a>
            </h3>
            <div class="flex items-center gap-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
              >
                <path
                  d="M13.1701 15.75C13.0501 15.7505 12.9318 15.7222 12.8251 15.6675L9.00009 13.665L5.17509 15.6675C4.92169 15.8008 4.61453 15.7781 4.38341 15.6092C4.15228 15.4402 4.03751 15.1544 4.08759 14.8725L4.83759 10.65L1.74759 7.65003C1.55113 7.45398 1.479 7.16547 1.56009 6.90003C1.64877 6.6281 1.8844 6.43028 2.16759 6.39003L6.44259 5.76753L8.32509 1.92003C8.4504 1.66129 8.71259 1.49695 9.00009 1.49695C9.28758 1.49695 9.54977 1.66129 9.67509 1.92003L11.5801 5.76003L15.8551 6.38253C16.1383 6.42278 16.3739 6.6206 16.4626 6.89253C16.5437 7.15797 16.4715 7.44648 16.2751 7.64253L13.1851 10.6425L13.9351 14.865C13.9898 15.1521 13.8727 15.4448 13.6351 15.615C13.4993 15.7102 13.3357 15.7577 13.1701 15.75Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#919EAB"
                />
              </svg>
              <span class="text-gray-secondary text-sm"> (189) </span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-gray-primary text-base font-medium"
                >৳1,590</span
              >
              <span class="text-gray-tertiary text-sm line-through"
                >৳1,890</span
              >
            </div>
            <button
              class="bg-primary-main hover:bg-primary-main-dark text-success-light flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <g clip-path="url(#clip0_37995_40602)">
                  <path
                    d="M6.6665 13.3333L13.9333 12.7278C16.207 12.5383 16.7174 12.0417 16.9694 9.77406L17.4998 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M5 5L18.3333 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <circle
                    cx="4.99967"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <circle
                    cx="14.1667"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <path
                    d="M6.66667 16.6666L12.5 16.6666"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M1.6665 1.66663L2.47151 1.66663C3.25874 1.66663 3.94495 2.18712 4.13589 2.92907L6.61527 12.5637C6.74057 13.0506 6.63334 13.5664 6.32337 13.9679L5.52661 15"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_37995_40602">
                    <rect width="20" height="20" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Add to Cart
            </button>
          </div>
        </article>

        <article
          class="wow animate__fadeInUp swiper-slide"
          data-wow-duration="1.2s"
          data-wow-delay="0.1s"
        >
          <div
            class="flex flex-col gap-3.5 rounded-xl border border-gray-300 p-4"
          >
            <div class="relative">
              <a
                href="{{ url('/shop') }}"
                class="relative block overflow-hidden rounded-lg"
              >
                <img
                  src="{{ asset('frontend/assets/images/home-1/new-item/product-2.webp') }}"
                  class="w-full rounded-lg transition-transform duration-300 hover:scale-110"
                  alt="Bagora Bag"
                />
              </a>
              <!-- Discount Badge -->
              <div class="absolute top-2 left-0 inline-block">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="67"
                  height="22"
                  viewBox="0 0 67 22"
                  fill="none"
                >
                  <path
                    d="M67 0L65.2314 1.86426L67 3.54199L65.2314 5.59277L67 7.27148L65.2314 9.13574L67 11L65.2314 12.8643L67 14.7285L65.2314 16.5928L67 18.458L65.2314 20.1357L67 22H0V0H67Z"
                    fill="#CB0233"
                  />
                </svg>
                <span
                  class="absolute inset-0 z-10 flex items-center justify-center text-xs font-medium text-white uppercase"
                >
                  20% off
                </span>
              </div>
              <!-- Wishlist -->
              <div x-data="{ liked: false }">
                <button
                  @click="liked = !liked"
                  :class="liked
      ? 'bg-error-dark text-white'
      : 'bg-white text-gray-secondary'"
                  class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full transition-all duration-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                  >
                    <path
                      d="M14.5969 2.99561C12.5857 1.76192 10.8303 2.25909 9.77576 3.05101C9.34339 3.37572 9.1272 3.53807 9 3.53807C8.8728 3.53807 8.65661 3.37572 8.22424 3.05101C7.16971 2.25909 5.41431 1.76192 3.40308 2.99561C0.763551 4.6147 0.166291 9.95614 6.25465 14.4625C7.41429 15.3208 7.99411 15.75 9 15.75C10.0059 15.75 10.5857 15.3208 11.7454 14.4625C17.8337 9.95614 17.2364 4.6147 14.5969 2.99561Z"
                      stroke="currentColor"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
            <h3
              class="text-gray-primary hover:text-primary-main line-clamp-2 text-base leading-6 font-medium"
            >
              <a href="{{ url('/shop') }}">
                Bagora Compact Crossbody Bag
              </a>
            </h3>
            <div class="flex items-center gap-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
              >
                <path
                  d="M13.1701 15.75C13.0501 15.7505 12.9318 15.7222 12.8251 15.6675L9.00009 13.665L5.17509 15.6675C4.92169 15.8008 4.61453 15.7781 4.38341 15.6092C4.15228 15.4402 4.03751 15.1544 4.08759 14.8725L4.83759 10.65L1.74759 7.65003C1.55113 7.45398 1.479 7.16547 1.56009 6.90003C1.64877 6.6281 1.8844 6.43028 2.16759 6.39003L6.44259 5.76753L8.32509 1.92003C8.4504 1.66129 8.71259 1.49695 9.00009 1.49695C9.28758 1.49695 9.54977 1.66129 9.67509 1.92003L11.5801 5.76003L15.8551 6.38253C16.1383 6.42278 16.3739 6.6206 16.4626 6.89253C16.5437 7.15797 16.4715 7.44648 16.2751 7.64253L13.1851 10.6425L13.9351 14.865C13.9898 15.1521 13.8727 15.4448 13.6351 15.615C13.4993 15.7102 13.3357 15.7577 13.1701 15.75Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <span class="text-gray-secondary text-sm"> (245) </span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-gray-primary text-base font-medium"
                >৳1,290</span
              >
              <span class="text-gray-tertiary text-sm line-through"
                >৳1,490</span
              >
            </div>
            <button
              class="bg-primary-main hover:bg-primary-main-dark text-success-light flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <g clip-path="url(#clip0_37995_40602_2)">
                  <path
                    d="M6.6665 13.3333L13.9333 12.7278C16.207 12.5383 16.7174 12.0417 16.9694 9.77406L17.4998 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M5 5L18.3333 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <circle
                    cx="4.99967"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <circle
                    cx="14.1667"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <path
                    d="M6.66667 16.6666L12.5 16.6666"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M1.6665 1.66663L2.47151 1.66663C3.25874 1.66663 3.94495 2.18712 4.13589 2.92907L6.61527 12.5637C6.74057 13.0506 6.63334 13.5664 6.32337 13.9679L5.52661 15"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_37995_40602_2">
                    <rect width="20" height="20" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Add to Cart
            </button>
          </div>
        </article>

        <article
          class="wow animate__fadeInUp swiper-slide"
          data-wow-duration="1.2s"
          data-wow-delay="0.2s"
        >
          <div
            class="flex flex-col gap-3.5 rounded-xl border border-gray-300 p-4"
          >
            <div class="relative">
              <a
                href="{{ url('/shop') }}"
                class="relative block overflow-hidden rounded-lg"
              >
                <img
                  src="{{ asset('frontend/assets/images/home-1/new-item/product-3.webp') }}"
                  class="w-full rounded-lg transition-transform duration-300 hover:scale-110"
                  alt="Bagora Backpack"
                />
              </a>
              <!-- Discount Badge -->
              <div class="absolute top-2 left-0 inline-block">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="67"
                  height="22"
                  viewBox="0 0 67 22"
                  fill="none"
                >
                  <path
                    d="M67 0L65.2314 1.86426L67 3.54199L65.2314 5.59277L67 7.27148L65.2314 9.13574L67 11L65.2314 12.8643L67 14.7285L65.2314 16.5928L67 18.458L65.2314 20.1357L67 22H0V0H67Z"
                    fill="#CB0233"
                  />
                </svg>
                <span
                  class="absolute inset-0 z-10 flex items-center justify-center text-xs font-medium text-white uppercase"
                >
                  10% off
                </span>
              </div>
              <!-- Wishlist -->
              <div x-data="{ liked: false }">
                <button
                  @click="liked = !liked"
                  :class="liked
      ? 'bg-error-dark text-white'
      : 'bg-white text-gray-secondary'"
                  class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full transition-all duration-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                  >
                    <path
                      d="M14.5969 2.99561C12.5857 1.76192 10.8303 2.25909 9.77576 3.05101C9.34339 3.37572 9.1272 3.53807 9 3.53807C8.8728 3.53807 8.65661 3.37572 8.22424 3.05101C7.16971 2.25909 5.41431 1.76192 3.40308 2.99561C0.763551 4.6147 0.166291 9.95614 6.25465 14.4625C7.41429 15.3208 7.99411 15.75 9 15.75C10.0059 15.75 10.5857 15.3208 11.7454 14.4625C17.8337 9.95614 17.2364 4.6147 14.5969 2.99561Z"
                      stroke="currentColor"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
            <h3
              class="text-gray-primary hover:text-primary-main line-clamp-2 text-base leading-6 font-medium"
            >
              <a href="{{ url('/shop') }}">
                Bagora Urban Everyday Backpack
              </a>
            </h3>
            <div class="flex items-center gap-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
              >
                <path
                  d="M13.1701 15.75C13.0501 15.7505 12.9318 15.7222 12.8251 15.6675L9.00009 13.665L5.17509 15.6675C4.92169 15.8008 4.61453 15.7781 4.38341 15.6092C4.15228 15.4402 4.03751 15.1544 4.08759 14.8725L4.83759 10.65L1.74759 7.65003C1.55113 7.45398 1.479 7.16547 1.56009 6.90003C1.64877 6.6281 1.8844 6.43028 2.16759 6.39003L6.44259 5.76753L8.32509 1.92003C8.4504 1.66129 8.71259 1.49695 9.00009 1.49695C9.28758 1.49695 9.54977 1.66129 9.67509 1.92003L11.5801 5.76003L15.8551 6.38253C16.1383 6.42278 16.3739 6.6206 16.4626 6.89253C16.5437 7.15797 16.4715 7.44648 16.2751 7.64253L13.1851 10.6425L13.9351 14.865C13.9898 15.1521 13.8727 15.4448 13.6351 15.615C13.4993 15.7102 13.3357 15.7577 13.1701 15.75Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#919EAB"
                />
              </svg>
              <span class="text-gray-secondary text-sm"> (98) </span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-gray-primary text-base font-medium">৳790</span>
              <span class="text-gray-tertiary text-sm line-through">৳850</span>
            </div>
            <button
              class="bg-primary-main hover:bg-primary-main-dark text-success-light flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <g clip-path="url(#clip0_37995_40602_3)">
                  <path
                    d="M6.6665 13.3333L13.9333 12.7278C16.207 12.5383 16.7174 12.0417 16.9694 9.77406L17.4998 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M5 5L18.3333 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <circle
                    cx="4.99967"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <circle
                    cx="14.1667"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <path
                    d="M6.66667 16.6666L12.5 16.6666"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M1.6665 1.66663L2.47151 1.66663C3.25874 1.66663 3.94495 2.18712 4.13589 2.92907L6.61527 12.5637C6.74057 13.0506 6.63334 13.5664 6.32337 13.9679L5.52661 15"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_37995_40602_3">
                    <rect width="20" height="20" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Add to Cart
            </button>
          </div>
        </article>

        <article
          class="wow animate__fadeInUp swiper-slide"
          data-wow-duration="1.2s"
          data-wow-delay="0.3s"
        >
          <div
            class="flex flex-col gap-3.5 rounded-xl border border-gray-300 p-4"
          >
            <div class="relative">
              <a
                href="{{ url('/shop') }}"
                class="relative block overflow-hidden rounded-lg"
              >
                <img
                  src="{{ asset('frontend/assets/images/home-1/new-item/product-4.webp') }}"
                  class="w-full rounded-lg transition-transform duration-300 hover:scale-110"
                  alt="Probiotic Yogurt"
                />
              </a>
              <!-- Discount Badge -->
              <div class="absolute top-2 left-0 inline-block">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="67"
                  height="22"
                  viewBox="0 0 67 22"
                  fill="none"
                >
                  <path
                    d="M67 0L65.2314 1.86426L67 3.54199L65.2314 5.59277L67 7.27148L65.2314 9.13574L67 11L65.2314 12.8643L67 14.7285L65.2314 16.5928L67 18.458L65.2314 20.1357L67 22H0V0H67Z"
                    fill="#CB0233"
                  />
                </svg>
                <span
                  class="absolute inset-0 z-10 flex items-center justify-center text-xs font-medium text-white uppercase"
                >
                  25% off
                </span>
              </div>
              <!-- Wishlist -->
              <div x-data="{ liked: false }">
                <button
                  @click="liked = !liked"
                  :class="liked
      ? 'bg-error-dark text-white'
      : 'bg-white text-gray-secondary'"
                  class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full transition-all duration-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                  >
                    <path
                      d="M14.5969 2.99561C12.5857 1.76192 10.8303 2.25909 9.77576 3.05101C9.34339 3.37572 9.1272 3.53807 9 3.53807C8.8728 3.53807 8.65661 3.37572 8.22424 3.05101C7.16971 2.25909 5.41431 1.76192 3.40308 2.99561C0.763551 4.6147 0.166291 9.95614 6.25465 14.4625C7.41429 15.3208 7.99411 15.75 9 15.75C10.0059 15.75 10.5857 15.3208 11.7454 14.4625C17.8337 9.95614 17.2364 4.6147 14.5969 2.99561Z"
                      stroke="currentColor"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
            <h3
              class="text-gray-primary hover:text-primary-main line-clamp-2 text-base leading-6 font-medium"
            >
              <a href="{{ url('/shop') }}">
                Greek Style Probiotic Yogurt – Plain Creamy Texture
              </a>
            </h3>
            <div class="flex items-center gap-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
              >
                <path
                  d="M13.1701 15.75C13.0501 15.7505 12.9318 15.7222 12.8251 15.6675L9.00009 13.665L5.17509 15.6675C4.92169 15.8008 4.61453 15.7781 4.38341 15.6092C4.15228 15.4402 4.03751 15.1544 4.08759 14.8725L4.83759 10.65L1.74759 7.65003C1.55113 7.45398 1.479 7.16547 1.56009 6.90003C1.64877 6.6281 1.8844 6.43028 2.16759 6.39003L6.44259 5.76753L8.32509 1.92003C8.4504 1.66129 8.71259 1.49695 9.00009 1.49695C9.28758 1.49695 9.54977 1.66129 9.67509 1.92003L11.5801 5.76003L15.8551 6.38253C16.1383 6.42278 16.3739 6.6206 16.4626 6.89253C16.5437 7.15797 16.4715 7.44648 16.2751 7.64253L13.1851 10.6425L13.9351 14.865C13.9898 15.1521 13.8727 15.4448 13.6351 15.615C13.4993 15.7102 13.3357 15.7577 13.1701 15.75Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <span class="text-gray-secondary text-sm"> (312) </span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-gray-primary text-base font-medium">৳890</span>
              <span class="text-gray-tertiary text-sm line-through">৳1,090</span>
            </div>
            <button
              class="bg-primary-main hover:bg-primary-main-dark text-success-light flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <g clip-path="url(#clip0_37995_40602_4)">
                  <path
                    d="M6.6665 13.3333L13.9333 12.7278C16.207 12.5383 16.7174 12.0417 16.9694 9.77406L17.4998 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M5 5L18.3333 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <circle
                    cx="4.99967"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <circle
                    cx="14.1667"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <path
                    d="M6.66667 16.6666L12.5 16.6666"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M1.6665 1.66663L2.47151 1.66663C3.25874 1.66663 3.94495 2.18712 4.13589 2.92907L6.61527 12.5637C6.74057 13.0506 6.63334 13.5664 6.32337 13.9679L5.52661 15"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_37995_40602_4">
                    <rect width="20" height="20" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Add to Cart
            </button>
          </div>
        </article>

        <article
          class="wow animate__fadeInUp swiper-slide"
          data-wow-duration="1.2s"
          data-wow-delay="0.4s"
        >
          <div
            class="flex flex-col gap-3.5 rounded-xl border border-gray-300 p-4"
          >
            <div class="relative">
              <a
                href="{{ url('/shop') }}"
                class="relative block overflow-hidden rounded-lg"
              >
                <img
                  src="{{ asset('frontend/assets/images/home-1/new-item/product-5.webp') }}"
                  class="w-full rounded-lg transition-transform duration-300 hover:scale-110"
                  alt="Bagora Travel Bag"
                />
              </a>
              <!-- Discount Badge -->
              <div class="absolute top-2 left-0 inline-block">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="67"
                  height="22"
                  viewBox="0 0 67 22"
                  fill="none"
                >
                  <path
                    d="M67 0L65.2314 1.86426L67 3.54199L65.2314 5.59277L67 7.27148L65.2314 9.13574L67 11L65.2314 12.8643L67 14.7285L65.2314 16.5928L67 18.458L65.2314 20.1357L67 22H0V0H67Z"
                    fill="#CB0233"
                  />
                </svg>
                <span
                  class="absolute inset-0 z-10 flex items-center justify-center text-xs font-medium text-white uppercase"
                >
                  30% off
                </span>
              </div>
              <!-- Wishlist -->
              <div x-data="{ liked: false }">
                <button
                  @click="liked = !liked"
                  :class="liked
      ? 'bg-error-dark text-white'
      : 'bg-white text-gray-secondary'"
                  class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full transition-all duration-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                  >
                    <path
                      d="M14.5969 2.99561C12.5857 1.76192 10.8303 2.25909 9.77576 3.05101C9.34339 3.37572 9.1272 3.53807 9 3.53807C8.8728 3.53807 8.65661 3.37572 8.22424 3.05101C7.16971 2.25909 5.41431 1.76192 3.40308 2.99561C0.763551 4.6147 0.166291 9.95614 6.25465 14.4625C7.41429 15.3208 7.99411 15.75 9 15.75C10.0059 15.75 10.5857 15.3208 11.7454 14.4625C17.8337 9.95614 17.2364 4.6147 14.5969 2.99561Z"
                      stroke="currentColor"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
            <h3
              class="text-gray-primary hover:text-primary-main line-clamp-2 text-base leading-6 font-medium"
            >
              <a href="{{ url('/shop') }}">
                Bagora Campus Pro School Backpack
              </a>
            </h3>
            <div class="flex items-center gap-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
              >
                <path
                  d="M13.1701 15.75C13.0501 15.7505 12.9318 15.7222 12.8251 15.6675L9.00009 13.665L5.17509 15.6675C4.92169 15.8008 4.61453 15.7781 4.38341 15.6092C4.15228 15.4402 4.03751 15.1544 4.08759 14.8725L4.83759 10.65L1.74759 7.65003C1.55113 7.45398 1.479 7.16547 1.56009 6.90003C1.64877 6.6281 1.8844 6.43028 2.16759 6.39003L6.44259 5.76753L8.32509 1.92003C8.4504 1.66129 8.71259 1.49695 9.00009 1.49695C9.28758 1.49695 9.54977 1.66129 9.67509 1.92003L11.5801 5.76003L15.8551 6.38253C16.1383 6.42278 16.3739 6.6206 16.4626 6.89253C16.5437 7.15797 16.4715 7.44648 16.2751 7.64253L13.1851 10.6425L13.9351 14.865C13.9898 15.1521 13.8727 15.4448 13.6351 15.615C13.4993 15.7102 13.3357 15.7577 13.1701 15.75Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#919EAB"
                />
              </svg>
              <span class="text-gray-secondary text-sm"> (154) </span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-gray-primary text-base font-medium">৳990</span>
              <span class="text-gray-tertiary text-sm line-through">৳1,190</span>
            </div>
            <button
              class="bg-primary-main hover:bg-primary-main-dark text-success-light flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <g clip-path="url(#clip0_37995_40602_5)">
                  <path
                    d="M6.6665 13.3333L13.9333 12.7278C16.207 12.5383 16.7174 12.0417 16.9694 9.77406L17.4998 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M5 5L18.3333 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <circle
                    cx="4.99967"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <circle
                    cx="14.1667"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <path
                    d="M6.66667 16.6666L12.5 16.6666"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M1.6665 1.66663L2.47151 1.66663C3.25874 1.66663 3.94495 2.18712 4.13589 2.92907L6.61527 12.5637C6.74057 13.0506 6.63334 13.5664 6.32337 13.9679L5.52661 15"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_37995_40602_5">
                    <rect width="20" height="20" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Add to Cart
            </button>
          </div>
        </article>

        <article
          class="wow animate__fadeInUp swiper-slide"
          data-wow-duration="1.2s"
          data-wow-delay="0.5s"
        >
          <div
            class="flex flex-col gap-3.5 rounded-xl border border-gray-300 p-4"
          >
            <div class="relative">
              <a
                href="{{ url('/shop') }}"
                class="relative block overflow-hidden rounded-lg"
              >
                <img
                  src="{{ asset('frontend/assets/images/home-1/new-item/product-2.webp') }}"
                  class="w-full rounded-lg transition-transform duration-300 hover:scale-110"
                  alt="Bagora Bag"
                />
              </a>
              <!-- Discount Badge -->
              <div class="absolute top-2 left-0 inline-block">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="67"
                  height="22"
                  viewBox="0 0 67 22"
                  fill="none"
                >
                  <path
                    d="M67 0L65.2314 1.86426L67 3.54199L65.2314 5.59277L67 7.27148L65.2314 9.13574L67 11L65.2314 12.8643L67 14.7285L65.2314 16.5928L67 18.458L65.2314 20.1357L67 22H0V0H67Z"
                    fill="#CB0233"
                  />
                </svg>
                <span
                  class="absolute inset-0 z-10 flex items-center justify-center text-xs font-medium text-white uppercase"
                >
                  20% off
                </span>
              </div>
              <!-- Wishlist -->
              <div x-data="{ liked: false }">
                <button
                  @click="liked = !liked"
                  :class="liked
      ? 'bg-error-dark text-white'
      : 'bg-white text-gray-secondary'"
                  class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full transition-all duration-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                  >
                    <path
                      d="M14.5969 2.99561C12.5857 1.76192 10.8303 2.25909 9.77576 3.05101C9.34339 3.37572 9.1272 3.53807 9 3.53807C8.8728 3.53807 8.65661 3.37572 8.22424 3.05101C7.16971 2.25909 5.41431 1.76192 3.40308 2.99561C0.763551 4.6147 0.166291 9.95614 6.25465 14.4625C7.41429 15.3208 7.99411 15.75 9 15.75C10.0059 15.75 10.5857 15.3208 11.7454 14.4625C17.8337 9.95614 17.2364 4.6147 14.5969 2.99561Z"
                      stroke="currentColor"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
            <h3
              class="text-gray-primary hover:text-primary-main line-clamp-2 text-base leading-6 font-medium"
            >
              <a href="{{ url('/shop') }}">
                Bagora Compact Crossbody Bag
              </a>
            </h3>
            <div class="flex items-center gap-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
              >
                <path
                  d="M13.1701 15.75C13.0501 15.7505 12.9318 15.7222 12.8251 15.6675L9.00009 13.665L5.17509 15.6675C4.92169 15.8008 4.61453 15.7781 4.38341 15.6092C4.15228 15.4402 4.03751 15.1544 4.08759 14.8725L4.83759 10.65L1.74759 7.65003C1.55113 7.45398 1.479 7.16547 1.56009 6.90003C1.64877 6.6281 1.8844 6.43028 2.16759 6.39003L6.44259 5.76753L8.32509 1.92003C8.4504 1.66129 8.71259 1.49695 9.00009 1.49695C9.28758 1.49695 9.54977 1.66129 9.67509 1.92003L11.5801 5.76003L15.8551 6.38253C16.1383 6.42278 16.3739 6.6206 16.4626 6.89253C16.5437 7.15797 16.4715 7.44648 16.2751 7.64253L13.1851 10.6425L13.9351 14.865C13.9898 15.1521 13.8727 15.4448 13.6351 15.615C13.4993 15.7102 13.3357 15.7577 13.1701 15.75Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="15"
                viewBox="0 0 15 15"
                fill="none"
              >
                <path
                  d="M11.6427 14.2531C11.5228 14.2536 11.4045 14.2253 11.2977 14.1706L7.47274 12.1681L3.64774 14.1706C3.39434 14.3038 3.08719 14.2812 2.85606 14.1122C2.62494 13.9433 2.51017 13.6575 2.56024 13.3756L3.31024 9.15308L0.220242 6.15308C0.0237838 5.95703 -0.0483451 5.66852 0.0327416 5.40308C0.121425 5.13115 0.357059 4.93333 0.640242 4.89308L4.91524 4.27058L6.79774 0.423083C6.92306 0.16434 7.18525 0 7.47274 0C7.76023 0 8.02243 0.16434 8.14774 0.423083L10.0527 4.26308L14.3277 4.88558C14.6109 4.92583 14.8466 5.12365 14.9352 5.39558C15.0163 5.66102 14.9442 5.94953 14.7477 6.14558L11.6577 9.14558L12.4077 13.3681C12.4624 13.6552 12.3453 13.9479 12.1077 14.1181C11.9719 14.2133 11.8084 14.2607 11.6427 14.2531Z"
                  fill="#FFC107"
                />
              </svg>
              <span class="text-gray-secondary text-sm"> (245) </span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-gray-primary text-base font-medium"
                >৳1,290</span
              >
              <span class="text-gray-tertiary text-sm line-through"
                >৳1,490</span
              >
            </div>
            <button
              class="bg-primary-main hover:bg-primary-main-dark text-success-light flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <g clip-path="url(#clip0_37995_40602_2)">
                  <path
                    d="M6.6665 13.3333L13.9333 12.7278C16.207 12.5383 16.7174 12.0417 16.9694 9.77406L17.4998 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M5 5L18.3333 5"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <circle
                    cx="4.99967"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <circle
                    cx="14.1667"
                    cy="16.6667"
                    r="1.66667"
                    stroke="currentColor"
                    stroke-width="1.5"
                  />
                  <path
                    d="M6.66667 16.6666L12.5 16.6666"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M1.6665 1.66663L2.47151 1.66663C3.25874 1.66663 3.94495 2.18712 4.13589 2.92907L6.61527 12.5637C6.74057 13.0506 6.63334 13.5664 6.32337 13.9679L5.52661 15"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_37995_40602_2">
                    <rect width="20" height="20" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Add to Cart
            </button>
          </div>
        </article>
      </div>
    </div>

    <!-- Progress Bar & Navigation Controls -->
    <div class="mt-6">
      <div
        class="swiper-pagination new-launch-item-pagination !relative !mt-0 !w-full"
      ></div>
    </div>
  </div>
</section>
{{-- Blog --}}
{{-- ========================================================= --}}
{{-- LATEST BLOG --}}
{{-- ========================================================= --}}

@if(isset($latestBlogs) && $latestBlogs->isNotEmpty())

<section class="pt-8 pb-10 lg:pt-12 lg:pb-24">

    <div class="custom-container">

        {{-- Header --}}
        <div
            class="
                mb-6
                flex
                flex-row
                items-center
                justify-between
                lg:mb-12
            "
        >

            <h2
                class="
                    lg:text-32
                    text-gray-primary
                    text-2xl
                    font-bold
                    lg:leading-12
                "
            >
                Latest Blog
            </h2>


            <a
                href="{{ route('blog') }}"
                class="
                    text-gray-primary
                    hover:text-primary-main
                    text-sm
                    font-medium
                    transition
                "
            >
                View All
            </a>

        </div>



        {{-- Blog Grid --}}
        <div
            class="
                grid
                grid-cols-1
                gap-6
                md:grid-cols-2
                xl:grid-cols-4
            "
        >

            @foreach($latestBlogs as $blog)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Blog Date
                    |--------------------------------------------------------------------------
                    */

                    $blogDate = $blog->publish_date
                        ?? $blog->created_at;


                    /*
                    |--------------------------------------------------------------------------
                    | Blog Time
                    |--------------------------------------------------------------------------
                    */

                    $blogTime = $blog->publish_time
                        ? \Carbon\Carbon::parse(
                            $blog->publish_time
                        )->format('h:i A')
                        : optional(
                            $blog->created_at
                        )->format('h:i A');


                    /*
                    |--------------------------------------------------------------------------
                    | Short Description
                    |--------------------------------------------------------------------------
                    */

                    $blogExcerpt = $blog->short_description
                        ?: \Illuminate\Support\Str::limit(
                            strip_tags($blog->content),
                            115
                        );

                @endphp


                <article
                    class="
                        wow
                        animate__fadeInUp
                        flex
                        h-full
                        flex-col
                        rounded-2xl
                        border
                        border-gray-300
                        p-4
                    "
                >


                    {{-- Image --}}
                    <a
                        href="{{ route(
                            'blog.details',
                            ['slug' => $blog->slug]
                        ) }}"
                        class="
                            block
                            aspect-[4/3]
                            overflow-hidden
                            rounded-lg
                            bg-gray-100
                        "
                    >

                        @if($blog->thumbnail)

                            <img
                                src="{{ asset($blog->thumbnail) }}"
                                alt="{{ $blog->title }}"
                                loading="lazy"
                                class="
                                    h-full
                                    w-full
                                    rounded-lg
                                    object-cover
                                    transition-transform
                                    duration-300
                                    hover:scale-110
                                "
                            >

                        @else

                            <div
                                class="
                                    flex
                                    h-full
                                    w-full
                                    items-center
                                    justify-center
                                    text-sm
                                    text-gray-tertiary
                                "
                            >
                                No Image
                            </div>

                        @endif

                    </a>



                    {{-- Category --}}
                    @if($blog->category)

                        <a
                            href="{{ route(
                                'blog',
                                [
                                    'category' =>
                                        $blog->category->slug
                                ]
                            ) }}"
                            class="
                                text-success-dark-main
                                bg-success-dark/16
                                my-4
                                inline-flex
                                h-5
                                w-fit
                                items-center
                                justify-center
                                rounded
                                px-2
                                py-1
                                text-center
                                text-xs
                            "
                        >
                            {{ $blog->category->name }}
                        </a>

                    @else

                        <div class="my-4"></div>

                    @endif



                    {{-- Date + Views --}}
                    <div
                        class="
                            mb-4
                            flex
                            flex-wrap
                            items-center
                            gap-4
                        "
                    >


                        {{-- Date --}}
                        <div
                            class="
                                text-gray-secondary
                                flex
                                items-center
                                gap-2
                                text-xs
                            "
                        >

                            <svg
                                fill="none"
                                height="16"
                                viewBox="0 0 16 16"
                                width="16"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 1.33594V2.66927M4 1.33594V2.66927"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M2.33301 5.33594H13.6663"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M1.6665 8.16216C1.6665 5.25729 1.6665 3.80486 2.50125 2.90243C3.336 2 4.6795 2 7.3665 2H8.63317C11.3202 2 12.6637 2 13.4984 2.90243C14.3332 3.80486 14.3332 5.25729 14.3332 8.16216V8.5045C14.3332 11.4094 14.3332 12.8618 13.4984 13.7642C12.6637 14.6667 11.3202 14.6667 8.63317 14.6667H7.3665C4.6795 14.6667 3.336 14.6667 2.50125 13.7642C1.6665 12.8618 1.6665 11.4094 1.6665 8.5045V8.16216Z"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>


                            <span>

                                @if($blogDate)

                                    {{ $blogTime }},
                                    {{ $blogDate->format('d M Y') }}

                                @endif

                            </span>

                        </div>


                        <span
                            class="
                                bg-gray-tertiary/24
                                h-4
                                w-px
                            "
                        ></span>


                        {{-- Views --}}
                        <div
                            class="
                                text-gray-secondary
                                flex
                                items-center
                                gap-2
                                text-xs
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M2.5 12C4.5 7.5 7.7 5.25 12 5.25C16.3 5.25 19.5 7.5 21.5 12C19.5 16.5 16.3 18.75 12 18.75C7.7 18.75 4.5 16.5 2.5 12Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                            </svg>

                            <span>
                                {{ number_format($blog->views ?? 0) }}
                            </span>

                        </div>

                    </div>



                    {{-- Content --}}
                    <div class="flex flex-1 flex-col">

                        <h3 class="mb-3">

                            <a
                                href="{{ route(
                                    'blog.details',
                                    ['slug' => $blog->slug]
                                ) }}"
                                class="
                                    text-gray-primary
                                    hover:text-primary-main
                                    line-clamp-2
                                    text-lg
                                    leading-7
                                    font-medium
                                    transition
                                "
                            >
                                {{ $blog->title }}
                            </a>

                        </h3>


                        @if($blogExcerpt)

                            <p
                                class="
                                    text-gray-secondary
                                    mb-4
                                    line-clamp-3
                                    text-base
                                    leading-6
                                    tracking-tight
                                "
                            >
                                {{ $blogExcerpt }}
                            </p>

                        @endif


                        {{-- Read More --}}
                        <div class="mt-auto">

                            <a
                                href="{{ route(
                                    'blog.details',
                                    ['slug' => $blog->slug]
                                ) }}"
                                class="
                                    group
                                    bg-primary-main
                                    hover:bg-primary-main-dark
                                    text-success-light
                                    inline-flex
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-lg
                                    px-5
                                    py-3
                                    text-base
                                    font-medium
                                    transition-all
                                    hover:text-white
                                "
                            >

                                Read More


                                <svg
                                    class="
                                        transition-transform
                                        duration-500
                                        group-hover:rotate-45
                                    "
                                    fill="none"
                                    height="22"
                                    viewBox="0 0 22 22"
                                    width="22"
                                    xmlns="http://www.w3.org/2000/svg"
                                >

                                    <path
                                        d="M15.5833 6.41406L5.5 16.4974"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-width="1.5"
                                    />

                                    <path
                                        d="M10.0835 5.5H15.8335C16.1478 5.5 16.3049 5.5 16.4025 5.59763C16.5002 5.69526 16.5002 5.8524 16.5002 6.16667V11.9167"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                    />

                                </svg>

                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    </div>

</section>

@endif
</main>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const categorySlider = document.querySelector('.category-showcase-slider');

    if (!categorySlider || typeof window.Swiper === 'undefined') {
        return;
    }

    if (categorySlider.swiper) {
        categorySlider.swiper.destroy(true, true);
    }

    const totalCategorySlides =
        categorySlider.querySelectorAll('.swiper-slide').length;

    const shouldAutoScroll = totalCategorySlides > 4;

    const categorySwiper = new Swiper(categorySlider, {

        /*
        |--------------------------------------------------------------------------
        | Desktop = exactly 4 cards
        |--------------------------------------------------------------------------
        */
        slidesPerView: 1.25,
        spaceBetween: 14,

        speed: 5000,

        grabCursor: true,
        allowTouchMove: true,
        simulateTouch: true,
        watchOverflow: true,

        observer: true,
        observeParents: true,
        updateOnWindowResize: true,

        /*
        |--------------------------------------------------------------------------
        | Infinite continuous movement
        |--------------------------------------------------------------------------
        */
        loop: shouldAutoScroll,

        autoplay: shouldAutoScroll
            ? {
                delay: 0,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
                waitForTransition: false,
            }
            : false,

        /*
        |--------------------------------------------------------------------------
        | Responsive cards
        |--------------------------------------------------------------------------
        */
        breakpoints: {

            480: {
                slidesPerView: 2,
                spaceBetween: 16,
            },

            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },

            1024: {
                slidesPerView: 4,
                spaceBetween: 24,
            },

        },

        on: {

            init: function () {
                console.log('Bagora category slider initialized.');
            },

            touchEnd: function (swiper) {
                if (
                    shouldAutoScroll
                    &&
                    swiper.autoplay
                ) {
                    setTimeout(function () {
                        swiper.autoplay.start();
                    }, 700);
                }
            },

        },

    });

    /*
    |--------------------------------------------------------------------------
    | Resume autoplay after manual mouse interaction
    |--------------------------------------------------------------------------
    */
    categorySlider.addEventListener('mouseleave', function () {

        if (
            shouldAutoScroll
            &&
            categorySwiper.autoplay
        ) {
            categorySwiper.autoplay.start();
        }

    });

});
</script>

@endpush
