<?php

namespace Tests\Feature\BoardGame;

use App\Enums\BoardGameType;
use App\Models\BoardGame;

class BoardGameFilterTest extends BoardGameTestCase
{
    public function test_board_game_name_filter_is_correct(): void
    {
        BoardGame::create([
            'name' => 'Tokaido',
            'slug' => 'tokaido',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Takenoko',
            'slug' => 'takenoko',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Karak',
            'slug' => 'karak',
            'type' => BoardGameType::BaseGame->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'takenoko']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Takenoko')
            ->assertDontSeeText('Tokaido')
            ->assertDontSeeText('Karak')
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_name_filter_is_incorrect(): void
    {
        BoardGame::create([
            'name' => 'Tokaido',
            'slug' => 'tokaido',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Takenoko',
            'slug' => 'takenoko',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Karak',
            'slug' => 'karak',
            'type' => BoardGameType::BaseGame->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'No name']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText(__('No games'))
            ->assertDontSeeText('Tokaido')
            ->assertDontSeeText('Takenoko')
            ->assertDontSeeText('Karak');
    }

    public function test_board_game_name_filter_is_empty(): void
    {
        BoardGame::create([
            'name' => 'Tokaido',
            'slug' => 'tokaido',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Takenoko',
            'slug' => 'takenoko',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Karak',
            'slug' => 'karak',
            'type' => BoardGameType::BaseGame->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => '']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Tokaido')
            ->assertSeeText('Takenoko')
            ->assertSeeText('Karak')
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_name_filter_return_many_records(): void
    {
        BoardGame::create([
            'name' => 'Tokaido',
            'slug' => 'tokaido',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Takenoko',
            'slug' => 'takenoko',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Karak',
            'slug' => 'karak',
            'type' => BoardGameType::BaseGame->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'ka']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertDontSeeText('Takenoko')
            ->assertSeeText('Tokaido')
            ->assertSeeText('Karak')
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_name_filter_dont_show_expansion(): void
    {
        BoardGame::create([
            'name' => 'Tokaido',
            'slug' => 'tokaido',
            'type' => BoardGameType::BaseGame->value,
        ]);

        BoardGame::create([
            'name' => 'Tokaido rozdroża',
            'slug' => 'tokaido-rozdroza',
            'type' => BoardGameType::Expansion->value,
        ]);

        BoardGame::create([
            'name' => 'Karak',
            'slug' => 'karak',
            'type' => BoardGameType::BaseGame->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'ka']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertDontSeeText('Tokaido rozdroża')
            ->assertSeeText('Tokaido')
            ->assertSeeText('Karak')
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_max_players_filter(): void
    {
        BoardGame::create([
            'name' => 'Game For 6',
            'slug' => 'game-for-6',
            'max_players' => 6,
        ]);

        BoardGame::create([
            'name' => 'Game For 5',
            'slug' => 'game-for-5',
            'max_players' => 5,
        ]);

        BoardGame::create([
            'name' => 'Game For 4',
            'slug' => 'game-for-4',
            'max_players' => 4,
        ]);

        $route = route($this->routeIndex, ['max-graczy' => '5']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertDontSeeText('Game For 6')
            ->assertSeeText('Game For 5')
            ->assertSeeText('Game For 4')
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_min_players_filter(): void
    {
        BoardGame::create([
            'name' => 'Game For 3',
            'slug' => 'game-for-3',
            'min_players' => 3,
        ]);

        BoardGame::create([
            'name' => 'Game For 2',
            'slug' => 'game-for-2',
            'min_players' => 2,
        ]);

        BoardGame::create([
            'name' => 'Game For 1',
            'slug' => 'game-for-1',
            'min_players' => 1,
        ]);

        $route = route($this->routeIndex, ['min-graczy' => '2']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertDontSeeText('Game For 1')
            ->assertSeeText('Game For 2')
            ->assertSeeText('Game For 3')
            ->assertDontSeeText(__('No games'));
    }
}
