<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('code', 100)
                ->unique();

            $table->text('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Discount
            |--------------------------------------------------------------------------
            */

            $table->string('type', 20);

            $table->decimal(
                'value',
                12,
                2
            );


            /*
            |--------------------------------------------------------------------------
            | Conditions
            |--------------------------------------------------------------------------
            */

            $table->decimal(
                'min_order_amount',
                12,
                2
            )->default(0);

            $table->decimal(
                'max_discount_amount',
                12,
                2
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | Usage
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger(
                'usage_limit'
            )->nullable();

            $table->unsignedInteger(
                'usage_count'
            )->default(0);

            $table->unsignedInteger(
                'per_customer_limit'
            )->default(1);


            /*
            |--------------------------------------------------------------------------
            | Validity
            |--------------------------------------------------------------------------
            */

            $table->dateTime(
                'starts_at'
            )->nullable();

            $table->dateTime(
                'expires_at'
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean(
                'status'
            )->default(true);


            /*
            |--------------------------------------------------------------------------
            | Soft Delete
            |--------------------------------------------------------------------------
            */

            $table->softDeletes();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index(
                [
                    'status',
                    'starts_at',
                    'expires_at',
                ],
                'coupon_status_date_idx'
            );

        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'coupons'
        );
    }
};