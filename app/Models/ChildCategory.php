<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ChildCategory extends Model
{
    use SoftDeletes;


    protected $fillable = [

        'category_id',

        'sub_category_id',

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

            'sub_category_id' => 'integer',

            'sort_order' => 'integer',

            'status' => 'boolean',

        ];
    }


    public function category()
    {
        return $this->belongsTo(
            Category::class
        )->withTrashed();
    }


    public function subCategory()
    {
        return $this->belongsTo(
            SubCategory::class,
            'sub_category_id'
        )->withTrashed();
    }
}