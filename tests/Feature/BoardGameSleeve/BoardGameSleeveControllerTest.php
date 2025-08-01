<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Models\BoardGame;
use App\Models\BoardGameSleeve;
use App\Models\Sleeve;
use App\Repositories\BoardGameSleeveRepository;

class BoardGameSleeveControllerTest extends BoardGameSleeveTestCase
{
    public function test_board_game_sleeve_index_method_render_correct_view_and_info_if_have_sleeves(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create();
        $route = route($this->routeIndex, $boardGameSleeve->boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game-sleeve.index')
            ->assertViewHas('boardGame', $boardGameSleeve->boardGame)
            ->assertSee($boardGameSleeve->sleeve->getFullName());
    }

    public function test_board_game_sleeve_index_method_render_correct_view_and_info_if_does_not_have_sleeves(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeIndex, $boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game-sleeve.index')
            ->assertSeeText(__('No sleeves'));
    }

    public function test_board_game_sleeve_create_method_render_correct_view(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeCreate, $boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game-sleeve.create')
            ->assertViewHas('boardGame', $boardGame);
    }

    public function test_board_game_sleeve_store_method_creates_a_record(): void
    {
        $boardGame = BoardGame::factory()->create();
        $newBoardGameSleeve = BoardGameSleeve::factory()->make(['board_game_id' => $boardGame->id])->toArray();
        $route = route($this->routeStore, $boardGame);

        $response = $this->actingAs($this->admin)->post($route, $newBoardGameSleeve);

        $response->assertRedirectToRoute($this->routeIndex, $boardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('board_game_sleeve', $newBoardGameSleeve);
    }

    public function test_board_game_sleeve_destroy_method_delete_the_record_if_sleeved_is_false(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create(['sleeved' => false]);
        $boardGameSleeveId = $boardGameSleeve->boardGame->sleeves->first()->pivot->id;
        $boardGameSleeveResult = $boardGameSleeve->boardGame->sleeves->first()->pivot->toArray();

        $route = route($this->routeDestroy, [
            'boardGame' => $boardGameSleeve->boardGame,
            'boardGameSleeveId' => $boardGameSleeveId,
        ]);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex, $boardGameSleeve->boardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('board_game_sleeve', $boardGameSleeveResult);
    }

    public function test_board_game_sleeve_destroy_method_do_not_delete_the_record_if_sleeved_is_true(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create(['sleeved' => true]);
        $boardGameSleeveId = $boardGameSleeve->boardGame->sleeves->first()->pivot->id;
        $boardGameSleeveResult = $boardGameSleeve->boardGame->sleeves->first()->pivot->toArray();

        $route = route($this->routeDestroy, [
            'boardGame' => $boardGameSleeve->boardGame,
            'boardGameSleeveId' => $boardGameSleeveId,
        ]);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex, $boardGameSleeve->boardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('board_game_sleeve', $boardGameSleeveResult);
    }

    public function test_board_game_sleeve_put_the_sleeves_method(): void
    {
        $sleeve = Sleeve::factory()->create(['quantity_available' => 100]);
        $boardGameSleeve = BoardGameSleeve::factory()->create([
            'sleeve_id' => $sleeve->id,
            'sleeved' => false,
            'quantity' => 25.,
        ]);
        $pivot = $boardGameSleeve->boardGame->sleeves->first()->pivot;

        $route = route($this->routePutSleeves, [
            'boardGame' => $boardGameSleeve->boardGame,
            'boardGameSleeve' => $pivot,
        ]);

        $response = $this->actingAs($this->admin)->get($route);

        $response->assertRedirectToRoute($this->routeIndex, $boardGameSleeve->boardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('board_game_sleeve', ['sleeved' => 0]);
        $this->assertDatabaseHas('board_game_sleeve', ['sleeved' => 1]);
        $this->assertDatabaseMissing('sleeves', ['id' => $sleeve->id, 'quantity_available' => 100]);
        $this->assertDatabaseHas('sleeves', ['id' => $sleeve->id, 'quantity_available' => 75]);
    }

    public function test_board_game_sleeve_turn_off_the_sleeves_method(): void
    {
        $sleeve = Sleeve::factory()->create(['quantity_available' => 100]);
        $boardGameSleeve = BoardGameSleeve::factory(1)->create([
            'sleeve_id' => $sleeve->id,
            'sleeved' => true,
            'quantity' => 25,
        ])->first();
        $pivot = $boardGameSleeve->boardGame->sleeves->first()->pivot;

        $route = route($this->routeTurnOffSleeves, [
            'boardGame' => $boardGameSleeve->boardGame,
            'boardGameSleeve' => $pivot,
        ]);

        $response = $this->actingAs($this->admin)->get($route);

        $response->assertRedirectToRoute($this->routeIndex, $boardGameSleeve->boardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('board_game_sleeve', ['sleeved' => 1]);
        $this->assertDatabaseHas('board_game_sleeve', ['sleeved' => 0]);
        $this->assertDatabaseMissing('sleeves', ['id' => $sleeve->id, 'quantity_available' => 100]);
        $this->assertDatabaseHas('sleeves', ['id' => $sleeve->id, 'quantity_available' => 125]);
    }

    public function test_board_game_sleeve_repository_put_the_sleeves_method_return_false(): void
    {
        $result = (new BoardGameSleeveRepository())->putTheSleeves(9999);

        $this->assertFalse($result);
    }

    public function test_board_game_sleeve_repository_turn_off_the_sleeves_method_return_false(): void
    {
        $result = (new BoardGameSleeveRepository())->turnOffTheSleeves(9999);

        $this->assertFalse($result);
    }

    public function test_board_game_sleeve_repository_put_the_sleeves_method_return_exception(): void
    {
        $sleeve = Sleeve::factory()->create(['quantity_available' => 0]);
        $boardGameSleeve = BoardGameSleeve::factory()->create([
            'sleeve_id' => $sleeve->id,
            'sleeved' => false,
            'quantity' => 100.,
        ]);
        $pivot = $boardGameSleeve->boardGame->sleeves->first()->pivot;

        $route = route($this->routePutSleeves, [
            'boardGame' => $boardGameSleeve->boardGame,
            'boardGameSleeve' => $pivot,
        ]);

        $response = $this->actingAs($this->admin)->get($route);

        $response->assertRedirectToRoute($this->routeIndex, $boardGameSleeve->boardGame)
            ->assertSessionHas('flash.bannerStyle', 'danger')
            ->assertSessionHas('flash.banner', __('Not enough sleeves in stock! (:countSleeves)', ['countSleeves' => $sleeve->getQuantityAvailable()]));
    }
}
