<?php

namespace Database\Factories;

use App\Enums\ProjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);

        return [
            'name' => $name,
            'slug' => Str::slug($name, '-', 'pl'),
            'url' => 'https://google.com',
            'git' => 'https://google.com',
            'category' => fake()->randomElement(array_column(ProjectCategory::cases(), 'value')),
            'image_path' => fake()->imageUrl(),
            'description' => fake()->boolean() ? fake()->sentences(rand(0, 25), true) : null,
            'for_registered' => fake()->boolean() ? 1 : 0,
        ];
    }
}
