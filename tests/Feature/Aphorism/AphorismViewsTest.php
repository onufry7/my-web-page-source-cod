<?php

namespace Tests\Feature\Aphorism;

use App\Models\Aphorism;

class AphorismViewsTest extends AphorismTestCase
{
    // Buttons
    public function test_board_game_add_button_checking_the_visibility_on_index_page(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Add'));
    }

    public function test_board_game_edit_button_checking_the_visibility_on_show_page(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeShow, $aphorism);

        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Edit'));
    }

    public function test_board_game_delete_button_checking_the_visibility_on_show_page(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeShow, $aphorism);

        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Delete'));
    }
}
