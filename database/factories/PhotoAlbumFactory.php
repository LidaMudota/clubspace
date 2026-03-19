<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoAlbumFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(2);

        return [
            'title' => $title,
            'slug' => str($title)->slug()->append('-', fake()->numberBetween(100, 999))->toString(),
            'description' => fake()->paragraph(),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
