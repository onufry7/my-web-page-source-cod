<?php

namespace Tests\Feature\File;

use App\Exceptions\FileException;
use App\Models\File;
use App\Repositories\FileRepository;
use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileControllerExceptionsTest extends FileTestCase
{
    public function test_store_method_handles_file_exception(): void
    {
        Storage::fake('public');

        $uploadFile = UploadedFile::fake()->create('otherFile.pdf', 20460, 'application/pdf');
        $file = File::factory()->make();
        $data = array_merge($file->toArray(), ['file' => $uploadFile]);
        $this->mock(FileRepository::class, function ($mock) {
            $mock->shouldReceive('store')->andThrow(new FileException('No stored!'));
        });

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), $data);

        $response->assertRedirect()
            ->assertSessionHas('flash.banner', __('No stored!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_update_method_handles_file_exception(): void
    {
        $file = File::factory()->create();
        $newFileData = File::factory()->make()->toArray();
        $this->mock(FileRepository::class, function ($mock) {
            $mock->shouldReceive('update')->andThrow(new FileException('No updated!'));
        });

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $file), $newFileData);

        $response->assertRedirect()
            ->assertSessionHas('flash.banner', __('No updated!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_destroy_method_handles_file_exception(): void
    {
        Storage::fake('public');

        $uploadFile = UploadedFile::fake()->create('file.pdf', 20460, 'application/pdf');
        $path = $uploadFile->store('default-folder', 'public');
        $file = File::factory()->create(['path' => $path]);
        $this->mock(FileRepository::class, function ($mock) {
            $mock->shouldReceive('delete')->andThrow(new FileException('No deleted!'));
        });

        $response = $this->actingAs($this->admin)->delete(route($this->routeDestroy, $file));

        $response->assertRedirect()
            ->assertSessionHas('flash.banner', __('No deleted!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }

    public function test_download_instruction_method_handles_file_exception(): void
    {
        Storage::fake('public');

        $uploadFile = UploadedFile::fake()->create('file.pdf', 2046, 'application/pdf');
        $path = $uploadFile->store('folder', 'public');
        $file = File::factory()->create(['path' => $path]);
        $this->mock(FileService::class, function ($mock) {
            $mock->shouldReceive('downloadFile')->andThrow(new FileException('No download!'));
        });

        $response = $this->get(route($this->routeDownload, $file));

        $response->assertRedirect()
            ->assertSessionHas('flash.banner', __('No download!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');
    }
}
