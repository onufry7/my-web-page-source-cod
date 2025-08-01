<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Models\BoardGameSleeve;

class BoardGameSleeveViewsTest extends BoardGameSleeveTestCase
{
    // Buttons
    public function test_board_game_sleeve_edit_button_checking_the_visibility_on_show_page(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create();
        $route = route($this->routeIndex, $boardGameSleeve->boardGame);

        $this->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Add'));
    }

    public function test_board_game_sleeve_delete_button_checking_the_visibility_on_index_page(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create();
        $route = route($this->routeIndex, $boardGameSleeve->boardGame);

        $this->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Delete'));
    }
}
