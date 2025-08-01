<?php

namespace Tests\Feature;

use App\Models\BoardGame;
use App\Models\Gameplay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class ShelfOfShameTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    public function test_shelf_shame_view_contains_unplayed_and_not_contains_played_games(): void
    {
        $playedGames = BoardGame::factory(5)->create();
        $unplayedGames = BoardGame::factory(5)->create();

        foreach ($playedGames as $game) {
            Gameplay::factory()->create(['user_id' => $this->user->id, 'board_game_id' => $game->id]);
        }

        $response = $this->actingAs($this->user)->get(route('shelf.shame'));

        foreach ($unplayedGames as $game) {
            $response->assertSee($game->name);
        }

        foreach ($playedGames as $game) {
            $response->assertDontSee($game->name);
        }
    }

    public function test_shelf_of_shame_path_accessed(): void
    {
        $route = route('shelf.shame');

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_shelf_of_shame_path_render_correct_view(): void
    {
        $this->actingAs($this->user)->get(route('shelf.shame'))->assertOk()
            ->assertViewIs('shelf-shame')
            ->assertSeeText(__('Shelf of shame'));
    }
}
