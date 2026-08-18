<div
    x-data="{
        quantity: 1
    }"
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
        >

            <button
                type="button"
                @click="
                    quantity =
                        Math.max(
                            1,
                            quantity - 1
                        )
                "
                class="
                    flex
                    h-full
                    w-12
                    items-center
                    justify-center
                    text-xl
                    hover:bg-gray-100
                "
            >
                −
            </button>


            <input
                type="number"
                x-model.number="quantity"
                min="1"
                max="99"
                class="
                    h-full
                    w-12
                    border-0
                    bg-transparent
                    text-center
                    font-semibold
                    outline-none
                "
            >


            <button
                type="button"
                @click="
                    quantity =
                        Math.min(
                            99,
                            quantity + 1
                        )
                "
                class="
                    flex
                    h-full
                    w-12
                    items-center
                    justify-center
                    text-xl
                    hover:bg-gray-100
                "
            >
                +
            </button>

        </div>


        {{-- Add To Cart --}}
        <form
            method="POST"
            action="{{
                route(
                    'cart.add',
                    [
                        'product' =>
                            $product->id
                    ]
                )
            }}"
            class="flex-1"
            @submit="
                $refs.cartQuantity.value =
                    quantity
            "
        >

            @csrf


            <input
                x-ref="cartQuantity"
                type="hidden"
                name="quantity"
                value="1"
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
                    rounded-lg
                    px-5
                    text-sm
                    font-semibold
                    transition
                    hover:text-white
                "
            >
                Add to Cart
            </button>

        </form>

    </div>

</div>