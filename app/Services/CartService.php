<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    public function raw(): array
    {
        return session()->get('cart', []);
    }


    public function add(
        Product $product,
        int $quantity = 1
    ): void {
        $quantity = max(
            1,
            min(99, $quantity)
        );

        $cart = $this->raw();

        $oldQuantity =
            isset($cart[$product->id])
                ? (int) ($cart[$product->id]['quantity'] ?? 0)
                : 0;

        $cart[$product->id] = [
            'quantity' => min(
                99,
                $oldQuantity + $quantity
            ),
        ];

        session()->put(
            'cart',
            $cart
        );
    }


    public function update(
        Product $product,
        int $quantity
    ): void {
        $cart = $this->raw();

        if (!isset($cart[$product->id])) {
            return;
        }

        if ($quantity <= 0) {
            $this->remove($product);
            return;
        }

        $cart[$product->id]['quantity'] =
            max(
                1,
                min(99, $quantity)
            );

        session()->put(
            'cart',
            $cart
        );
    }


    public function remove(
        Product $product
    ): void {
        $cart = $this->raw();

        unset(
            $cart[$product->id]
        );

        session()->put(
            'cart',
            $cart
        );
    }


    public function clear(): void
    {
        session()->forget('cart');
    }


    public function count(): int
    {
        return collect(
            $this->raw()
        )->sum(
            fn ($row) =>
                (int) ($row['quantity'] ?? 0)
        );
    }


    public function items(): Collection
    {
        $cart = $this->raw();

        if (empty($cart)) {
            return collect();
        }

        $ids = array_map(
            'intval',
            array_keys($cart)
        );

        $products = Product::query()
            ->with([
                'category',
                'brand',
            ])
            ->where('status', true)
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');


        return collect($cart)
            ->map(
                function (
                    array $row,
                    $productId
                ) use ($products) {

                    $product =
                        $products->get(
                            (int) $productId
                        );

                    if (!$product) {
                        return null;
                    }

                    return $this->makeItem(
                        $product,
                        (int) (
                            $row['quantity']
                            ?? 1
                        )
                    );
                }
            )
            ->filter()
            ->values();
    }


    public function makeItem(
        Product $product,
        int $quantity = 1
    ): array {
        $quantity = max(
            1,
            min(99, $quantity)
        );

        $regularPrice =
            (float) $product->regular_price;

        $salePrice =
            $product->sale_price !== null
                ? (float) $product->sale_price
                : null;


        $unitPrice =
            (
                $salePrice !== null
                &&
                $salePrice > 0
                &&
                $salePrice < $regularPrice
            )
                ? $salePrice
                : $regularPrice;


        return [
            'product' =>
                $product,

            'quantity' =>
                $quantity,

            'unit_price' =>
                $unitPrice,

            'subtotal' =>
                $unitPrice * $quantity,
        ];
    }


    public function subtotal(
        ?Collection $items = null
    ): float {
        $items ??=
            $this->items();

        return (float)
            $items->sum('subtotal');
    }
}