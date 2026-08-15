<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_categories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->foreignId('sub_category_id')
                ->constrained('sub_categories')
                ->restrictOnDelete();

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->string('image')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('status')
                ->default(true);

            $table->softDeletes();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Short custom index name
            |--------------------------------------------------------------------------
            */

            $table->index(
                [
                    'category_id',
                    'sub_category_id',
                    'status',
                    'sort_order'
                ],
                'child_cat_filter_idx'
            );

        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'child_categories'
        );
    }
};