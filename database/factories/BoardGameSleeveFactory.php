<?php

namespace Database\Factories;

use App\Models\BoardGame;
use App\Models\Sleeve;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardGameSleeveFactory extends Factory
{
    public function definition(): array
    {
        $boardGame = BoardGame::factory()->create();
        $sleeve = Sleeve::factory()->create();

        return [
            'board_game_id' => $boardGame->getAttribute('id'),
            'sleeve_id' => $sleeve->getAttribute('id'),
            'quantity' => 100,
            'sleeved' => false,
        ];
    }
}
