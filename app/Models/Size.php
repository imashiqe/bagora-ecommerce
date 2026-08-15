<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;


    protected $fillable = [

        'name',

        'code',

        'slug',

        'sort_order',

        'status',

    ];


    protected function casts(): array
    {
        return [

            'sort_order' => 'integer',

            'status' => 'boolean',

        ];
    }
}