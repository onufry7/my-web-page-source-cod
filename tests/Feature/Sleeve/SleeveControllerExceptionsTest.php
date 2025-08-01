<?php

namespace Tests\Feature\Sleeve;

use App\Exceptions\FileException;
use App\Models\Sleeve;
use App\Repositories\SleeveRepository;

class SleeveControllerExceptionsTest extends SleeveTestCase
{
    public function test_store_method_handles_file_exception(): void
    {
        $sleeveData = Sleeve::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->mock(SleeveRepository::class, function ($mock) {
            $mock->shouldReceive('store')->andThrow(new FileException('No stored!'));
        });

        $response = $this->actingAs($this->admin)->post($route, $sleeveData);

        $response->assertRedirect(route($this->routeCreate))
            ->assertSessionHas('flash.banner', __('No stored!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_update_method_handles_file_exception(): void
    {
        $sleeve = Sleeve::factory()->create();
        $newSleeveData = Sleeve::factory()->make()->toArray();

        $route = route($this->routeUpdate, $sleeve);

        $this->mock(SleeveRepository::class, function ($mock) {
            $mock->shouldReceive('update')->andThrow(new FileException('No updated!'));
        });

        $response = $this->actingAs($this->admin)->put($route, $newSleeveData);

        $response->assertRedirect(route($this->routeEdit, $sleeve))
            ->assertSessionHas('flash.banner', __('No updated!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_destroy_method_handles_file_exception(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeDestroy, $sleeve);

        $this->mock(SleeveRepository::class, function ($mock) {
            $mock->shouldReceive('delete')->andThrow(new FileException('No deleted!'));
        });

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirect(route($this->routeShow, $sleeve))
            ->assertSessionHas('flash.banner', __('No deleted!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }
}
