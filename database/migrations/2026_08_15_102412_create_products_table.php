<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Category Structure
            |--------------------------------------------------------------------------
            */

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->foreignId('sub_category_id')
                ->nullable()
                ->constrained('sub_categories')
                ->restrictOnDelete();

            $table->foreignId('child_category_id')
                ->nullable()
                ->constrained('child_categories')
                ->restrictOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Product Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->string('sku', 100)
                ->unique();

            $table->string('model_no', 100)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $table->text('short_description')
                ->nullable();

            $table->longText('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal(
                'cost_price',
                12,
                2
            )->default(0);

            $table->decimal(
                'regular_price',
                12,
                2
            )->default(0);

            $table->decimal(
                'sale_price',
                12,
                2
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | Main Image
            |--------------------------------------------------------------------------
            */

            $table->string('thumbnail')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            $table->text('keywords')
                ->nullable();

            $table->string('meta_title')
                ->nullable();

            $table->text('meta_description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Product Flags
            |--------------------------------------------------------------------------
            */

            $table->boolean('featured')
                ->default(false);

            $table->boolean('best_seller')
                ->default(false);

            $table->boolean('new_arrival')
                ->default(false);

            $table->boolean('status')
                ->default(true);


            /*
            |--------------------------------------------------------------------------
            | Soft Delete
            |--------------------------------------------------------------------------
            */

            $table->softDeletes();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(
                [
                    'category_id',
                    'status'
                ],
                'prod_cat_status_idx'
            );

            $table->index(
                [
                    'brand_id',
                    'status'
                ],
                'prod_brand_status_idx'
            );

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};