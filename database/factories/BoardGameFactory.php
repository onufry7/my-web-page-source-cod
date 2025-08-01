<?php

namespace Database\Factories;

use App\Enums\BoardGameType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BoardGameFactory extends Factory
{
    public function definition(): array
    {
        $minPlayer = fake()->numberBetween(1, 50);
        $name = fake()->unique()->sentence(3);

        return [
            'name' => $name,
            'slug' => Str::slug($name, '-', 'pl'),
            'description' => fake()->paragraph(),
            'publisher_id' => null,
            'original_publisher_id' => null,
            'age' => fake()->numberBetween(0, 100),
            'min_players' => $minPlayer,
            'max_players' => fake()->numberBetween($minPlayer, 50),
            'game_time' => fake()->numberBetween(1, 2000),
            'box_img' => fake()->imageUrl(),
            'instruction' => fake()->url(),
            'video_url' => fake()->url(),
            'bgg_url' => fake()->url(),
            'planszeo_url' => fake()->url(),
            'type' => BoardGameType::BaseGame->value,
            'base_game_id' => null,
            'need_instruction' => true,
            'need_insert' => false,
            'to_painting' => false,
        ];
    }
}
