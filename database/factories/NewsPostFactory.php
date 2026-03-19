<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsPostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => str($title)->slug()->append('-', fake()->numberBetween(100, 999))->toString(),
            'excerpt' => fake()->sentence(),
            'content' => fake()->paragraphs(4, true),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
