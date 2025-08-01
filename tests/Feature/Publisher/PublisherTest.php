<?php

namespace Tests\Feature\Publisher;

use App\Models\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class PublisherTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private string $routeIndex = 'publisher.index';
    private string $routeCreate = 'publisher.create';
    private string $routeStore = 'publisher.store';
    private string $routeShow = 'publisher.show';
    private string $routeEdit = 'publisher.edit';
    private string $routeUpdate = 'publisher.update';
    private string $routeDestroy = 'publisher.destroy';

    // Routs
    public function test_publisher_index_path_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_publisher_create_path_accessed(): void
    {
        $route = route($this->routeCreate);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_publisher_store_path_accessed(): void
    {
        $publisher = Publisher::factory()->make();
        $route = route($this->routeStore, $publisher);

        $this->post($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->post($route)->assertStatus(403);
        $this->actingAs($this->admin)->post($route)->assertStatus(302);
    }

    public function test_publisher_show_path_accessed(): void
    {
        $publisher = Publisher::factory()->create();

        $route = route($this->routeShow, $publisher);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_publisher_edit_path_accessed(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeEdit, $publisher);

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_publisher_update_path_accessed(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeUpdate, $publisher);

        $this->put($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->put($route)->assertStatus(403);
        $this->actingAs($this->admin)->put($route)->assertStatus(302);
    }

    public function test_publisher_destroy_path_accessed(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeDestroy, $publisher);

        $this->delete($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }

    // Methods
    public function test_publisher_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('publisher.index')
            ->assertSeeText(__('No publishers'));
    }

    public function test_publisher_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('publisher.index')
            ->assertSeeText($publisher->name)
            ->assertDontSeeText(__('No publishers'));
    }

    public function test_publisher_show_method_render_correct_view(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeShow, $publisher);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('publisher.show');
    }

    public function test_publisher_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('publisher.create');
    }

    public function test_publisher_edit_method_render_correct_view(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeEdit, $publisher);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('publisher.edit');
    }

    public function test_publisher_can_by_created_in_database(): void
    {
        $route = route($this->routeStore);
        $newPublisher = Publisher::factory()->make(['website' => null])->toArray();

        $response = $this->actingAs($this->admin)->post($route, $newPublisher);
        $publisher = Publisher::first();

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute($this->routeShow, $publisher);
        $this->assertDatabaseHas('publishers', $newPublisher);
    }

    public function test_publisher_can_by_update_in_database(): void
    {
        $publisher = Publisher::factory()->create(['name' => 'Name']);
        $updated = ['name' => 'No Name'];
        $route = route($this->routeUpdate, $publisher);

        $response = $this->actingAs($this->admin)->put($route, $updated);

        $response->assertRedirectToRoute($this->routeShow, $publisher);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('publishers', $updated);
        $this->assertDatabaseMissing('publishers', $publisher->toArray());
    }

    public function test_publisher_can_by_deleted_in_database(): void
    {
        $publisher = Publisher::factory()->create();
        $route = route($this->routeDestroy, $publisher);

        $this->actingAs($this->admin)->delete($route)->assertRedirectToRoute($this->routeIndex)
            ->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('publishers', ['id' => $publisher->id]);
    }

    // Fields
    public function test_publisher_name_is_unique_on_created(): void
    {
        Publisher::factory()->create(['name' => 'Name']);

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), ['name' => 'Name']);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    public function test_publisher_name_is_unique_on_updated(): void
    {
        Publisher::factory()->create(['name' => 'Name']);
        $otherPublisher = Publisher::factory()->create(['name' => 'Other']);
        $route = route($this->routeUpdate, $otherPublisher);

        $response = $this->actingAs($this->admin)->put($route, ['name' => 'Name']);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    public function test_publisher_name_unique_is_ignored_on_update_for_current_publisher(): void
    {
        $publisher = Publisher::factory()->create(['name' => 'New Name']);
        $route = route($this->routeUpdate, $publisher);

        $response = $this->actingAs($this->admin)->put($route, ['name' => 'New Name']);

        $response->assertStatus(302)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('publishers', ['id' => $publisher->id]);
    }
}
