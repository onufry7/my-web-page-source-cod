<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Models\BoardGame;
use App\Models\BoardGameSleeve;

class BoardGameSleeveRoutsTest extends BoardGameSleeveTestCase
{
    public function test_board_game_sleeve_index_path_check_accessed(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create();
        $route = route($this->routeIndex, $boardGameSleeve->boardGame);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_sleeve_create_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeCreate, $boardGame);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_sleeve_store_path_check_accessed(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->make();
        $boardGameSleeveArray = $boardGameSleeve->toArray();
        $route = route($this->routeStore, $boardGameSleeve->boardGame);

        $this->post($route, $boardGameSleeveArray)->assertRedirect(route('login'));
        $this->actingAs($this->user)->post($route, $boardGameSleeveArray)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $boardGameSleeveArray)->assertStatus(302);
    }

    public function test_board_game_sleeve_destroy_path_check_accessed(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create();
        $route = route($this->routeDestroy, [$boardGameSleeve->boardGame, $boardGameSleeve->sleeve]);

        $this->delete($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
