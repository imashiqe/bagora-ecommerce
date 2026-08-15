<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKeyFeature extends Model
{
    protected $fillable = [

        'product_id',

        'feature',

        'sort_order',

    ];


    protected function casts(): array
    {
        return [

            'product_id' => 'integer',

            'sort_order' => 'integer',

        ];
    }


    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }
}