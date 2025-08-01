<?php

namespace Tests\Feature\File;

use App\Models\BoardGame;
use App\Models\File;

class FileRoutsTest extends FileTestCase
{
    public function test_file_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_file_show_path_check_accessed(): void
    {
        $boardGame = BoardGame::factory()->create();
        $file = File::factory()->create(['model_id' => $boardGame->id, 'model_type' => BoardGame::class]);
        $route = route($this->routeShow, $file);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_file_store_path_check_accessed(): void
    {
        $file = File::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->post($route, $file)->assertStatus(302);
        $this->actingAs($this->user)->post($route, $file)->assertStatus(403);
        $this->actingAs($this->admin)->post($route, $file)->assertStatus(302);
    }

    public function test_file_edit_path_check_accessed(): void
    {
        $file = File::factory()->create();
        $route = route($this->routeEdit, $file);

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_file_update_path_check_accessed(): void
    {
        $file = File::factory()->create();
        $route = route($this->routeUpdate, $file);

        $this->put($route)->assertStatus(302);
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_file_deleted_path_check_accessed(): void
    {
        $file = File::factory()->create();
        $route = route($this->routeDestroy, $file->id);

        $this->delete($route)->assertStatus(302);
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }
}
