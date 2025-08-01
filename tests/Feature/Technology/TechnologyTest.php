<?php

namespace Tests\Feature\Technology;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class TechnologyTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private string $routeIndex = 'technology.index';
    private string $routeCreate = 'technology.create';
    private string $routeStore = 'technology.store';
    private string $routeShow = 'technology.show';
    private string $routeEdit = 'technology.edit';
    private string $routeUpdate = 'technology.update';
    private string $routeDestroy = 'technology.destroy';

    // Routs
    public function test_technology_index_path_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_technology_create_path_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_technology_store_path_accessed(): void
    {
        $technology = ['name' => 'Test technology'];
        $route = route($this->routeStore, $technology);

        $this->post($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->post($route)->assertStatus(403);
        $this->actingAs($this->admin)->post($route)->assertStatus(302);
    }

    public function test_technology_show_path_accessed(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeShow, $technology);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_technology_edit_path_accessed(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeEdit, $technology);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_technology_update_path_accessed(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeUpdate, $technology);

        $this->put($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_technology_destroy_path_accessed(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeDestroy, $technology);

        $this->delete($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }

    // Methods
    public function test_technology_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('technology.index')
            ->assertSeeText(__('No technologies'));
    }

    public function test_technology_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('technology.index')
            ->assertSeeText($technology->name)
            ->assertDontSeeText(__('No technologies'));
    }

    public function test_technology_show_method_render_correct_view(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeShow, $technology);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('technology.show');
    }

    public function test_technology_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('technology.create');
    }

    public function test_technology_edit_method_render_correct_view(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeEdit, $technology);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('technology.edit');
    }

    public function test_technology_can_by_created_in_database(): void
    {
        $route = route($this->routeStore);
        $newTechnology = Technology::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->post($route, $newTechnology);
        $technology = Technology::first();

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute($this->routeShow, $technology);
        $this->assertDatabaseHas('technologies', $newTechnology);
    }

    public function test_technology_can_by_update_in_database(): void
    {
        $technology = Technology::factory()->create(['name' => 'Name']);
        $updated = ['name' => 'No Name'];
        $route = route($this->routeUpdate, $technology);

        $response = $this->actingAs($this->admin)->put($route, $updated);

        $response->assertRedirectToRoute($this->routeShow, $technology);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('technologies', $updated);
        $this->assertDatabaseMissing('technologies', $technology->toArray());
    }

    public function test_technology_can_by_deleted_in_database(): void
    {
        $technology = Technology::factory()->create();
        $route = route($this->routeDestroy, $technology);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertSessionHasNoErrors()->assertRedirectToRoute($this->routeIndex);
        $this->assertDatabaseMissing('technologies', ['id' => $technology->id]);
    }

    // Fields
    public function test_technology_name_is_unique_on_created(): void
    {
        Technology::factory()->create(['name' => 'Name']);
        $newTechnology = Technology::factory()->make(['name' => 'Name']);

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), $newTechnology->toArray());

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    public function test_technology_name_is_unique_on_updated(): void
    {
        Technology::factory()->create(['name' => 'Name']);
        $technologyToUpdate = Technology::create(['name' => 'Other']);
        $route = route($this->routeUpdate, $technologyToUpdate);

        $response = $this->actingAs($this->admin)->put($route, ['name' => 'Name']);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    public function test_technology_name_unique_is_ignored_on_update_for_current_technology(): void
    {
        $technology = Technology::factory()->create(['name' => 'New Name']);
        $route = route($this->routeUpdate, $technology);

        $response = $this->actingAs($this->admin)->put($route, ['name' => 'New Name']);

        $response->assertRedirectToRoute($this->routeShow, $technology)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('technologies', ['id' => $technology->id]);
    }

    public function test_technology_can_be_persisted_with_projects(): void
    {
        $technology = Technology::factory()->create();
        $project = Project::factory()->create();

        $technology->projects()->attach($project);

        $this->assertDatabaseHas('technologies', ['id' => $technology->id]);
        $this->assertDatabaseHas('project_technology', [
            'technology_id' => $technology->id,
            'project_id' => $project->id,
        ]);
    }
}
