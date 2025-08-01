<?php

namespace Tests\Feature\BoardGame;

use App\Enums\BoardGameType;
use App\Livewire\SearchBars\BoardGameSearchBar;
use App\Models\BoardGame;
use Livewire\Livewire;

class BoardGameSearchBarTest extends BoardGameTestCase
{
    public function test_render_returns_correct_view(): void
    {
        Livewire::test(BoardGameSearchBar::class)
            ->assertViewIs('livewire.search-bar')
            ->assertViewHas('model', 'board-game');
    }

    public function test_updated_search_with_specific_type(): void
    {
        BoardGame::factory()->create(['name' => 'Base Game', 'type' => BoardGameType::BaseGame->value]);
        BoardGame::factory()->create(['name' => 'Expansion Game', 'type' => BoardGameType::Expansion->value]);
        BoardGame::factory()->create(['name' => 'Mini Expansion Game', 'type' => BoardGameType::MiniExpansion->value]);

        Livewire::test(BoardGameSearchBar::class)
            ->set('type', 'wszystkie')
            ->set('search', 'Game')
            ->assertSet('dynamicSearch', true)
            ->assertSee('Base Game')
            ->assertSee('Expansion Game')
            ->assertSee('Mini Expansion Game')
            ->assertCount('records', 3);

        Livewire::test(BoardGameSearchBar::class)
            ->set('type', 'dodatki')
            ->set('search', 'Game')
            ->assertSet('dynamicSearch', true)
            ->assertSee('Expansion Game')
            ->assertSee('Mini Expansion Game')
            ->assertCount('records', 2);

        Livewire::test(BoardGameSearchBar::class)
            ->set('type', null)
            ->set('search', 'Game')
            ->assertSet('dynamicSearch', true)
            ->assertSee('Base Game')
            ->assertCount('records', 1);
    }

    public function test_updated_search_with_no_results(): void
    {
        BoardGame::factory()->create(['name' => 'Chess']);

        Livewire::test(BoardGameSearchBar::class)
            ->set('search', 'Unknown')
            ->set('type', 'wszystkie')
            ->assertSet('dynamicSearch', true)
            ->assertDontSee('Chess');
    }

    public function test_updated_search_without_search_term(): void
    {
        BoardGame::factory()->create(['name' => 'Chess']);

        Livewire::test(BoardGameSearchBar::class)
            ->set('search', null)
            ->assertSet('dynamicSearch', false)
            ->assertSet('records', null);
    }
}
