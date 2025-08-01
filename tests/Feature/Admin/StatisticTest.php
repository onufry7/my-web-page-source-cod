<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class StatisticTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'admin.statistics.index';

    public function test_statistic_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirectToRoute('login');
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }
}
