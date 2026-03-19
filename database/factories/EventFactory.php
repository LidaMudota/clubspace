<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => str($title)->slug()->append('-', fake()->numberBetween(100, 999))->toString(),
            'description' => fake()->paragraph(),
            'starts_at' => now()->addDays(fake()->numberBetween(1, 30)),
            'venue' => fake()->address(),
            'price' => fake()->numberBetween(1000, 15000),
            'capacity' => fake()->numberBetween(20, 300),
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
