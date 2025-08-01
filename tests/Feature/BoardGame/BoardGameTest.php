<?php

namespace Tests\Feature\BoardGame;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use Illuminate\Support\Facades\Storage;

class BoardGameTest extends BoardGameTestCase
{
    public function test_get_instruction_size_returns_correct_size(): void
    {
        $model = new BoardGame();
        $model->instruction = 'instructions/manual.pdf';

        Storage::fake('public');
        Storage::disk('public')->put('instructions/manual.pdf', str_repeat('A', 2 * 1024 * 1024)); // 2 MB

        $this->assertEquals('2,00 MB', $model->getInstructionSize());
    }

    public function test_get_instruction_size_returns_zero_for_missing_file(): void
    {
        $model = new BoardGame();
        $model->instruction = 'instructions/missing.pdf';

        Storage::fake('public');

        $this->assertEquals('0 MB', $model->getInstructionSize());
    }

    public function test_get_instruction_size_returns_zero_for_empty_instruction(): void
    {
        $model = new BoardGame();
        $model->instruction = null;

        $this->assertEquals('0 MB', $model->getInstructionSize());
    }

    public function test_get_alt_min_players_from_expansion_returns_null_when_base_game_dont_have_expansion(): void
    {
        $model = BoardGame::factory()->create();

        $this->assertNull($model->getAltMinPlayersFromExpansion());
    }

    public function test_get_alt_min_players_from_expansion_returns_null_when_base_have_this_same_valu(): void
    {
        $model = BoardGame::factory()->create([
            'min_players' => 3,
        ]);
        BoardGame::factory()->create([
            'min_players' => 3,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertNull($model->getAltMinPlayersFromExpansion());
    }

    public function test_get_alt_min_players_from_expansion_returns_null_when_base_have_lover_value(): void
    {
        $model = BoardGame::factory()->create([
            'min_players' => 2,
        ]);
        BoardGame::factory()->create([
            'min_players' => 3,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertNull($model->getAltMinPlayersFromExpansion());
    }

    public function test_get_alt_min_players_from_expansion_returns_expansion_value_if_base_is_higher(): void
    {
        $model = BoardGame::factory()->create([
            'min_players' => 3,
        ]);
        BoardGame::factory()->create([
            'min_players' => 2,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertEquals(2, $model->getAltMinPlayersFromExpansion());
    }

    public function test_get_alt_min_players_from_expansion_handles_multiple_expansions(): void
    {
        $model = BoardGame::factory()->create([
            'min_players' => 4,
        ]);
        BoardGame::factory()->create([
            'min_players' => 3,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);
        BoardGame::factory()->create([
            'min_players' => 2,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertEquals(2, $model->getAltMinPlayersFromExpansion());
    }

    public function test_get_alt_max_players_from_expansion_returns_null_when_base_game_dont_have_expansion(): void
    {
        $model = BoardGame::factory()->create();

        $this->assertNull($model->getAltMaxPlayersFromExpansion());
    }

    public function test_get_alt_max_players_from_expansion_returns_null_when_base_have_this_same_valu(): void
    {
        $model = BoardGame::factory()->create([
            'max_players' => 3,
        ]);
        BoardGame::factory()->create([
            'max_players' => 3,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertNull($model->getAltMaxPlayersFromExpansion());
    }

    public function test_get_alt_max_players_from_expansion_returns_expansion_value_if_base_is_lover(): void
    {
        $model = BoardGame::factory()->create([
            'max_players' => 2,
        ]);
        BoardGame::factory()->create([
            'max_players' => 3,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertEquals(3, $model->getAltMaxPlayersFromExpansion());
    }

    public function test_get_alt_max_players_from_expansion_returns_null_when_base_have_higher_valu(): void
    {
        $model = BoardGame::factory()->create([
            'max_players' => 3,
        ]);
        BoardGame::factory()->create([
            'max_players' => 2,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertNull($model->getAltMaxPlayersFromExpansion());
    }

    public function test_get_alt_max_players_from_expansion_handles_multiple_expansions(): void
    {
        $model = BoardGame::factory()->create([
            'max_players' => 2,
        ]);
        BoardGame::factory()->create([
            'max_players' => 4,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);
        BoardGame::factory()->create([
            'max_players' => 3,
            'type' => BoardGameType::Expansion,
            'base_game_id' => $model->id,
        ]);

        $this->assertEquals(4, $model->getAltMaxPlayersFromExpansion());
    }

    public function test_get_need_insert_return_correct_values(): void
    {
        $modelNeed = BoardGame::factory()->create(['need_insert' => true]);
        $modelNotNeed = BoardGame::factory()->create(['need_insert' => false]);

        $this->assertEquals('Yes', $modelNeed->getNeedInsert());
        $this->assertEquals('No', $modelNotNeed->getNeedInsert());
    }

    public function test_get_need_instruction_return_correct_values(): void
    {
        $modelNeed = BoardGame::factory()->create(['need_instruction' => true]);
        $modelNotNeed = BoardGame::factory()->create(['need_instruction' => false]);

        $this->assertEquals('Yes', $modelNeed->getNeedInstruction());
        $this->assertEquals('No', $modelNotNeed->getNeedInstruction());
    }

    public function test_get_to_painting_return_correct_values(): void
    {
        $modelNeed = BoardGame::factory()->create(['to_painting' => true]);
        $modelNotNeed = BoardGame::factory()->create(['to_painting' => false]);

        $this->assertEquals('Yes', $modelNeed->getToPainting());
        $this->assertEquals('No', $modelNotNeed->getToPainting());
    }
}
