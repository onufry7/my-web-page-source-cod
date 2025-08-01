<?php

namespace Tests\Feature\AccessToken;

use App\Models\AccessToken;

class AccessTokenRoutsTest extends AccessTokenTestCase
{
    public function test_access_token_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_access_token_show_path_check_accessed(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeShow, $accessToken);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_access_token_create_path_check_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_access_token_store_path_check_accessed(): void
    {
        $accessToken = AccessToken::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->post($route, $accessToken)->assertStatus(302);
        $this->actingAs($this->user)->post($route, $accessToken)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $accessToken)->assertStatus(302);
    }

    public function test_access_token_edit_path_check_accessed(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeEdit, $accessToken);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_access_token_update_path_check_accessed(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeUpdate, $accessToken);

        $this->put($route)->assertStatus(302);
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_access_token_destroy_path_check_accessed(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeDestroy, $accessToken);

        $this->delete($route)->assertStatus(302);
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
