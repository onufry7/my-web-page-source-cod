<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Exceptions\StockSleeveException;
use App\Models\BoardGameSleeve;
use App\Models\Sleeve;
use App\Repositories\BoardGameSleeveRepository;

class BoardGameSleeveControllerExceptionsTest extends BoardGameSleeveTestCase
{
    public function test_put_the_sleeves_method_handles_file_exception(): void
    {
        $boardGameSleeve = BoardGameSleeve::factory()->create([
            'sleeve_id' => Sleeve::factory()->create()->id,
            'sleeved' => false,
        ]);
        $route = route($this->routePutSleeves, [
            'boardGame' => $boardGameSleeve->boardGame,
            'boardGameSleeve' => $boardGameSleeve->boardGame->sleeves->first()->pivot,
        ]);
        $this->mock(BoardGameSleeveRepository::class, function ($mock) {
            $mock->shouldReceive('putTheSleeves')->andThrow(new StockSleeveException('No put!'));
        });

        $response = $this->actingAs($this->admin)->get($route);

        $response->assertRedirect(route($this->routeIndex, [
            'boardGame' => $boardGameSleeve->boardGame,
        ]))
            ->assertSessionHas('flash.banner', __('No put!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }
}
