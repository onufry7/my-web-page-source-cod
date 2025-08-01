<?php

namespace Tests\Feature\Aphorism;

use App\Models\Aphorism;

class AphorismControllerTest extends AphorismTestCase
{
    public function test_aphorism_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('aphorism.index')
            ->assertSeeText(__('No aphorisms'));
    }

    public function test_aphorism_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('aphorism.index')
            ->assertSeeText($aphorism->sentence)
            ->assertDontSeeText(__('No aphorisms'));
    }

    public function test_aphorism_show_method_render_correct_view(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeShow, $aphorism);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('aphorism.show')
            ->assertViewHas('aphorism', $aphorism);
    }

    public function test_aphorism_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('aphorism.create');
    }

    public function test_aphorism_edit_method_render_correct_view(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeEdit, $aphorism);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('aphorism.edit')
            ->assertViewHas('aphorism', $aphorism);
    }

    public function test_aphorism_store_method_creates_a_record(): void
    {
        $newAphorism = Aphorism::factory()->make()->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newAphorism);
        $aphorism = Aphorism::first();

        $response->assertRedirectToRoute($this->routeShow, $aphorism)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('aphorisms', $newAphorism);
    }

    public function test_aphorism_update_method_updates_the_record(): void
    {
        $aphorism = Aphorism::factory()->create([
            'sentence' => 'quote',
        ]);
        $updateAphorism = Aphorism::factory()->make([
            'sentence' => 'New quote',
        ]);
        $route = route($this->routeUpdate, $aphorism);

        $response = $this->actingAs($this->admin)->put($route, $updateAphorism->toArray());

        $response->assertRedirectToRoute($this->routeShow, $aphorism)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('aphorisms', ['sentence' => 'quote']);
        $this->assertDatabaseHas('aphorisms', ['sentence' => 'New quote']);
    }

    public function test_aphorism_destroy_method_deletes_the_record(): void
    {
        $aphorism = Aphorism::factory()->create();
        $route = route($this->routeDestroy, $aphorism);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('aphorisms', ['id' => $aphorism->id]);
    }
}
