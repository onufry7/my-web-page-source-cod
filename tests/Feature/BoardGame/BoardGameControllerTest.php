<?php

namespace Tests\Feature\BoardGame;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use App\Models\BoardGameSleeve;
use App\Models\Gameplay;
use Illuminate\Support\Str;

class BoardGameControllerTest extends BoardGameTestCase
{
    public function test_board_game_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game.index')
            ->assertSeeText(__('No games'));
    }

    public function test_board_game_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game.index')
            ->assertSeeText(Str::title($boardGame->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_show_method_render_correct_view(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeShow, $boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game.show')
            ->assertViewHas('boardGame', $boardGame);
    }

    public function test_board_game_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game.create')
            ->assertViewHas('baseGames')
            ->assertViewHas('publishers')
            ->assertViewHas('boardGameType');
    }

    public function test_board_game_edit_method_render_correct_view(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeEdit, $boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game.edit')
            ->assertViewHas('boardGame', $boardGame)
            ->assertViewHas('baseGames')
            ->assertViewHas('publishers')
            ->assertViewHas('boardGameType');
    }

    public function test_board_game_store_method_creates_a_record(): void
    {
        $newBoardGame = BoardGame::factory()->make()->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newBoardGame);
        $boardGame = BoardGame::first();

        $response->assertRedirectToRoute($this->routeShow, $boardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('board_games', $newBoardGame);
    }

    public function test_board_game_update_method_updates_the_record(): void
    {
        $boardGame = BoardGame::factory()->create([
            'name' => 'Name game',
            'slug' => 'name-game',
        ]);
        $updateBoardGame = BoardGame::factory()->make([
            'name' => 'New name',
            'slug' => 'new-name',
        ]);
        $route = route($this->routeUpdate, $boardGame);

        $response = $this->actingAs($this->admin)->put($route, $updateBoardGame->toArray());

        $response->assertRedirectToRoute($this->routeShow, $updateBoardGame)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('board_games', ['name' => 'Name game']);
        $this->assertDatabaseHas('board_games', ['name' => 'New name']);
    }

    public function test_board_game_destroy_method_deletes_the_record(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeDestroy, $boardGame);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('board_games', ['id' => $boardGame->id]);
    }

    public function test_board_game_add_file_method_render_correct_view(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeAddFile, $boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('file.create')
            ->assertViewHas('model', $boardGame);
    }

    public function test_board_game_files_method_render_correct_view(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeFiles, $boardGame);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('board-game.files')
            ->assertViewHas('boardGame', $boardGame);
    }

    public function test_board_game_select_list_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeSpecificList, ['type' => 'default']);

        $this->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_no_publisher_render_correct_view_and_info_if_have_records(): void
    {
        $boardGame = BoardGame::factory()->create(['publisher_id' => null]);

        $route = route($this->routeSpecificList, ['type' => 'bez-wydawcy']);

        $this->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGame->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_base_game_no_publisher_render_correct_view_and_info_if_have_records(): void
    {
        $boardGame = BoardGame::factory()->create(['publisher_id' => null]);
        $expansion = BoardGame::factory()->create(['publisher_id' => null, 'type' => BoardGameType::Expansion->value]);

        $route = route($this->routeSpecificList, ['type' => 'podstawowe-bez-wydawcy']);

        $this->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGame->name))
            ->assertDontSeeText(Str::title($expansion->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_no_instruction_render_correct_view_and_info_if_have_records(): void
    {
        $boardGame = BoardGame::factory()->create(['instruction' => null]);

        $route = route($this->routeSpecificList, ['type' => 'bez-instrukcji']);

        $this->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGame->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_no_play_render_correct_view_and_info_if_have_records(): void
    {
        $boardGamePlayed = BoardGame::factory()->create();
        Gameplay::factory(1)->create(['user_id' => $this->user->id, 'board_game_id' => $boardGamePlayed->id]);
        $boardGameNoPlay = BoardGame::factory()->create();

        $route = route($this->routeSpecificList, ['type' => 'niezagrane']);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameNoPlay->name))
            ->assertDontSeeText(Str::title($boardGamePlayed->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_played_render_correct_view_and_info_if_have_records(): void
    {
        $boardGamePlayed = BoardGame::factory()->create();
        Gameplay::factory(1)->create(['user_id' => $this->user->id, 'board_game_id' => $boardGamePlayed->id]);
        $boardGameNoPlay = BoardGame::factory()->create();

        $route = route($this->routeSpecificList, ['type' => 'zagrane']);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGamePlayed->name))
            ->assertDontSeeText(Str::title($boardGameNoPlay->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_players_count_render_correct_view_and_info_if_have_records(): void
    {
        $boardGameFor1to6 = BoardGame::factory()->create(['max_players' => 6, 'min_players' => 1]);
        $boardGameFor4to8 = BoardGame::factory()->create(['max_players' => 8, 'min_players' => 4]);

        $for3Players = route($this->routeSpecificList, ['type' => 'liczba-graczy', 'countPlayers' => 3]);
        $for5Players = route($this->routeSpecificList, ['type' => 'liczba-graczy', 'countPlayers' => 5]);
        $for8Players = route($this->routeSpecificList, ['type' => 'liczba-graczy', 'countPlayers' => 8]);

        $this->actingAs($this->user)->get($for3Players)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameFor1to6->name))
            ->assertDontSeeText(Str::title($boardGameFor4to8->name))
            ->assertDontSeeText(__('No games'));

        $this->actingAs($this->user)->get($for5Players)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameFor1to6->name))
            ->assertSeeText(Str::title($boardGameFor4to8->name))
            ->assertDontSeeText(__('No games'));

        $this->actingAs($this->user)->get($for8Players)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameFor4to8->name))
            ->assertDontSeeText(Str::title($boardGameFor1to6->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_needed_insert_correct_view_and_info_if_have_records(): void
    {
        $boardGameNeedInsert = BoardGame::factory()->create(['need_insert' => true]);
        $boardGameDonotNeedInsert = BoardGame::factory()->create(['need_insert' => false]);

        $route = route($this->routeSpecificList, ['type' => 'bez-insertu']);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameNeedInsert->name))
            ->assertDontSeeText(Str::title($boardGameDonotNeedInsert->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_to_sleeve_up_view_and_info_if_have_records(): void
    {
        $boardGameNeedSleeves = BoardGame::factory()->create();
        BoardGameSleeve::factory()->create([
            'board_game_id' => $boardGameNeedSleeves->id,
            'sleeved' => 0,
        ]);
        $boardGameDonotNeedSleeves = BoardGame::factory()->create();

        $route = route($this->routeSpecificList, ['type' => 'do-koszulkowania']);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameNeedSleeves->name))
            ->assertDontSeeText(Str::title($boardGameDonotNeedSleeves->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_select_list_method_for_to_painting_view_and_info_if_have_records(): void
    {
        $boardGameToPainting = BoardGame::factory()->create(['to_painting' => true]);
        $boardGameToNotPainting = BoardGame::factory()->create(['to_painting' => false]);

        $route = route($this->routeSpecificList, ['type' => 'do-malowania']);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('board-game.specific-list')
            ->assertSeeText(Str::title($boardGameToPainting->name))
            ->assertDontSeeText(Str::title($boardGameToNotPainting->name))
            ->assertDontSeeText(__('No games'));
    }

    public function test_board_game_store_method_prepare_correct_value_for_expansion_from_base_game(): void
    {
        $boardGame = BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
            'game_time' => '60',
            'age' => '14',
        ]);
        $expansion = BoardGame::factory()->make([
            'type' => BoardGameType::Expansion->value,
            'base_game_id' => $boardGame->id,
            'original_publisher_id' => null,
            'publisher_id' => null,
            'min_players' => null,
            'max_players' => null,
            'game_time' => '90',
            'age' => '100',
        ]);

        $this->actingAs($this->admin)->post(route($this->routeStore), $expansion->toArray());

        $this->assertDatabaseHas('board_games', [
            'name' => $expansion->name,
            'slug' => $expansion->slug,
            'original_publisher_id' => $boardGame->original_publisher_id,
            'publisher_id' => $boardGame->publisher_id,
            'min_players' => $boardGame->min_players,
            'max_players' => $boardGame->max_players,
            'game_time' => $expansion->game_time,
            'age' => $expansion->age,
        ]);
    }

    public function test_board_game_update_method_dont_prepare_value_for_expansion_from_base_game(): void
    {
        $boardGame = BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
            'min_players' => '1',
            'max_players' => '6',
        ]);
        $expansion = BoardGame::factory()->create([
            'type' => BoardGameType::Expansion->value,
            'base_game_id' => $boardGame->id,
            'min_players' => $boardGame->min_players,
            'max_players' => $boardGame->max_players,
        ]);
        $updateExpansion = $expansion;
        $updateExpansion->min_players = null;
        $updateExpansion->max_players = 7;

        $this->actingAs($this->admin)->put(route($this->routeUpdate, $expansion), $updateExpansion->toArray());

        $this->assertDatabaseMissing('board_games', [
            'name' => $expansion->name,
            'slug' => $expansion->slug,
            'type' => BoardGameType::Expansion->value,
            'min_players' => $boardGame->min_players,
            'max_players' => $boardGame->max_players,
        ]);
        $this->assertDatabaseHas('board_games', [
            'name' => $expansion->name,
            'slug' => $expansion->slug,
            'type' => BoardGameType::Expansion->value,
            'min_players' => $updateExpansion->min_players,
            'max_players' => $updateExpansion->max_players,
        ]);
    }
}
