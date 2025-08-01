<?php

namespace Tests\Feature\Aphorism;

use App\Models\Aphorism;

class AphorismRoutsTest extends AphorismTestCase
{
    public function test_aphorism_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_aphorism_create_path_check_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_aphorism_store_path_check_accessed(): void
    {
        $aphorism = Aphorism::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->post($route, $aphorism)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $aphorism)->assertStatus(302);
    }

    public function test_aphorism_show_path_check_accessed(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeShow, $aphorism);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_aphorism_edit_path_check_accessed(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeEdit, $aphorism);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_aphorism_update_path_check_accessed(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeUpdate, $aphorism);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_aphorism_destroy_path_check_accessed(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeDestroy, $aphorism);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
