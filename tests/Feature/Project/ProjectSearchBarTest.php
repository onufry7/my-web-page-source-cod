<?php

namespace Tests\Feature\Project;

use App\Livewire\SearchBars\ProjectSearchBar;
use App\Models\Project;
use App\Models\User;
use Livewire\Livewire;

class ProjectSearchBarTest extends ProjectTestCase
{
    public function test_render_returns_correct_view(): void
    {
        Livewire::test(ProjectSearchBar::class)
            ->assertViewIs('livewire.search-bar')
            ->assertViewHas('model', 'project');
    }

    public function test_updated_search_with_specific_type(): void
    {
        $user = User::factory()->create();
        Project::factory()->create(['name' => 'Project', 'for_registered' => false]);
        Project::factory()->create(['name' => 'New Project', 'for_registered' => true]);

        Livewire::test(ProjectSearchBar::class)
            ->set('search', 'Project')
            ->assertSet('dynamicSearch', true)
            ->assertSee('Project')
            ->assertCount('records', 1)
            ->assertDontSee('New Project');

        Livewire::actingAs($user)->test(ProjectSearchBar::class)
            ->set('search', 'Project')
            ->assertSet('dynamicSearch', true)
            ->assertSee('Project')
            ->assertSee('New Project')
            ->assertCount('records', 2);
    }

    public function test_updated_search_with_no_results(): void
    {
        Project::factory()->create(['name' => 'Project', 'for_registered' => false]);
        Project::factory()->create(['name' => 'New Project', 'for_registered' => true]);

        Livewire::test(ProjectSearchBar::class)
            ->set('search', 'Unknown')
            ->assertSet('dynamicSearch', true)
            ->assertDontSee('Project');
    }

    public function test_updated_search_without_search_term(): void
    {
        Project::factory()->create(['name' => 'Project', 'for_registered' => false]);
        Project::factory()->create(['name' => 'New Project', 'for_registered' => true]);

        Livewire::test(ProjectSearchBar::class)
            ->set('search', null)
            ->assertSet('dynamicSearch', false)
            ->assertSet('records', null);
    }
}
