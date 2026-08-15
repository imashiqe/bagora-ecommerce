<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'name',

        'code',

        'description',

        'type',

        'value',

        'min_order_amount',

        'max_discount_amount',

        'usage_limit',

        'usage_count',

        'per_customer_limit',

        'starts_at',

        'expires_at',

        'status',

    ];


    protected function casts(): array
    {
        return [

            'value' => 'decimal:2',

            'min_order_amount' => 'decimal:2',

            'max_discount_amount' => 'decimal:2',

            'usage_limit' => 'integer',

            'usage_count' => 'integer',

            'per_customer_limit' => 'integer',

            'starts_at' => 'datetime',

            'expires_at' => 'datetime',

            'status' => 'boolean',

        ];
    }
}