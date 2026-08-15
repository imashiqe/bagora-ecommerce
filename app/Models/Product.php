<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;


    protected $fillable = [

        'category_id',

        'sub_category_id',

        'child_category_id',

        'brand_id',

        'title',

        'slug',

        'sku',

        'model_no',

        'short_description',

        'description',

        'cost_price',

        'regular_price',

        'sale_price',

        'thumbnail',

        'keywords',

        'meta_title',

        'meta_description',

        'featured',

        'best_seller',

        'new_arrival',

        'status',

    ];


    protected function casts(): array
    {
        return [

            'category_id' => 'integer',

            'sub_category_id' => 'integer',

            'child_category_id' => 'integer',

            'brand_id' => 'integer',

            'cost_price' => 'decimal:2',

            'regular_price' => 'decimal:2',

            'sale_price' => 'decimal:2',

            'featured' => 'boolean',

            'best_seller' => 'boolean',

            'new_arrival' => 'boolean',

            'status' => 'boolean',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            Category::class
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Sub Category
    |--------------------------------------------------------------------------
    */

    public function subCategory()
    {
        return $this->belongsTo(
            SubCategory::class,
            'sub_category_id'
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Child Category
    |--------------------------------------------------------------------------
    */

    public function childCategory()
    {
        return $this->belongsTo(
            ChildCategory::class,
            'child_category_id'
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Brand
    |--------------------------------------------------------------------------
    */

    public function brand()
    {
        return $this->belongsTo(
            Brand::class
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Gallery Images
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(
            ProductImage::class
        )->orderBy(
            'sort_order'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Key Features
    |--------------------------------------------------------------------------
    */

    public function keyFeatures()
    {
        return $this->hasMany(
            ProductKeyFeature::class
        )->orderBy(
            'sort_order'
        );
    }
}