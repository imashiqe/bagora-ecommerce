<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubCategory extends Model
{
    use SoftDeletes;


    protected $fillable = [

        'category_id',

        'name',

        'slug',

        'image',

        'description',

        'sort_order',

        'status',

    ];


    protected function casts(): array
    {
        return [

            'category_id' => 'integer',

            'status' => 'boolean',

            'sort_order' => 'integer',

        ];
    }


    public function category()
    {
        return $this->belongsTo(
            Category::class
        )->withTrashed();
    }
}