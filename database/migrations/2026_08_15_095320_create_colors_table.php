<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->string('hex_code', 7)
                ->default('#000000');

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('status')
                ->default(true);

            $table->softDeletes();

            $table->timestamps();


            $table->index(
                [
                    'status',
                    'sort_order'
                ],
                'color_status_sort_idx'
            );

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};