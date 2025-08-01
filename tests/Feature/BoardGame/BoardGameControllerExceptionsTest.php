<?php

namespace Tests\Feature\BoardGame;

use App\Exceptions\FileException;
use App\Models\BoardGame;
use App\Repositories\BoardGameRepository;
use App\Services\BoardGameService;

class BoardGameControllerExceptionsTest extends BoardGameTestCase
{
    public function test_store_method_handles_file_exception(): void
    {
        $boardGameData = BoardGame::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->mock(BoardGameRepository::class, function ($mock) {
            $mock->shouldReceive('store')->andThrow(new FileException('No stored!'));
        });

        $response = $this->actingAs($this->admin)->post($route, $boardGameData);

        $response->assertRedirect(route($this->routeCreate))
            ->assertSessionHas('flash.banner', __('No stored!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
        $this->assertDatabaseMissing('board_games', $boardGameData);
    }

    public function test_update_method_handles_file_exception(): void
    {
        $boardGame = BoardGame::factory()->create();
        $newboardGameData = BoardGame::factory()->make()->toArray();

        $route = route($this->routeUpdate, $boardGame);

        $this->mock(BoardGameRepository::class, function ($mock) {
            $mock->shouldReceive('update')->andThrow(new FileException('No updated!'));
        });

        $response = $this->actingAs($this->admin)->put($route, $newboardGameData);

        $response->assertRedirect(route($this->routeEdit, $boardGame))
            ->assertSessionHas('flash.banner', __('No updated!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
        $this->assertDatabaseMissing('board_games', $newboardGameData);
    }

    public function test_destroy_method_handles_file_exception(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeDestroy, $boardGame);

        $this->mock(BoardGameRepository::class, function ($mock) {
            $mock->shouldReceive('delete')->andThrow(new FileException('No deleted!'));
        });

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirect(route($this->routeShow, $boardGame))
            ->assertSessionHas('flash.banner', __('No deleted!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
        $this->assertDatabaseHas('board_games', $boardGame->toArray());
    }

    public function test_download_instruction_method_handles_file_exception(): void
    {
        $boardGame = BoardGame::factory()->create();
        $route = route($this->routeInstructionDownload, $boardGame);

        $this->mock(BoardGameService::class, function ($mock) {
            $mock->shouldReceive('downloadInstruction')->andThrow(new FileException('No download!'));
        });

        $response = $this->actingAs($this->admin)->get($route);

        $response->assertRedirect()
            ->assertSessionHas('flash.banner', __('No download!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }
}
