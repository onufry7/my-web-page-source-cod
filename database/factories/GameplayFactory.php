<?php

namespace Database\Factories;

use App\Models\BoardGame;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameplayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'board_game_id' => BoardGame::factory(),
            'user_id' => User::factory(),
            'date' => Carbon::now()->format('Y-m-d'),
            'count' => fake()->numberBetween(1, 40),
        ];
    }
}
