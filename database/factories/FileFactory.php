<?php

namespace Database\Factories;

use App\Models\BoardGame;
use App\Models\Cipher;
use App\Models\Project;
use App\Models\Sleeve;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        $class = fake()->randomElement([BoardGame::class, Cipher::class, Sleeve::class, Project::class]);
        $modelInstance = is_string($class) && class_exists($class)
            ? $class::factory()->create()
            : BoardGame::factory()->create();

        return [
            'name' => fake()->word(),
            'path' => fake()->filePath(),
            'model_id' => $modelInstance->id,
            'model_type' => $class,
        ];
    }
}
