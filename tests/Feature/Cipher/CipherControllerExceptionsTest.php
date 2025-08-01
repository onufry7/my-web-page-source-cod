<?php

namespace Tests\Feature\Cipher;

use App\Exceptions\FileException;
use App\Models\Cipher;
use App\Repositories\CipherRepository;
use Illuminate\Http\UploadedFile;

class CipherControllerExceptionsTest extends CipherTestCase
{
    public function test_store_method_handles_file_exception(): void
    {
        $cipherData = Cipher::factory()->make()->toArray();
        $cipherData['file'] = UploadedFile::fake()->create('example.htm');
        $route = route($this->routeStore);

        $this->mock(CipherRepository::class, function ($mock) {
            $mock->shouldReceive('store')->andThrow(new FileException('No stored!'));
        });

        $response = $this->actingAs($this->admin)->post($route, $cipherData);

        $response->assertRedirect(route($this->routeCreate))
            ->assertSessionHas('flash.banner', __('No stored!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
        $this->assertDatabaseMissing('ciphers', array_diff_key($cipherData, ['file' => '']));
    }

    public function test_update_method_handles_file_exception(): void
    {
        $cipher = Cipher::factory()->create();
        $newCipherData = Cipher::factory()->make()->toArray();
        $route = route($this->routeUpdate, ['cipher' => $cipher]);

        $this->mock(CipherRepository::class, function ($mock) {
            $mock->shouldReceive('update')->andThrow(new FileException('No updated!'));
        });

        $response = $this->actingAs($this->admin)->put($route, $newCipherData);

        $response->assertRedirect(route($this->routeEdit, $cipher))
            ->assertSessionHas('flash.banner', __('No updated!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
        $this->assertDatabaseMissing('ciphers', $newCipherData);
    }

    public function test_destroy_method_handles_file_exception(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeDestroy, ['cipher' => $cipher]);

        $this->mock(CipherRepository::class, function ($mock) {
            $mock->shouldReceive('delete')->andThrow(new FileException('No deleted!'));
        });

        $response = $this->actingAs($this->admin)->delete($route, $cipher->toArray());

        $response->assertRedirect(route($this->routeShow, $cipher))
            ->assertSessionHas('flash.banner', __('No deleted!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
        $this->assertDatabaseHas('ciphers', $cipher->toArray());
    }
}
