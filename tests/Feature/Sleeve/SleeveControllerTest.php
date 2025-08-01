<?php

namespace Tests\Feature\Sleeve;

use App\Models\BoardGame;
use App\Models\Sleeve;
use Illuminate\Support\Str;

class SleeveControllerTest extends SleeveTestCase
{
    public function test_sleeve_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('sleeve.index')
            ->assertSeeText(__('No sleeves'));
    }

    public function test_sleeve_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('sleeve.index')
            ->assertSeeText(Str::title($sleeve->getFullName()))
            ->assertDontSeeText(__('No sleeves'));
    }

    public function test_sleeve_show_method_render_correct_view(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeShow, $sleeve);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('sleeve.show')
            ->assertViewHas('sleeve', $sleeve);
    }

    public function test_sleeve_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('sleeve.create');
    }

    public function test_sleeve_edit_method_render_correct_view(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeEdit, $sleeve);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('sleeve.edit')
            ->assertViewHas('sleeve', $sleeve);
    }

    public function test_sleeve_store_method_creates_a_record(): void
    {
        $newSleeve = Sleeve::factory()->make()->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newSleeve);
        $sleeve = Sleeve::first();

        $response->assertRedirectToRoute($this->routeShow, $sleeve)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('sleeves', $newSleeve);
    }

    public function test_sleeve_update_method_updates_the_record(): void
    {
        $sleeve = Sleeve::factory()->create([
            'name' => 'Name',
        ]);
        $updateSleeve = Sleeve::factory()->make([
            'name' => 'New',
        ]);
        $route = route($this->routeUpdate, $sleeve);

        $response = $this->actingAs($this->admin)->put($route, $updateSleeve->toArray());

        $response->assertRedirectToRoute($this->routeShow, $sleeve)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('sleeves', ['name' => 'Name']);
        $this->assertDatabaseHas('sleeves', ['name' => 'New']);
    }

    public function test_sleeve_destroy_method_deletes_the_record(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeDestroy, $sleeve);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('sleeves', ['id' => $sleeve->id]);
    }

    public function test_sleeve_stock_method_render_correct_view(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeStock, $sleeve);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('sleeve.stock')
            ->assertViewHas('sleeve', $sleeve);
    }

    public function test_sleeve_stock_update_method_updates_the_quantity(): void
    {
        $sleeve = Sleeve::factory()->create(['quantity_available' => 200]);
        $route = route($this->routeStockUpdate, $sleeve);

        $response = $this->actingAs($this->admin)->patch($route, ['quantity_available' => 100]);

        $response->assertRedirectToRoute($this->routeShow, $sleeve)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('sleeves', ['id' => $sleeve->id, 'quantity_available' => 300]);
        $this->assertDatabaseMissing('correct_sleeves', ['sleeve_id' => $sleeve->id]);
    }

    public function test_sleeve_stock_update_method_updates_the_correct(): void
    {
        $sleeve = Sleeve::factory()->create(['quantity_available' => 200]);
        $route = route($this->routeStockUpdate, $sleeve);

        $response = $this->actingAs($this->admin)->patch($route, [
            'quantity_available' => 100,
            'correct' => 'on',
        ]);

        $response->assertRedirectToRoute($this->routeShow, $sleeve)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('sleeves', ['id' => $sleeve->id, 'quantity_available' => 100]);
        $this->assertDatabaseHas('correct_sleeves', [
            'sleeve_id' => $sleeve->id,
            'quantity_before' => 200,
            'quantity_after' => 100,
        ]);
    }

    public function test_board_games_relationship_returns_correct_data(): void
    {
        $sleeve = Sleeve::factory()->create();
        $boardGame1 = BoardGame::factory()->create();
        $boardGame2 = BoardGame::factory()->create();

        $sleeve->boardGames()->attach([
            $boardGame1->id => ['quantity' => 5],
            $boardGame2->id => ['quantity' => 3],
        ]);

        $this->assertCount(2, $sleeve->boardGames);

        $this->assertEquals(5, $sleeve->boardGames->find($boardGame1->id)->pivot->quantity);
        $this->assertEquals(3, $sleeve->boardGames->find($boardGame2->id)->pivot->quantity);
    }
}
