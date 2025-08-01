<?php

namespace Tests\Feature\Project;

use App\Models\Project;

class ProjectViewsTest extends ProjectTestCase
{
    // Views
    public function test_project_add_button_checking_the_visibility_on_index_page(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Add'));
    }

    public function test_project_edit_button_checking_the_visibility_on_show_page(): void
    {
        $project = Project::factory(1)->create()->first();
        $route = route($this->routeShow, $project);

        $this->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Edit'));
    }

    public function test_project_delete_button_checking_the_visibility_on_show_page(): void
    {
        $project = Project::factory(1)->create()->first();
        $route = route($this->routeShow, $project);

        $this->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Delete'));
    }

    public function test_project_search_bar_is_visible(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertSeeLivewire('search-bars.project-search-bar');
    }
}
