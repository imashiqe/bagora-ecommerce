<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'blog_category_id',

        'title',
        'slug',

        'thumbnail',

        'short_description',
        'content',

        'author_name',

        'publish_date',
        'publish_time',

        'featured',
        'status',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'views',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',

            'featured' => 'boolean',
            'status' => 'boolean',

            'views' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            BlogCategory::class,
            'blog_category_id'
        )->withTrashed();
    }
}