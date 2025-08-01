<?php

namespace Tests\Feature\Gameplay;

use App\Enums\BoardGameType;
use App\Enums\UserRole;
use App\Http\Requests\GameplayRequest;
use App\Models\BoardGame;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GameplayRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create(['id' => 1, 'role' => UserRole::Admin->value]);
        BoardGame::factory()->create(['id' => 1, 'type' => BoardGameType::BaseGame->value]);
    }

    #[DataProvider('provideValid')]
    public function test_validation_correct(array $data): void
    {
        $request = new GameplayRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('provideInvalid')]
    public function test_validation_failed(array $data): void
    {
        $request = new GameplayRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function provideValid(): array
    {
        return [
            'count has minimum length' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '1',
            ]],
            'count has middle length' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '100',
            ]],
            'count has max length' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '200',
            ]],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            'board game id is empty' => [[
                'board_game_id' => '',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '40',
            ]],
            'user id is empty' => [[
                'board_game_id' => '1',
                'user_id' => '',
                'date' => '2024-01-01',
                'count' => '40',
            ]],
            'date is empty' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '',
                'count' => '40',
            ]],
            'count is empty' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '',
            ]],
            'board game id is not numeric' => [[
                'board_game_id' => 'A',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '2',
            ]],
            'count is to height' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '201',
            ]],
            'count is to less' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '0',
            ]],
            'user id not exist in db' => [[
                'board_game_id' => '1',
                'user_id' => '5',
                'date' => '2024-01-01',
                'count' => '2',
            ]],
            'board game id not exist in db' => [[
                'board_game_id' => '8',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => '2',
            ]],
            'date hav incorrect format' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01 24:14',
                'count' => '2',
            ]],
            'count is not numeric' => [[
                'board_game_id' => '1',
                'user_id' => '1',
                'date' => '2024-01-01',
                'count' => 'A',
            ]],
        ];
    }
}
