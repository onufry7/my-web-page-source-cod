<?php

namespace Tests\Feature\Project;

use App\Models\Project;

class ProjectRoutsTest extends ProjectTestCase
{
    public function test_project_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertStatus(200)->assertSeeText(__('Projects'));
        $this->actingAs($this->user)->get($route)->assertStatus(200)->assertSeeText(__('Projects'));
        $this->actingAs($this->admin)->get($route)->assertStatus(200)->assertSeeText(__('Projects'));
    }

    public function test_project_create_path_check_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_project_store_path_check_accessed(): void
    {
        $project = Project::factory(1)->make()->first()->toArray();
        $route = route($this->routeStore);

        $this->post($route, $project)->assertStatus(403);
        $this->actingAs($this->user)->post($route, $project)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $project)->assertStatus(302);
    }

    public function test_project_show_path_check_accessed(): void
    {
        $project = Project::factory(1)->create(['for_registered' => false])->first();
        $route = route($this->routeShow, $project);

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_project_show_path_check_accessed_for_registered(): void
    {
        $project = Project::factory(1)->create(['for_registered' => true])->first();
        $route = route($this->routeShow, $project);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_project_edit_path_check_accessed(): void
    {
        $project = Project::factory(1)->create()->first();
        $route = route($this->routeEdit, $project);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_project_update_path_check_accessed(): void
    {
        $project = Project::factory(1)->create()->first();
        $route = route($this->routeUpdate, $project);

        $this->put($route)->assertStatus(403);
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_project_destroy_path_check_accessed(): void
    {
        $project = Project::factory(1)->create()->first();
        $route = route($this->routeDestroy, $project);

        $this->delete($route)->assertStatus(403);
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
