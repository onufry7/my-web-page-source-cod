<?php

namespace Tests\Feature\BoardGame;

use App\Models\BoardGame;

class BoardGameRoutsTest extends BoardGameTestCase
{
    public function test_board_game_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_create_path_check_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_store_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->post($route, $boardGame)->assertStatus(403);
        $this->actingAs($this->user)->post($route, $boardGame)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $boardGame)->assertStatus(302);
    }

    public function test_board_game_show_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeShow, $boardGame);

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_edit_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeEdit, $boardGame);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_update_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeUpdate, $boardGame);

        $this->put($route)->assertStatus(403);
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_board_game_destroy_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeDestroy, $boardGame);

        $this->delete($route)->assertStatus(403);
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }

    public function test_board_game_add_file_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeAddFile, $boardGame);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_files_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeFiles, $boardGame);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_board_game_select_list_path_check_accessed(): void
    {
        $route = route($this->routeSpecificList, ['type' => 'test-rout-only']);

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }
}
