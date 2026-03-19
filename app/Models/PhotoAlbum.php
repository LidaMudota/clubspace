<?php

namespace App\Models;

use Database\Factories\PhotoAlbumFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoAlbum extends Model
{
    protected $table = 'albums';

    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'description', 'cover_image', 'is_published', 'published_at'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'published_at' => 'datetime'];
    }

    protected static function newFactory(): Factory
    {
        return PhotoAlbumFactory::new();
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'album_id');
    }
}
