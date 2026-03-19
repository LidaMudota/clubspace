<?php

namespace App\Models;

use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = ['album_id', 'path', 'caption', 'sort_order'];

    protected static function newFactory(): Factory
    {
        return PhotoFactory::new();
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(PhotoAlbum::class, 'album_id');
    }
}
