<?php

namespace Tests\Feature\Cipher;

use App\Models\Cipher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CipherFileUploadingTest extends CipherTestCase
{
    private const STORAGE_DISK = 'public';
    private const COVER_FOLDER = 'ciphers/covers/';

    public function test_cipher_can_by_stored_with_cover_file(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $file = UploadedFile::fake()->create('template.htm')->size(100);
        file_put_contents($file, '<p>Content</p>');

        $cover = UploadedFile::fake()->image('cover.png', 20, 20)->size(400);

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), [
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'cover_image' => $cover,
            'file' => $file,
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();
        Storage::disk(self::STORAGE_DISK)->assertExists(self::COVER_FOLDER . $cover->hashName());
    }

    public function test_cipher_updated_cover_image_when_update(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $oldCover = UploadedFile::fake()->image('old-cover.png', 20, 20)
            ->size(400)->store(self::COVER_FOLDER, self::STORAGE_DISK);
        $newCover = UploadedFile::fake()->image('new-cover.png', 20, 20)->size(600);
        $cipher = Cipher::factory()->create(['cover' => $oldCover]);

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $cipher), [
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'cover_image' => $newCover,
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('ciphers', ['id' => $cipher->id, 'cover' => null]);
        Storage::disk(self::STORAGE_DISK)->assertExists(self::COVER_FOLDER . $newCover->hashName());
        Storage::disk(self::STORAGE_DISK)->assertMissing($oldCover);
    }

    public function test_cipher_cover_image_can_by_deleted_on_update(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $cover = UploadedFile::fake()->image('cover.png', 20, 20)
            ->size(400)->store(self::COVER_FOLDER, self::STORAGE_DISK);
        $cipher = Cipher::factory()->create(['cover' => $cover]);
        $route = route($this->routeUpdate, $cipher);

        $response = $this->actingAs($this->admin)->put($route, [
            'delete_cover' => 'on',
            'name' => 'Nazwa',
            'slug' => 'nazwa',
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseHas('ciphers', ['id' => $cipher->id, 'cover' => null]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($cover);
    }

    public function test_cipher_delete_cover_image_when_delete_record(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $cover = UploadedFile::fake()->image('cover.png', 200, 100)->size(450)
            ->store(self::COVER_FOLDER, self::STORAGE_DISK);
        $cipher = Cipher::factory()->create(['cover' => $cover]);
        $route = route($this->routeDestroy, $cipher);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('ciphers', ['id' => $cipher->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($cover);
    }
}
