<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Str;

class ProjectControllerTest extends ProjectTestCase
{
    public function test_project_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('project.index')
            ->assertSeeText(__('No projects'));
    }

    public function test_project_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $project = Project::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('project.index')
            ->assertSeeText(Str::title($project->name))
            ->assertDontSeeText(__('No projects'));
    }

    public function test_project_show_method_render_correct_view(): void
    {
        $project = Project::factory()->create();
        $route = route($this->routeShow, $project);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('project.show')
            ->assertViewHas('project', $project);
    }

    public function test_project_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('project.create');
    }

    public function test_project_edit_method_render_correct_view(): void
    {
        $project = Project::factory()->create();
        $route = route($this->routeEdit, $project);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('project.edit')
            ->assertViewHas('project', $project);
    }

    public function test_project_store_method_creates_a_record(): void
    {
        $newProject = Project::factory()->make()->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newProject);
        $project = Project::first();

        $response->assertRedirectToRoute($this->routeShow, $project)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', $newProject);
    }

    public function test_project_update_method_updates_the_record(): void
    {
        $project = Project::factory()->create([
            'name' => 'Old name',
            'slug' => 'old-name',
        ]);
        $updateProject = Project::factory()->make([
            'name' => 'New name',
            'slug' => 'new-name',
        ]);
        $route = route($this->routeUpdate, $project);

        $response = $this->actingAs($this->admin)->put($route, $updateProject->toArray());

        $response->assertRedirectToRoute($this->routeShow, $updateProject)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('projects', ['name' => 'Old name']);
        $this->assertDatabaseHas('projects', ['name' => 'New name']);
    }

    public function test_project_destroy_method_deletes_the_record(): void
    {
        $project = Project::factory()->create();
        $route = route($this->routeDestroy, $project);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_project_for_unregistered_visible_on_the_list_for_all_users(): void
    {
        $project = Project::factory()->create(['for_registered' => false]);
        $route = route($this->routeShow, $project);

        $this->get($route)->assertSee($project->name);
        $this->actingAs($this->user)->get($route)->assertSee($project->name);
        $this->actingAs($this->admin)->get($route)->assertSee($project->name);
    }

    public function test_project_for_registered_visible_on_the_list_only_for_registered_users(): void
    {
        $project = Project::factory()->create(['for_registered' => true]);
        $route = route($this->routeIndex);

        $this->get($route)->assertDontSee(Str::title($project->name));
        $this->actingAs($this->user)->get($route)->assertSee(Str::title($project->name));
        $this->actingAs($this->admin)->get($route)->assertSee(Str::title($project->name));
    }

    public function test_attach_project_technology_pivot(): void
    {
        $technology = Technology::factory()->create();
        $newProject = Project::factory()->make([
            'technologies' => [$technology->id],
        ])->toArray();

        $this->actingAs($this->admin)->post(route($this->routeStore), $newProject);
        $project = Project::first();

        $this->assertDatabaseHas('project_technology', [
            'technology_id' => $technology->id,
            'project_id' => $project->id,
        ]);
    }

    public function test_detach_project_technology_pivot(): void
    {
        $project = Project::factory()->create();
        $technology = Technology::factory()->create();
        $project->technologies()->attach($technology->id);
        $route = route($this->routeDestroy, $project);

        $this->actingAs($this->admin)->delete($route);

        $this->assertDatabaseMissing('project_technology', [
            'project_id' => $project->id,
            'technology_id' => $technology->id,
        ]);
    }

    public function test_sync_project_technology_pivot(): void
    {
        $project = Project::factory()->create();
        $technology1 = Technology::factory()->create();
        $technology2 = Technology::factory()->create();
        $project->technologies()->attach($technology1->id);
        $route = route($this->routeUpdate, $project);
        $request = array_merge($project->toArray(), ['technologies' => [$technology2->id]]);

        $this->actingAs($this->admin)->put($route, $request);

        $this->assertDatabaseMissing('project_technology', [
            'project_id' => $project->id,
            'technology_id' => $technology1->id,
        ]);
        $this->assertDatabaseHas('project_technology', [
            'project_id' => $project->id,
            'technology_id' => $technology2->id,
        ]);
    }
}
