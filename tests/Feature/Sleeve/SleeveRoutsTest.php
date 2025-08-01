<?php

namespace Tests\Feature\Sleeve;

use App\Models\Sleeve;

class SleeveRoutsTest extends SleeveTestCase
{
    public function test_sleeve_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_sleeve_create_path_check_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_sleeve_store_path_check_accessed(): void
    {
        $sleeve = Sleeve::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->post($route, $sleeve)->assertRedirect(route('login'));
        $this->actingAs($this->user)->post($route, $sleeve)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $sleeve)->assertStatus(302);
    }

    public function test_sleeve_show_path_check_accessed(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeShow, $sleeve);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_sleeve_edit_path_check_accessed(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeEdit, $sleeve);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_sleeve_update_path_check_accessed(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeUpdate, $sleeve);

        $this->put($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_sleeve_destroy_path_check_accessed(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeDestroy, $sleeve);

        $this->delete($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
