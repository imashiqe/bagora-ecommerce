<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('blog_category_id')
                ->constrained('blog_categories')
                ->restrictOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('thumbnail')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('content');

            $table->string('author_name')->nullable();

            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();

            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->unsignedBigInteger('views')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index(
                ['blog_category_id', 'status'],
                'blog_cat_status_idx'
            );

            $table->index(
                ['status', 'publish_date'],
                'blog_publish_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};