<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CipherFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);

        return [
            'name' => $name,
            'sub_name' => fake()->words(rand(1, 2), true),
            'slug' => Str::slug($name, '-', 'pl'),
            'content' => fake()->randomHtml(),
            'cover' => fake()->imageUrl(),
        ];
    }
}
