@extends('frontend.master')

@section('title', 'Shop')

@section('content')

@php
    $selectedCategory = request('category');
    $selectedBrand = request('brand');
    $selectedSort = request('sort', 'latest');
    $searchValue = request('q');
    $minPriceValue = request('min_price');
    $maxPriceValue = request('max_price');
@endphp


{{-- ========================================================= --}}
{{-- BREADCRUMB --}}
{{-- ========================================================= --}}

<nav class="py-6 lg:py-12">
    <div class="custom-container">
        <ul class="flex flex-wrap items-center gap-4 text-sm font-normal">

            <li>
                <a
                    href="{{ route('home') }}"
                    class="text-gray-primary flex items-center gap-2 transition hover:text-primary-main"
                >
                    <svg
                        fill="none"
                        height="20"
                        viewBox="0 0 20 20"
                        width="20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M2.5 8.33333L10 2.5L17.5 8.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V8.33333Z"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M7.5 17.5V10.8333H12.5V17.5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Home
                </a>
            </li>

            <li class="flex items-center justify-center">
                <span class="bg-gray-tertiary inline-block size-1 rounded-full"></span>
            </li>

            <li class="text-gray-tertiary">
                Shop
            </li>

        </ul>
    </div>
</nav>


{{-- ========================================================= --}}
{{-- SHOP --}}
{{-- ========================================================= --}}

<main>

    <section
        class="pb-12 lg:pb-24"
        x-data="{
            currentTab: 'grid',
            openMobileFilter: false
        }"
    >

        <div class="custom-container">

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">


                {{-- ========================================================= --}}
                {{-- DESKTOP FILTER SIDEBAR --}}
                {{-- ========================================================= --}}

                <aside class="col-span-full hidden self-start xl:col-span-3 xl:block">

                    <form
                        action="{{ route('shop') }}"
                        method="GET"
                        class="rounded-2xl border border-gray-300"
                    >

                        {{-- Filter Header --}}
                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-gray-300
                                px-6
                                py-4
                            "
                        >

                            <h2 class="text-gray-primary text-xl font-bold">
                                Filters
                            </h2>

                            <a
                                href="{{ route('shop') }}"
                                class="text-primary-main text-base font-medium"
                            >
                                Clear All
                            </a>

                        </div>


                        <div class="divide-gray-tertiary/24 divide-y p-4">


                            {{-- Search --}}
                            <div class="py-6 first:pt-0 last:pb-0">

                                <h3 class="text-gray-primary text-lg leading-6 font-medium">
                                    Search
                                </h3>

                                <div class="relative mt-4">

                                    <input
                                        type="text"
                                        name="q"
                                        value="{{ $searchValue }}"
                                        placeholder="Search products"
                                        class="
                                            border-gray-tertiary/32
                                            focus:ring-primary-main
                                            h-10
                                            w-full
                                            rounded-lg
                                            border
                                            px-3.5
                                            py-3
                                            pl-11
                                            focus:outline-0
                                        "
                                    >

                                    <span
                                        class="
                                            pointer-events-none
                                            absolute
                                            top-1/2
                                            left-3.5
                                            -translate-y-1/2
                                            text-gray-tertiary
                                        "
                                    >
                                        <svg
                                            fill="none"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            width="20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M17.5 17.5L22 22"
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                            />
                                            <path
                                                d="M20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11Z"
                                                stroke="currentColor"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                            />
                                        </svg>
                                    </span>

                                </div>

                            </div>


                            {{-- Category --}}
                            <div class="py-6 first:pt-0 last:pb-0">

                                <div class="flex justify-between gap-4">

                                    <h3 class="text-gray-primary text-lg leading-6 font-medium">
                                        Category
                                    </h3>

                                    @if($selectedCategory)
                                        <a
                                            href="{{ route('shop', request()->except(['category', 'page'])) }}"
                                            class="text-gray-secondary text-sm leading-6 underline"
                                        >
                                            Reset
                                        </a>
                                    @endif

                                </div>


                                <ul
                                    class="
                                        custom-scrollbar
                                        mt-4
                                        max-h-[280px]
                                        space-y-3
                                        overflow-y-auto
                                        pr-1
                                    "
                                >

                                    @foreach($categories as $category)

                                        <li>

                                            <label
                                                class="
                                                    flex
                                                    cursor-pointer
                                                    items-center
                                                    justify-between
                                                    gap-3
                                                "
                                            >

                                                <div class="flex min-w-0 items-center gap-2">

                                                    <input
                                                        type="radio"
                                                        name="category"
                                                        value="{{ $category->slug }}"
                                                        class="
                                                            size-4
                                                            accent-primary-main
                                                        "
                                                        @checked($selectedCategory === $category->slug)
                                                    >

                                                    <span
                                                        class="
                                                            text-gray-primary
                                                            truncate
                                                            text-base
                                                        "
                                                    >
                                                        {{ $category->name }}
                                                    </span>

                                                </div>

                                                <span class="text-gray-secondary text-sm">
                                                    ({{ $category->active_products_count ?? 0 }})
                                                </span>

                                            </label>

                                        </li>

                                    @endforeach

                                </ul>

                            </div>


                            {{-- Price --}}
                            <div class="py-6 first:pt-0 last:pb-0">

                                <div class="flex items-center justify-between gap-4">

                                    <h3 class="text-gray-primary text-lg leading-6 font-medium">
                                        Price Range
                                    </h3>

                                    @if($minPriceValue || $maxPriceValue)
                                        <a
                                            href="{{ route('shop', request()->except(['min_price', 'max_price', 'page'])) }}"
                                            class="text-gray-secondary text-sm leading-6 underline"
                                        >
                                            Reset
                                        </a>
                                    @endif

                                </div>


                                <div class="mt-4 grid grid-cols-2 gap-3">

                                    <div>
                                        <label class="mb-1 block text-xs text-gray-secondary">
                                            Min
                                        </label>

                                        <input
                                            type="number"
                                            name="min_price"
                                            min="0"
                                            value="{{ $minPriceValue }}"
                                            placeholder="৳0"
                                            class="
                                                border-gray-tertiary/32
                                                focus:ring-primary-main
                                                h-10
                                                w-full
                                                rounded-lg
                                                border
                                                px-3
                                                focus:outline-0
                                            "
                                        >
                                    </div>


                                    <div>
                                        <label class="mb-1 block text-xs text-gray-secondary">
                                            Max
                                        </label>

                                        <input
                                            type="number"
                                            name="max_price"
                                            min="0"
                                            value="{{ $maxPriceValue }}"
                                            placeholder="৳{{ number_format($availableMaxPrice, 0) }}"
                                            class="
                                                border-gray-tertiary/32
                                                focus:ring-primary-main
                                                h-10
                                                w-full
                                                rounded-lg
                                                border
                                                px-3
                                                focus:outline-0
                                            "
                                        >
                                    </div>

                                </div>

                            </div>


                            {{-- Brand --}}
                            <div class="py-6 first:pt-0 last:pb-0">

                                <div class="flex justify-between gap-4">

                                    <h3 class="text-gray-primary text-lg leading-6 font-medium">
                                        Brand
                                    </h3>

                                    @if($selectedBrand)
                                        <a
                                            href="{{ route('shop', request()->except(['brand', 'page'])) }}"
                                            class="text-gray-secondary text-sm leading-6 underline"
                                        >
                                            Reset
                                        </a>
                                    @endif

                                </div>


                                <ul
                                    class="
                                        custom-scrollbar
                                        mt-4
                                        max-h-[250px]
                                        space-y-3
                                        overflow-y-auto
                                        pr-1
                                    "
                                >

                                    @foreach($brands as $brand)

                                        <li>

                                            <label
                                                class="
                                                    flex
                                                    cursor-pointer
                                                    items-center
                                                    justify-between
                                                    gap-3
                                                "
                                            >

                                                <div class="flex min-w-0 items-center gap-2">

                                                    <input
                                                        type="radio"
                                                        name="brand"
                                                        value="{{ $brand->slug }}"
                                                        class="size-4 accent-primary-main"
                                                        @checked($selectedBrand === $brand->slug)
                                                    >

                                                    <span class="text-gray-primary truncate text-base">
                                                        {{ $brand->name }}
                                                    </span>

                                                </div>

                                                <span class="text-gray-secondary text-sm">
                                                    ({{ $brand->active_products_count ?? 0 }})
                                                </span>

                                            </label>

                                        </li>

                                    @endforeach

                                </ul>

                            </div>


                            {{-- Keep Current Sort --}}
                            @if($selectedSort && $selectedSort !== 'latest')
                                <input
                                    type="hidden"
                                    name="sort"
                                    value="{{ $selectedSort }}"
                                >
                            @endif

                        </div>


                        <div class="border-t border-gray-300 p-4">

                            <button
                                type="submit"
                                class="
                                    bg-primary-main
                                    hover:bg-primary-main-dark
                                    text-success-light
                                    flex
                                    h-11
                                    w-full
                                    items-center
                                    justify-center
                                    rounded-lg
                                    px-5
                                    text-sm
                                    font-semibold
                                    transition
                                    hover:text-white
                                "
                            >
                                Apply Filters
                            </button>

                        </div>

                    </form>

                </aside>



                {{-- ========================================================= --}}
                {{-- PRODUCTS AREA --}}
                {{-- ========================================================= --}}

                <div class="col-span-full xl:col-span-9">


                    {{-- Toolbar --}}
                    <div
                        class="
                            flex
                            flex-wrap
                            items-center
                            justify-between
                            gap-4
                            rounded-xl
                            border
                            border-gray-300
                            bg-white
                            p-3
                            sm:p-4
                        "
                    >

                        <div class="flex items-center gap-2 sm:gap-4">


                            {{-- Mobile Filters --}}
                            <button
                                type="button"
                                @click="openMobileFilter = true"
                                class="
                                    border-gray-tertiary/32
                                    text-gray-primary
                                    flex
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-lg
                                    border
                                    xl:hidden
                                "
                                aria-label="Open filters"
                            >

                                <svg
                                    fill="none"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    width="22"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M3 7H21M6 12H18M10 17H14"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </button>


                            {{-- Grid --}}
                            <button
                                type="button"
                                @click="currentTab = 'grid'"
                                :class="
                                    currentTab === 'grid'
                                        ? 'bg-primary-main text-success-light border-primary-main'
                                        : 'text-gray-secondary border-gray-tertiary/32'
                                "
                                class="
                                    flex
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-lg
                                    border
                                    transition
                                "
                                aria-label="Grid view"
                            >

                                <svg
                                    fill="none"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    width="22"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <rect
                                        x="3"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <rect
                                        x="14"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <rect
                                        x="3"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <rect
                                        x="14"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                </svg>

                            </button>


                            {{-- List --}}
                            <button
                                type="button"
                                @click="currentTab = 'list'"
                                :class="
                                    currentTab === 'list'
                                        ? 'bg-primary-main text-success-light border-primary-main'
                                        : 'text-gray-secondary border-gray-tertiary/32'
                                "
                                class="
                                    hidden
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-lg
                                    border
                                    transition
                                    sm:flex
                                "
                                aria-label="List view"
                            >

                                <svg
                                    fill="none"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    width="22"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M9 6H21M9 12H21M9 18H21"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    />
                                    <path
                                        d="M3 6H3.01M3 12H3.01M3 18H3.01"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </button>


                            <p class="text-gray-secondary hidden text-sm md:block">

                                @if($products->total() > 0)

                                    Showing
                                    {{ $products->firstItem() }}
                                    -
                                    {{ $products->lastItem() }}
                                    of
                                    {{ $products->total() }}
                                    results

                                @else

                                    0 results

                                @endif

                            </p>

                        </div>


                        {{-- Sort --}}
                        <form
                            action="{{ route('shop') }}"
                            method="GET"
                            class="flex items-center gap-2"
                        >

                            @foreach(request()->except(['sort', 'page']) as $key => $value)

                                @if(!is_array($value))
                                    <input
                                        type="hidden"
                                        name="{{ $key }}"
                                        value="{{ $value }}"
                                    >
                                @endif

                            @endforeach


                            <label
                                for="shop-sort"
                                class="hidden text-sm text-gray-secondary sm:block"
                            >
                                Sort
                            </label>


                            <select
                                id="shop-sort"
                                name="sort"
                                onchange="this.form.submit()"
                                class="
                                    border-gray-tertiary/24
                                    text-gray-secondary
                                    h-10
                                    rounded-lg
                                    border
                                    bg-white
                                    px-3
                                    text-sm
                                    focus:outline-none
                                "
                            >
                                <option value="latest" @selected($selectedSort === 'latest')>
                                    Latest
                                </option>

                                <option value="price_low" @selected($selectedSort === 'price_low')>
                                    Price: Low to High
                                </option>

                                <option value="price_high" @selected($selectedSort === 'price_high')>
                                    Price: High to Low
                                </option>

                                <option value="name_az" @selected($selectedSort === 'name_az')>
                                    Name: A-Z
                                </option>

                                <option value="name_za" @selected($selectedSort === 'name_za')>
                                    Name: Z-A
                                </option>

                                <option value="discount" @selected($selectedSort === 'discount')>
                                    Biggest Discount
                                </option>
                            </select>

                        </form>

                    </div>



                    {{-- ========================================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ========================================================= --}}

                    @if($products->isEmpty())

                        <div
                            class="
                                mt-8
                                flex
                                min-h-[350px]
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

                            <div
                                class="
                                    bg-primary-main/10
                                    text-primary-main
                                    mb-4
                                    flex
                                    size-16
                                    items-center
                                    justify-center
                                    rounded-full
                                "
                            >
                                <svg
                                    fill="none"
                                    height="30"
                                    viewBox="0 0 24 24"
                                    width="30"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M20 20L16.65 16.65M18 11C18 14.866 14.866 18 11 18C7.13401 18 4 14.866 4 11C4 7.13401 7.13401 4 11 4C14.866 4 18 7.13401 18 11Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    />
                                </svg>
                            </div>

                            <h2 class="text-gray-primary text-xl font-bold">
                                No products found
                            </h2>

                            <p class="text-gray-secondary mt-2 max-w-md text-sm">
                                Try changing your search, category, brand, or price filters.
                            </p>

                            <a
                                href="{{ route('shop') }}"
                                class="
                                    bg-primary-main
                                    text-success-light
                                    mt-5
                                    inline-flex
                                    rounded-lg
                                    px-5
                                    py-2.5
                                    text-sm
                                    font-semibold
                                "
                            >
                                Clear Filters
                            </a>

                        </div>

                    @else


                        {{-- ========================================================= --}}
                        {{-- GRID VIEW --}}
                        {{-- ========================================================= --}}

                        <div
                            class="mt-8"
                            x-show="currentTab === 'grid'"
                        >

                            <div
                                class="
                                    grid
                                    grid-cols-2
                                    gap-3
                                    sm:gap-5
                                    md:grid-cols-3
                                    xl:grid-cols-4
                                    xl:gap-6
                                "
                            >

                                @foreach($products as $product)

                                    @include(
                                        'frontend.partials.product-card',
                                        ['product' => $product]
                                    )

                                @endforeach

                            </div>

                        </div>



                        {{-- ========================================================= --}}
                        {{-- LIST VIEW --}}
                        {{-- ========================================================= --}}

                        <div
                            class="mt-8"
                            x-show="currentTab === 'list'"
                            x-cloak
                        >

                            <div class="space-y-5">

                                @foreach($products as $product)

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
                                    @endphp


                                    <article
                                        class="
                                            flex
                                            flex-col
                                            gap-4
                                            rounded-xl
                                            border
                                            border-gray-300
                                            bg-white
                                            p-4
                                            sm:flex-row
                                        "
                                    >

                                        {{-- Image --}}
                                        <a
                                            href="{{ route('product.details', ['slug' => $product->slug]) }}"
                                            class="
                                                relative
                                                flex
                                                w-full
                                                shrink-0
                                                items-center
                                                justify-center
                                                overflow-hidden
                                                rounded-xl
                                                bg-gray-50
                                                sm:size-44
                                            "
                                        >

                                            @if($product->thumbnail)

                                                <img
                                                    src="{{ asset($product->thumbnail) }}"
                                                    alt="{{ $product->title }}"
                                                    class="
                                                        aspect-square
                                                        h-full
                                                        w-full
                                                        object-cover
                                                        transition-transform
                                                        duration-300
                                                        hover:scale-105
                                                    "
                                                >

                                            @else

                                                <div
                                                    class="
                                                        flex
                                                        aspect-square
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


                                            @if($hasDiscount)

                                                <span
                                                    class="
                                                        bg-error-dark
                                                        absolute
                                                        top-3
                                                        left-3
                                                        rounded
                                                        px-2
                                                        py-1
                                                        text-xs
                                                        font-semibold
                                                        text-white
                                                    "
                                                >
                                                    -{{ $discountPercent }}%
                                                </span>

                                            @endif

                                        </a>


                                        {{-- Details --}}
                                        <div class="flex min-w-0 flex-1 flex-col justify-between">

                                            <div>

                                                <div
                                                    class="
                                                        mb-2
                                                        flex
                                                        flex-wrap
                                                        items-center
                                                        gap-2
                                                        text-xs
                                                        text-gray-tertiary
                                                    "
                                                >

                                                    @if($product->category)
                                                        <span>
                                                            {{ $product->category->name }}
                                                        </span>
                                                    @endif


                                                    @if($product->category && $product->brand)
                                                        <span>•</span>
                                                    @endif


                                                    @if($product->brand)
                                                        <span>
                                                            {{ $product->brand->name }}
                                                        </span>
                                                    @endif

                                                </div>


                                                <h3
                                                    class="
                                                        text-gray-primary
                                                        text-lg
                                                        font-semibold
                                                        transition
                                                        hover:text-primary-main
                                                    "
                                                >
                                                    <a
                                                        href="{{ route('product.details', ['slug' => $product->slug]) }}"
                                                    >
                                                        {{ $product->title }}
                                                    </a>
                                                </h3>


                                                @if($product->short_description)

                                                    <p
                                                        class="
                                                            text-gray-secondary
                                                            mt-3
                                                            line-clamp-2
                                                            text-sm
                                                            leading-6
                                                        "
                                                    >
                                                        {{ $product->short_description }}
                                                    </p>

                                                @endif

                                            </div>


                                            <div
                                                class="
                                                    mt-5
                                                    flex
                                                    flex-wrap
                                                    items-center
                                                    justify-between
                                                    gap-4
                                                "
                                            >

                                                <div class="flex items-center gap-2">

                                                    <span
                                                        class="
                                                            text-gray-primary
                                                            text-xl
                                                            font-bold
                                                        "
                                                    >
                                                        ৳{{ number_format($currentPrice, 0) }}
                                                    </span>


                                                    @if($hasDiscount)

                                                        <span
                                                            class="
                                                                text-sm
                                                                text-gray-tertiary
                                                                line-through
                                                            "
                                                        >
                                                            ৳{{ number_format($regularPrice, 0) }}
                                                        </span>

                                                    @endif

                                                </div>


                                                <a
                                                    href="{{ route('product.details', ['slug' => $product->slug]) }}"
                                                    class="
                                                        bg-primary-main
                                                        hover:bg-primary-main-dark
                                                        text-success-light
                                                        inline-flex
                                                        items-center
                                                        justify-center
                                                        rounded-lg
                                                        px-5
                                                        py-2.5
                                                        text-sm
                                                        font-semibold
                                                        transition
                                                        hover:text-white
                                                    "
                                                >
                                                    View Product
                                                </a>

                                            </div>

                                        </div>

                                    </article>

                                @endforeach

                            </div>

                        </div>



                        {{-- ========================================================= --}}
                        {{-- PAGINATION --}}
                        {{-- ========================================================= --}}

                        @if($products->hasPages())

                            <div class="mt-10">
                                {{ $products->links() }}
                            </div>

                        @endif

                    @endif

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- MOBILE FILTER DRAWER --}}
        {{-- ========================================================= --}}

        <div
            x-show="openMobileFilter"
            x-cloak
            class="fixed inset-0 z-[120] xl:hidden"
        >

            {{-- Backdrop --}}
            <div
                class="absolute inset-0 bg-black/50"
                @click="openMobileFilter = false"
            ></div>


            {{-- Drawer --}}
            <div
                class="
                    absolute
                    top-0
                    bottom-0
                    left-0
                    w-[90%]
                    max-w-[380px]
                    overflow-y-auto
                    bg-white
                    shadow-2xl
                "
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-250"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
            >

                <form
                    action="{{ route('shop') }}"
                    method="GET"
                >

                    <div
                        class="
                            sticky
                            top-0
                            z-10
                            flex
                            items-center
                            justify-between
                            border-b
                            border-gray-300
                            bg-white
                            px-5
                            py-4
                        "
                    >

                        <h2 class="text-gray-primary text-xl font-bold">
                            Filters
                        </h2>

                        <button
                            type="button"
                            @click="openMobileFilter = false"
                            class="
                                text-gray-secondary
                                flex
                                size-9
                                items-center
                                justify-center
                                rounded-full
                                hover:bg-gray-100
                            "
                        >
                            <svg
                                fill="none"
                                height="24"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M19 5L5 19M5 5L19 19"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </button>

                    </div>


                    <div class="divide-gray-tertiary/24 divide-y p-5">


                        {{-- Mobile Search --}}
                        <div class="py-5 first:pt-0">

                            <h3 class="text-gray-primary text-lg font-medium">
                                Search
                            </h3>

                            <input
                                type="text"
                                name="q"
                                value="{{ $searchValue }}"
                                placeholder="Search products"
                                class="
                                    border-gray-tertiary/32
                                    mt-3
                                    h-11
                                    w-full
                                    rounded-lg
                                    border
                                    px-4
                                    focus:outline-none
                                "
                            >

                        </div>


                        {{-- Mobile Category --}}
                        <div class="py-5">

                            <h3 class="text-gray-primary text-lg font-medium">
                                Category
                            </h3>

                            <div class="mt-3 space-y-3">

                                @foreach($categories as $category)

                                    <label class="flex items-center justify-between gap-3">

                                        <div class="flex min-w-0 items-center gap-2">

                                            <input
                                                type="radio"
                                                name="category"
                                                value="{{ $category->slug }}"
                                                class="size-4 accent-primary-main"
                                                @checked($selectedCategory === $category->slug)
                                            >

                                            <span class="truncate text-sm text-gray-primary">
                                                {{ $category->name }}
                                            </span>

                                        </div>

                                        <span class="text-xs text-gray-tertiary">
                                            {{ $category->active_products_count ?? 0 }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>


                        {{-- Mobile Price --}}
                        <div class="py-5">

                            <h3 class="text-gray-primary text-lg font-medium">
                                Price Range
                            </h3>

                            <div class="mt-3 grid grid-cols-2 gap-3">

                                <input
                                    type="number"
                                    name="min_price"
                                    min="0"
                                    value="{{ $minPriceValue }}"
                                    placeholder="Min"
                                    class="
                                        border-gray-tertiary/32
                                        h-11
                                        w-full
                                        rounded-lg
                                        border
                                        px-3
                                        focus:outline-none
                                    "
                                >

                                <input
                                    type="number"
                                    name="max_price"
                                    min="0"
                                    value="{{ $maxPriceValue }}"
                                    placeholder="Max"
                                    class="
                                        border-gray-tertiary/32
                                        h-11
                                        w-full
                                        rounded-lg
                                        border
                                        px-3
                                        focus:outline-none
                                    "
                                >

                            </div>

                        </div>


                        {{-- Mobile Brand --}}
                        <div class="py-5">

                            <h3 class="text-gray-primary text-lg font-medium">
                                Brand
                            </h3>

                            <div class="mt-3 space-y-3">

                                @foreach($brands as $brand)

                                    <label class="flex items-center justify-between gap-3">

                                        <div class="flex min-w-0 items-center gap-2">

                                            <input
                                                type="radio"
                                                name="brand"
                                                value="{{ $brand->slug }}"
                                                class="size-4 accent-primary-main"
                                                @checked($selectedBrand === $brand->slug)
                                            >

                                            <span class="truncate text-sm text-gray-primary">
                                                {{ $brand->name }}
                                            </span>

                                        </div>

                                        <span class="text-xs text-gray-tertiary">
                                            {{ $brand->active_products_count ?? 0 }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>


                        <input
                            type="hidden"
                            name="sort"
                            value="{{ $selectedSort }}"
                        >

                    </div>


                    <div
                        class="
                            sticky
                            bottom-0
                            flex
                            gap-3
                            border-t
                            border-gray-300
                            bg-white
                            p-4
                        "
                    >

                        <a
                            href="{{ route('shop') }}"
                            class="
                                flex
                                h-11
                                flex-1
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
                            Clear
                        </a>


                        <button
                            type="submit"
                            class="
                                bg-primary-main
                                text-success-light
                                h-11
                                flex-1
                                rounded-lg
                                text-sm
                                font-semibold
                            "
                        >
                            Apply
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</main>

@endsection


@push('styles')

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

@endpush