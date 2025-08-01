<?php

namespace Tests\Feature\Gameplay;

use App\Models\Gameplay;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Tests\AuthenticatedTestCase;

class GameplayTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private string $routeIndex = 'gameplay.index';
    private string $routeCreate = 'gameplay.create';
    private string $routeStore = 'gameplay.store';
    private string $routeShow = 'gameplay.show';
    private string $routeEdit = 'gameplay.edit';
    private string $routeUpdate = 'gameplay.update';
    private string $routeDestroy = 'gameplay.destroy';

    // Routs
    public function test_gameplay_index_path_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_gameplay_create_path_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_gameplay_store_path_accessed(): void
    {
        $gameplay = ['name' => 'Test gameplay'];
        $route = route($this->routeStore, $gameplay);

        $this->post($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->post($route)->assertStatus(302);
        $this->actingAs($this->admin)->post($route)->assertStatus(302);
    }

    public function test_gameplay_show_path_accessed(): void
    {
        $gameplay = Gameplay::factory()->create();
        $route = route($this->routeShow, $gameplay);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_gameplay_edit_path_accessed(): void
    {
        $gameplay = Gameplay::factory()->create(['user_id' => $this->user->id]);
        $route = route($this->routeEdit, $gameplay);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_gameplay_update_path_accessed(): void
    {
        $gameplay = Gameplay::factory()->create(['user_id' => $this->user->id]);
        $update = ['name' => 'update name', 'user_id' => $this->user->id];
        $route = route($this->routeUpdate, $gameplay);

        $this->put($route, $update)->assertRedirect(route('login'));
        $this->actingAs($this->user)->put($route, $update)->assertStatus(302);
        $this->actingAs($this->admin)->put($route, $update)->assertStatus(302);
    }

    public function test_gameplay_destroy_path_accessed_on_user(): void
    {
        $gameplay = Gameplay::factory()->create(['user_id' => $this->user->id]);
        $route = route($this->routeDestroy, $gameplay);

        $this->delete($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->delete($route)->assertStatus(302);
    }

    public function test_gameplay_destroy_path_accessed_on_admin(): void
    {
        $gameplay = Gameplay::factory()->create();
        $route = route($this->routeDestroy, $gameplay);

        $this->delete($route)->assertRedirect(route('login'));
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }

    // Methods
    public function test_gameplay_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('gameplay.index')
            ->assertSeeText(__('No gameplays'));
    }

    public function test_gameplay_index_method_render_correct_view_and_info_if_have_records(): void
    {
        Gameplay::factory()->create(['user_id' => $this->user->id]);

        $route = route($this->routeIndex);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('gameplay.index')
            ->assertDontSeeText(__('No gameplays'));
    }

    public function test_gameplay_show_method_render_correct_view(): void
    {
        $gameplay = Gameplay::factory()->create();
        $route = route($this->routeShow, $gameplay);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('gameplay.show');
    }

    public function test_gameplay_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('gameplay.create');
    }

    public function test_gameplay_edit_method_render_correct_view(): void
    {
        $gameplay = Gameplay::factory()->create(['user_id' => $this->user->id]);
        $route = route($this->routeEdit, $gameplay);

        $this->actingAs($this->user)->get($route)->assertOk()
            ->assertViewIs('gameplay.edit');
    }

    public function test_edit_method_denies_access_to_non_admin_non_owner(): void
    {
        $otherUser = User::factory()->create();
        $owner = User::factory()->create();
        $gameplay = Gameplay::factory()->create(['user_id' => $owner->id]);
        $route = route($this->routeEdit, $gameplay);

        Gate::shouldReceive('allows')->with('isAdmin')->andReturn(false);

        $response = $this->actingAs($otherUser)->get($route);

        $response->assertStatus(403);
    }

    public function test_gameplay_store_method(): void
    {
        $newGameplay = Gameplay::factory()->make()->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->user)->post($route, $newGameplay);
        $newGameplay['date'] = Carbon::createFromFormat('d-m-Y', $newGameplay['date'])->format('Y-m-d');
        $gameplay = Gameplay::first();

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute($this->routeShow, $gameplay);
        $this->assertDatabaseHas('gameplays', $newGameplay);
    }

    public function test_gameplay_update_method(): void
    {
        $gameplay = Gameplay::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $updated = Gameplay::factory()->make([
            'user_id' => $this->user->id,
        ])->toArray();
        $route = route($this->routeUpdate, $gameplay);

        $response = $this->actingAs($this->user)->put($route, $updated);

        $updated['date'] = Carbon::createFromFormat('d-m-Y', $updated['date'])->format('Y-m-d');

        $response->assertRedirectToRoute($this->routeShow, $gameplay);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('gameplays', $updated);
        $this->assertDatabaseMissing('gameplays', $gameplay->toArray());
    }

    public function test_gameplay_destroy_method(): void
    {
        $gameplay = Gameplay::factory()->create(['user_id' => $this->user->id]);
        $route = route($this->routeDestroy, $gameplay);

        $response = $this->actingAs($this->user)->delete($route);

        $response->assertSessionHasNoErrors()->assertRedirectToRoute($this->routeIndex);
        $this->assertDatabaseMissing('gameplays', ['id' => $gameplay->id]);
    }

    public function test_destroy_method_denies_access_to_non_admin_non_owner(): void
    {
        $otherUser = User::factory()->create();
        $owner = User::factory()->create();
        $gameplay = Gameplay::factory()->create(['user_id' => $owner->id]);
        $route = route($this->routeDestroy, $gameplay);

        Gate::shouldReceive('allows')->with('isAdmin')->andReturn(false);

        $response = $this->actingAs($otherUser)->delete($route);

        $response->assertStatus(403);
        $this->assertDatabaseHas('gameplays', ['id' => $gameplay->id]);
    }
}
