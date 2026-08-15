<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CouponController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): View {

        $search = trim(
            (string) $request->query(
                'search',
                ''
            )
        );


        $coupons = Coupon::query()

            ->when(
                $search !== '',
                function ($query) use ($search) {

                    $query->where(
                        function ($q) use ($search) {

                            $q->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )

                            ->orWhere(
                                'code',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    );

                }
            )

            ->latest('id')

            ->paginate(20)

            ->withQueryString();


        return view(
            'backend.coupons.index',
            compact(
                'coupons',
                'search'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view(
            'backend.coupons.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $validated =
            $this->validateCoupon(
                $request
            );


        Coupon::create([

            'name' =>
                trim(
                    $validated['name']
                ),


            'code' =>
                $this->normalizeCode(
                    $validated['code']
                ),


            'description' =>
                $validated['description']
                ?? null,


            'type' =>
                $validated['type'],


            'value' =>
                $validated['value'],


            'min_order_amount' =>
                $validated['min_order_amount']
                ?? 0,


            'max_discount_amount' =>
                $validated['type'] === 'percentage'

                    ? (
                        $validated['max_discount_amount']
                        ?? null
                    )

                    : null,


            'usage_limit' =>
                $validated['usage_limit']
                ?? null,


            'usage_count' =>
                0,


            'per_customer_limit' =>
                $validated['per_customer_limit']
                ?? 1,


            'starts_at' =>
                $validated['starts_at']
                ?? null,


            'expires_at' =>
                $validated['expires_at']
                ?? null,


            'status' =>
                $request->boolean(
                    'status'
                ),

        ]);


        return redirect()

            ->route(
                'admin.coupons.index'
            )

            ->with(
                'success',
                'Coupon created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        Coupon $coupon
    ): RedirectResponse {

        return redirect()

            ->route(
                'admin.coupons.edit',
                $coupon
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        Coupon $coupon
    ): View {

        return view(
            'backend.coupons.edit',
            compact('coupon')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Coupon $coupon
    ): RedirectResponse {

        $validated =
            $this->validateCoupon(
                $request,
                $coupon
            );


        $coupon->update([

            'name' =>
                trim(
                    $validated['name']
                ),


            'code' =>
                $this->normalizeCode(
                    $validated['code']
                ),


            'description' =>
                $validated['description']
                ?? null,


            'type' =>
                $validated['type'],


            'value' =>
                $validated['value'],


            'min_order_amount' =>
                $validated['min_order_amount']
                ?? 0,


            'max_discount_amount' =>
                $validated['type'] === 'percentage'

                    ? (
                        $validated['max_discount_amount']
                        ?? null
                    )

                    : null,


            'usage_limit' =>
                $validated['usage_limit']
                ?? null,


            'per_customer_limit' =>
                $validated['per_customer_limit']
                ?? 1,


            'starts_at' =>
                $validated['starts_at']
                ?? null,


            'expires_at' =>
                $validated['expires_at']
                ?? null,


            'status' =>
                $request->boolean(
                    'status'
                ),

        ]);


        return redirect()

            ->route(
                'admin.coupons.index'
            )

            ->with(
                'success',
                'Coupon updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Coupon $coupon
    ): RedirectResponse {

        $coupon->delete();


        return redirect()

            ->route(
                'admin.coupons.index'
            )

            ->with(
                'success',
                'Coupon moved to trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Trashed
    |--------------------------------------------------------------------------
    */

    public function trashed(): View
    {
        $coupons = Coupon::onlyTrashed()

            ->orderByDesc(
                'deleted_at'
            )

            ->paginate(20);


        return view(
            'backend.coupons.trashed',
            compact('coupons')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Restore
    |--------------------------------------------------------------------------
    */

    public function restore(
        int $id
    ): RedirectResponse {

        $coupon =
            Coupon::onlyTrashed()
                ->findOrFail($id);


        $coupon->restore();


        return redirect()

            ->route(
                'admin.coupons.trashed'
            )

            ->with(
                'success',
                'Coupon restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Forever
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $id
    ): RedirectResponse {

        $coupon =
            Coupon::onlyTrashed()
                ->findOrFail($id);


        $coupon->forceDelete();


        return redirect()

            ->route(
                'admin.coupons.trashed'
            )

            ->with(
                'success',
                'Coupon permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    private function validateCoupon(
        Request $request,
        ?Coupon $coupon = null
    ): array {

        $rules = [

            'name' => [
                'required',
                'string',
                'max:255',
            ],


            'code' => [

                'required',

                'string',

                'max:100',

                'regex:/^[A-Za-z0-9_-]+$/',

                Rule::unique(
                    'coupons',
                    'code'
                )->ignore(
                    $coupon?->id
                ),

            ],


            'description' => [
                'nullable',
                'string',
            ],


            'type' => [
                'required',
                Rule::in([
                    'fixed',
                    'percentage',
                ]),
            ],


            'value' => [
                'required',
                'numeric',
                'min:0.01',
            ],


            'min_order_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'max_discount_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],


            'per_customer_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],


            'starts_at' => [
                'nullable',
                'date',
            ],


            'expires_at' => [
                'nullable',
                'date',
            ],


            'status' => [
                'nullable',
                'boolean',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Percentage cannot exceed 100
        |--------------------------------------------------------------------------
        */

        if (
            $request->input('type')
            ===
            'percentage'
        ) {

            $rules['value'][] =
                'max:100';

        }


        /*
        |--------------------------------------------------------------------------
        | Expiry must be >= Start
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'starts_at'
            )
        ) {

            $rules['expires_at'][] =
                'after_or_equal:starts_at';

        }


        return $request->validate(
            $rules
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Code
    |--------------------------------------------------------------------------
    */

    private function normalizeCode(
        string $code
    ): string {

        $code =
            trim($code);


        $code =
            preg_replace(
                '/\s+/',
                '-',
                $code
            );


        return strtoupper(
            $code
        );
    }
}