<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cart
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | CART PAGE
    |--------------------------------------------------------------------------
    */

public function index(): View
{
    $items = $this->cart->items();

    $subtotal = $this->cart->subtotal($items);

    return view('frontend.pages.cart', [
        'items' => $items,
        'subtotal' => $subtotal,
    ]);
}


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    public function add(
        Request $request,
        Product $product
    ): RedirectResponse {

        abort_unless(
            $product->status,
            404
        );


        $validated = $request->validate([

            'quantity' => [
                'nullable',
                'integer',
                'min:1',
                'max:99',
            ],

            'redirect_to' => [
                'nullable',
                'in:cart,checkout',
            ],

        ]);


        $this->cart->add(
            $product,
            (int) (
                $validated['quantity']
                ?? 1
            )
        );


        /*
        |--------------------------------------------------------------------------
        | BUY NOW
        |--------------------------------------------------------------------------
        */

        if (
            ($validated['redirect_to'] ?? null)
            === 'checkout'
        ) {

            return redirect()
                ->route('checkout');

        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL ADD TO CART
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Product added to cart.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CART
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {

        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:99',
            ],
        ]);


        $this->cart->update(
            $product,
            (int) $validated['quantity']
        );


        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Cart updated.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function remove(
        Product $product
    ): RedirectResponse {

        $this->cart->remove(
            $product
        );


        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Product removed from cart.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR CART
    |--------------------------------------------------------------------------
    */

    public function clear(): RedirectResponse
    {
        $this->cart->clear();


        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Cart cleared.'
            );
    }
}