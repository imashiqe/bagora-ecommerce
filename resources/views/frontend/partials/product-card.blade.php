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
                        block
                        h-full
                        w-full
                        object-cover
                        transition-transform
                        duration-500
                        group-hover:scale-105
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
                        text-gray-400
                    "
                >
                    No Image
                </div>

            @endif

        </a>


        @if($hasDiscount)

            <span
                class="
                    absolute
                    top-3
                    left-3
                    z-10
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
            </span>

        @endif


        @if($product->best_seller)

            <span
                class="
                    absolute
                    bottom-3
                    left-3
                    z-10
                    rounded-full
                    bg-white/95
                    px-2.5
                    py-1
                    text-[10px]
                    font-semibold
                    tracking-wide
                    text-primary-main
                    shadow-sm
                "
            >
                BEST SELLER
            </span>

        @endif

    </div>


    <div class="flex flex-1 flex-col p-3 sm:p-4">

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

            <a href="{{ url('/shop?product=' . $product->slug) }}">
                {{ $product->title }}
            </a>

        </h3>


        <div class="mt-auto">

            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                <span class="text-base font-bold text-gray-primary sm:text-lg">
                    ৳{{ number_format($currentPrice, 0) }}
                </span>


                @if($hasDiscount)

                    <span class="text-xs text-gray-tertiary line-through sm:text-sm">
                        ৳{{ number_format($regularPrice, 0) }}
                    </span>

                @endif

            </div>

        </div>


        <a
            href="{{ url('/shop?product=' . $product->slug) }}"
            class="
                mt-4
                flex
                w-full
                items-center
                justify-center
                rounded-lg
                bg-primary-main
                px-3
                py-2.5
                text-xs
                font-semibold
                text-success-light
                transition
                hover:bg-primary-main-dark
                hover:text-white
                sm:text-sm
            "
        >
            View Product
        </a>

    </div>

</article>
