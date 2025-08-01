<?php

namespace Tests\Feature\Cipher;

use App\Models\Cipher;

class CipherRoutsTest extends CipherTestCase
{
    public function test_cipher_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_cipher_create_path_check_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_cipher_store_path_check_accessed(): void
    {
        $cipher = Cipher::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->post($route, $cipher)->assertStatus(403);
        $this->actingAs($this->user)->post($route, $cipher)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $cipher)->assertStatus(302);
    }

    public function test_cipher_show_path_check_accessed(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeShow, $cipher);

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_cipher_edit_path_check_accessed(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeEdit, $cipher);

        $this->get($route)->assertStatus(403);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_cipher_update_path_check_accessed(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeUpdate, $cipher);

        $this->put($route)->assertStatus(403);
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_cipher_destroy_path_check_accessed(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeDestroy, $cipher);

        $this->delete($route)->assertStatus(403);
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
