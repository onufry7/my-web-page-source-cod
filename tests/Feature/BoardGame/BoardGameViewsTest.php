<?php

namespace Tests\Feature\BoardGame;

use App\Models\BoardGame;

class BoardGameViewsTest extends BoardGameTestCase
{
    // Buttons
    public function test_board_game_add_button_checking_the_visibility_on_index_page(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Add'));
    }

    public function test_board_game_edit_button_checking_the_visibility_on_show_page(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeShow, $boardGame);

        $this->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Edit'));
    }

    public function test_board_game_delete_button_checking_the_visibility_on_show_page(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeShow, $boardGame);

        $this->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Delete'));
    }

    public function test_board_game_search_bar_is_visible(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertSeeLivewire('search-bars.board-game-search-bar');
    }
}
