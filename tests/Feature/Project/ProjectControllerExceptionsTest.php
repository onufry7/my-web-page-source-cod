<?php

namespace Tests\Feature\Project;

use App\Exceptions\FileException;
use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectControllerExceptionsTest extends ProjectTestCase
{
    public function test_store_method_handles_file_exception(): void
    {
        $projectData = Project::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->mock(ProjectRepository::class, function ($mock) {
            $mock->shouldReceive('store')->andThrow(new FileException('No stored!'));
        });

        $response = $this->actingAs($this->admin)->post($route, $projectData);

        $response->assertRedirect(route($this->routeCreate))
            ->assertSessionHas('flash.banner', __('No stored!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_update_method_handles_file_exception(): void
    {
        $project = Project::factory()->create();
        $newProjectData = Project::factory()->make()->toArray();

        $route = route($this->routeUpdate, $project);

        $this->mock(ProjectRepository::class, function ($mock) {
            $mock->shouldReceive('update')->andThrow(new FileException('No updated!'));
        });

        $response = $this->actingAs($this->admin)->put($route, $newProjectData);

        $response->assertRedirect(route($this->routeEdit, $project))
            ->assertSessionHas('flash.banner', __('No updated!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_destroy_method_handles_file_exception(): void
    {
        $project = Project::factory()->create();
        $route = route($this->routeDestroy, $project);

        $this->mock(ProjectRepository::class, function ($mock) {
            $mock->shouldReceive('delete')->andThrow(new FileException('No deleted!'));
        });

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirect(route($this->routeShow, $project))
            ->assertSessionHas('flash.banner', __('No deleted!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }
}
