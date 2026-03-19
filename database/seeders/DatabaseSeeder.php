<?php

namespace Database\Seeders;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\NewsPost;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(['email' => 'admin@clubspace.local'], [
            'name' => 'Clubspace Admin',
            'password' => 'password',
        ]);

        Event::factory(5)->create(['status' => EventStatus::Published]);
        NewsPost::factory(5)->create(['is_published' => true, 'published_at' => now()]);

        PhotoAlbum::factory(3)->create(['is_published' => true, 'published_at' => now()])
            ->each(fn (PhotoAlbum $album) => Photo::factory(5)->create(['album_id' => $album->id]));
    }
}
