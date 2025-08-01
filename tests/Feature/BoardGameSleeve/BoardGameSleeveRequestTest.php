<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Models\BoardGameSleeve;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BoardGameSleeveRequestTest extends BoardGameSleeveTestCase
{
    public function test_board_game_id_is_unique_for_given_sleeve_id(): void
    {
        $existingBoardGameSleeve = BoardGameSleeve::factory()->create();

        $validator = Validator::make([
            'board_game_id' => $existingBoardGameSleeve->board_game_id,
            'sleeve_id' => $existingBoardGameSleeve->sleeve_id,
        ], [
            'board_game_id' => [
                Rule::unique('board_game_sleeve', 'board_game_id')->where('sleeve_id', $existingBoardGameSleeve->sleeve_id),
            ],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_sleeve_id_is_unique_for_given_board_game_id(): void
    {
        $existingBoardGameSleeve = BoardGameSleeve::factory()->create();

        $validator = Validator::make([
            'board_game_id' => $existingBoardGameSleeve->board_game_id,
            'sleeve_id' => $existingBoardGameSleeve->sleeve_id,
        ], [
            'sleeve_id' => [
                Rule::unique('board_game_sleeve', 'sleeve_id')->where('board_game_id', $existingBoardGameSleeve->board_game_id),
            ],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_board_game_id_exists_in_board_games_table(): void
    {
        $nonExistingBoardGameId = 999;

        $validator = Validator::make([
            'board_game_id' => $nonExistingBoardGameId,
        ], [
            'board_game_id' => ['exists:board_games,id'],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_sleeve_id_exists_in_sleeves_table(): void
    {
        $nonExistingSleeveId = 999;

        $validator = Validator::make([
            'sleeve_id' => $nonExistingSleeveId,
        ], [
            'sleeve_id' => ['exists:sleeves,id'],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_quantity_is_required_and_integer_and_minimum_zero(): void
    {
        $data = [
            'quantity' => null,
        ];

        $validator = Validator::make($data, [
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $this->assertTrue($validator->fails());
    }
}
