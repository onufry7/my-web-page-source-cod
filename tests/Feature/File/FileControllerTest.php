<?php

namespace Tests\Feature\File;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileControllerTest extends FileTestCase
{
    private const FILE_DISK = 'public';
    private const DEFAULT_FOLDER = 'documents/';

    public function test_file_stored_method(): void
    {
        Storage::fake(self::FILE_DISK);

        $uploadFile = UploadedFile::fake()->create('otherFile.pdf', 20460, 'application/pdf');
        $file = File::factory()->make(['model_type' => 'App\Models\Test']);
        $data = array_merge($file->toArray(), ['file' => $uploadFile]);
        $folder = self::DEFAULT_FOLDER . $file->model_id;

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), $data);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('files', ['name' => $file->name]);
        Storage::disk(self::FILE_DISK)->assertExists($folder . '/' . $uploadFile->hashName());
    }

    public function test_file_update_method(): void
    {
        $file = File::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $file), [
            'name' => 'New Name',
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('files', ['name' => 'New Name']);
    }

    public function test_file_delete_method(): void
    {
        Storage::fake(self::FILE_DISK);

        $uploadFile = UploadedFile::fake()->create('file.pdf', 20460, 'application/pdf');
        $path = $uploadFile->store(self::DEFAULT_FOLDER, self::FILE_DISK);
        $file = File::factory()->create(['path' => $path]);

        $response = $this->actingAs($this->admin)->delete(route($this->routeDestroy, $file));

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseMissing('files', ['name' => $file->name]);
        Storage::disk(self::FILE_DISK)->assertMissing($file->path);
    }

    public function test_file_download_method(): void
    {
        Storage::fake(self::FILE_DISK);

        $uploadFile = UploadedFile::fake()->create('file.pdf', 2046, 'application/pdf');
        $folder = self::DEFAULT_FOLDER;
        $path = $uploadFile->store($folder, self::FILE_DISK);
        $file = File::factory()->create(['path' => $path]);

        $response = $this->get(route($this->routeDownload, $file));

        $response->assertStatus(200)->assertHeader('content-type', $uploadFile->getClientMimeType());
    }

    public function test_file_download_method_unsuccessful(): void
    {
        $file = File::factory()->create(['path' => 'not-exist-path.pdf']);

        $response = $this->get(route($this->routeDownload, $file));

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
    }
}
