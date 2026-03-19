<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'path' => 'albums/'.fake()->uuid().'.jpg',
            'caption' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
