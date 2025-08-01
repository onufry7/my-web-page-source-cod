<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SleeveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mark' => fake()->unique()->words(2, true),
            'name' => implode(' ', fake()->randomElements([fake()->word, fake()->word, fake()->word], fake()->numberBetween(1, 3))),
            'height' => fake()->numberBetween(25, 300),
            'width' => fake()->numberBetween(15, 300),
            'thickness' => fake()->numberBetween(25, 300),
            'image_path' => fake()->imageUrl(),
            'quantity_available' => fake()->numberBetween(0, 1000),
        ];
    }
}
