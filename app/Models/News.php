<?php

namespace App\Models;

use Database\Factories\NewsPostFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'cover_image', 'is_published', 'published_at'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'published_at' => 'datetime'];
    }

    protected static function newFactory(): Factory
    {
        return NewsPostFactory::new();
    }
}
