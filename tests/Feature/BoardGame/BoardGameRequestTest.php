<?php

namespace Tests\Feature\BoardGame;

use App\Enums\BoardGameType;
use App\Http\Requests\BoardGameRequest;
use App\Models\BoardGame;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

class BoardGameRequestTest extends BoardGameTestCase
{
    // Unique Fields
    public function test_board_game_name_field_is_unique_on_created(): void
    {
        BoardGame::factory()->create([
            'name' => 'Name',
            'slug' => 'name',
            'type' => BoardGameType::BaseGame->value,
        ]);
        $newBoardGame = BoardGame::factory()->make([
            'name' => 'Name',
            'slug' => 'name',
            'type' => BoardGameType::BaseGame->value,
        ])->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newBoardGame);

        $response->assertStatus(302)->assertSessionHasErrors(['name', 'slug']);
    }

    public function test_board_game_name_field_is_unique_on_updated(): void
    {
        BoardGame::factory()->create([
            'name' => 'Name',
            'slug' => 'name',
            'type' => BoardGameType::BaseGame->value,
        ]);
        $boardGameToUpdate = BoardGame::factory()->create([
            'name' => 'Other Name',
            'slug' => 'other-name',
            'type' => BoardGameType::BaseGame->value,
        ]);
        $route = route($this->routeUpdate, $boardGameToUpdate);

        $response = $this->actingAs($this->admin)->put($route, [
            'name' => 'Name',
            'slug' => 'name',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name', 'slug']);
    }

    public function test_board_game_name_unique_is_ignored_on_update_for_current_board_game(): void
    {
        $boardGame = BoardGame::factory()->create(['type' => BoardGameType::BaseGame->value]);
        $route = route($this->routeUpdate, $boardGame);

        $response = $this->actingAs($this->admin)->put($route, $boardGame->toArray());

        $response->assertStatus(302)->assertSessionHasNoErrors();
    }

    #[DataProvider('validProvider')]
    public function test_field_validation_passed(array $data): void
    {
        $request = new BoardGameRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidProvider')]
    public function test_field_validation_failed(array $data): void
    {
        $request = new BoardGameRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function validProvider(): array
    {
        $instructionFile = UploadedFile::fake()->create('instruction.pdf', 60000, 'application/pdf');

        return [
            'Only required fields' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'type' => BoardGameType::BaseGame->value,
            ]],

            'Base game id is null when type is BaseGame' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'type' => BoardGameType::BaseGame->value,
            ]],

            'Age is correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'age' => 12,
            ]],

            'Min player is correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'min_players' => 1,
            ]],

            'Max player is  correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'max_players' => 6,
            ]],

            'Game time is  correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'game_time' => 120,
            ]],

            'Video url is correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'video_url' => 'http://www.wozniak.pl/video/22',
            ]],

            'Planszeo is correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'planszeo_url' => 'https://planszeo.pl',
            ]],

            'Bgg is correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'bgg_url' => 'https://boardgamegeek.com',
            ]],

            'Box image is null' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'box_img' => '',
            ]],

            'Box image file is correct png' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'box_image' => UploadedFile::fake()->image('box.png')->size(400),
            ]],

            'Box image file is correct webp' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'box_image' => UploadedFile::fake()->image('box.webp')->size(400),
            ]],

            'Instruction url is null' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'instruction' => '',
            ]],

            'Instruction file is correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'instruction_file' => $instructionFile,
            ]],

            'Need instruction field is true' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'need_instruction' => true,
            ]],

            'Need instruction field is false' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'need_instruction' => false,
            ]],

            'Need insert field is true' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'need_insert' => true,
            ]],

            'Need insert field is false' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'need_insert' => false,
            ]],

            'To painting field is false' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'to_painting' => false,
            ]],

            'To painting field is true' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'to_painting' => true,
            ]],
        ];
    }

    public static function invalidProvider(): array
    {
        $boxImageFile = UploadedFile::fake()->image('box.png')->size(4097);
        $instructionFile = UploadedFile::fake()->create('instruction.pdf', 60001, 'application/pdf');

        return [
            'Null name' => [[
                'name' => '',
                'slug' => '',
            ]],

            'Incorrect base game type' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'type' => 'test',
            ]],

            'min players is not integer' => [[
                'name' => 'Name',
                'slug' => 'name',
                'min_players' => 'test',
            ]],

            'min players is to small' => [[
                'name' => 'Name',
                'slug' => 'name',
                'min_players' => 0,
            ]],

            'min players is to large' => [[
                'name' => 'Name',
                'slug' => 'name',
                'min_players' => 126,
            ]],

            'max players is not integer' => [[
                'name' => 'Name',
                'slug' => 'name',
                'max_players' => 'test',
            ]],

            'max players is to small' => [[
                'name' => 'Name',
                'slug' => 'name',
                'max_players' => 0,
            ]],

            'max players is to large' => [[
                'name' => 'Name',
                'slug' => 'name',
                'max_players' => 126,
            ]],

            'age is not integer' => [[
                'name' => 'Name',
                'slug' => 'name',
                'age' => 'test',
            ]],

            'game time is not integer' => [[
                'name' => 'Name',
                'slug' => 'name',
                'game_time' => 'test',
            ]],

            'Video incorrect url' => [[
                'name' => 'Name',
                'slug' => 'name',
                'video_url' => 'test',
            ]],

            'Planszeo incorrect url' => [[
                'name' => 'Name',
                'slug' => 'name',
                'planszeo_url' => 'test',
            ]],

            'Bgg incorrect url' => [[
                'name' => 'Name',
                'slug' => 'name',
                'bgg_url' => 'test',
            ]],

            'Video url is to long' => [[
                'name' => 'Name',
                'slug' => 'name',
                'video_url' => str_repeat('a', 256),
            ]],

            'Planszeo url is to long' => [[
                'name' => 'Name',
                'slug' => 'name',
                'planszeo_url' => str_repeat('a', 256),
            ]],

            'Bgg url is to long' => [[
                'name' => 'Name',
                'slug' => 'name',
                'bgg_url' => str_repeat('a', 256),
            ]],

            'Box img link is to long' => [[
                'name' => 'Name',
                'slug' => 'name',
                'box_img' => str_repeat('a', 256),
            ]],

            'Instruction link is to long' => [[
                'name' => 'Name',
                'slug' => 'name',
                'instruction' => str_repeat('a', 256),
            ]],

            'Box image have incorrect mimes' => [[
                'name' => 'Name',
                'slug' => 'name',
                'box_image' => $instructionFile,
            ]],

            'Box image is to large' => [[
                'name' => 'Name',
                'slug' => 'name',
                'box_image' => $boxImageFile,
            ]],

            'Instruction have incorrect mimes' => [[
                'name' => 'Name',
                'slug' => 'name',
                'instruction_file' => $boxImageFile,
            ]],

            'Instruction is to large' => [[
                'name' => 'Name',
                'slug' => 'name',
                'instruction_file' => $instructionFile,
            ]],

            'Need instruction field is incorrect' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'need_instruction' => 'some one',
            ]],

            'Need insert field is incorrect' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'need_insert' => 'some one',
            ]],

            'To painting field is incorrect' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'to_painting' => 'some one',
            ]],
        ];
    }
}
