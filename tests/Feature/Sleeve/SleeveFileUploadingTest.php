<?php

namespace Tests\Feature\Sleeve;

use App\Models\Sleeve;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SleeveFileUploadingTest extends SleeveTestCase
{
    private const STORAGE_DISK = 'public';
    private const IMG_FOLDER = 'sleeves/';

    public function test_sleeve_can_by_stored_with_image(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $image = UploadedFile::fake()->image('image.png')->size(400);

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), [
            'mark' => 'Marka',
            'name' => 'Nazwa',
            'height' => 56,
            'width' => 87,
            'image_file' => $image,
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        Storage::disk(self::STORAGE_DISK)->assertExists(self::IMG_FOLDER . $image->hashName());
    }

    public function test_sleeve_updated_image_when_update(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $newImage = UploadedFile::fake()->image('new.png', 20, 20)->size(600);
        $oldImage = UploadedFile::fake()->image('old.png')->size(400)->store(self::IMG_FOLDER, self::STORAGE_DISK);
        $sleeve = Sleeve::factory()->create([
            'image_path' => $oldImage,
        ]);

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $sleeve), [
            'mark' => $sleeve->mark,
            'name' => $sleeve->name,
            'height' => $sleeve->height,
            'width' => $sleeve->width,
            'image_file' => $newImage,
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('sleeves', ['id' => $sleeve->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($oldImage);
        Storage::disk(self::STORAGE_DISK)->assertExists(self::IMG_FOLDER . $newImage->hashName());
    }

    public function test_deleted_folder_files_on_delete_game(): void
    {
        Storage::fake(self::STORAGE_DISK);
        $image = UploadedFile::fake()->image('image.png')->size(400)->store(self::IMG_FOLDER, self::STORAGE_DISK);
        $sleeve = Sleeve::factory()->create(['image_path' => $image]);

        $response = $this->actingAs($this->admin)->delete(route($this->routeDestroy, $sleeve));

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseMissing('sleeves', ['id' => $sleeve->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($image);
    }
}
