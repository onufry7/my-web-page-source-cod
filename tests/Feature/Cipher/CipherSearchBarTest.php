<?php

namespace Tests\Feature\Cipher;

use App\Livewire\SearchBars\CipherSearchBar;
use App\Models\Cipher;
use Livewire\Livewire;

class CipherSearchBarTest extends CipherTestCase
{
    public function test_render_returns_correct_view(): void
    {
        Livewire::test(CipherSearchBar::class)
            ->assertViewIs('livewire.search-bar')
            ->assertViewHas('model', 'cipher');
    }

    public function test_updated_search_with_specific_type(): void
    {
        Cipher::factory()->create(['name' => 'Cezar']);

        Livewire::test(CipherSearchBar::class)
            ->set('search', 'Cezar')
            ->assertSet('dynamicSearch', true)
            ->assertSee('Cezar')
            ->assertCount('records', 1);
    }

    public function test_updated_search_with_no_results(): void
    {
        Cipher::factory()->create(['name' => 'Cezar']);

        Livewire::test(CipherSearchBar::class)
            ->set('search', 'Unknown')
            ->assertSet('dynamicSearch', true)
            ->assertDontSee('Chess');
    }

    public function test_updated_search_without_search_term(): void
    {
        Cipher::factory()->create(['name' => 'Cezar']);

        Livewire::test(CipherSearchBar::class)
            ->set('search', null)
            ->assertSet('dynamicSearch', false)
            ->assertSet('records', null);
    }
}
