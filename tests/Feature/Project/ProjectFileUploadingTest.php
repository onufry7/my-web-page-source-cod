<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectFileUploadingTest extends ProjectTestCase
{
    private const STORAGE_DISK = 'public';
    private const COVER_FOLDER = 'projects/covers/';

    public function test_project_can_by_stored_with_cover_file(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $cover = UploadedFile::fake()->image('cover.png', 20, 20)->size(400);

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), [
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'url' => 'http://test.com',
            'image' => $cover,
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();
        Storage::disk(self::STORAGE_DISK)->assertExists(self::COVER_FOLDER . $cover->hashName());
    }

    public function test_project_updated_cover_image_when_update(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $oldCover = UploadedFile::fake()->image('old-cover.png', 20, 20)->size(400)
            ->store(self::COVER_FOLDER, self::STORAGE_DISK);
        $newCover = UploadedFile::fake()->image('new-cover.png', 20, 20)->size(600);
        $project = Project::factory(1)->create(['image_path' => $oldCover])->first();

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $project), [
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'url' => 'http://test.com',
            'image' => $newCover,
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('projects', ['id' => $project->id, 'image_path' => null]);
        Storage::disk(self::STORAGE_DISK)->assertExists(self::COVER_FOLDER . $newCover->hashName());
        Storage::disk(self::STORAGE_DISK)->assertMissing($oldCover);
    }

    public function test_project_cover_image_can_by_deleted_on_update(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $cover = UploadedFile::fake()->image('old-cover.png', 200, 100)->size(450)
            ->store(self::COVER_FOLDER, self::STORAGE_DISK);
        $project = Project::factory(1)->create(['image_path' => $cover])->first();
        $route = route($this->routeUpdate, $project);

        $response = $this->actingAs($this->admin)->put($route, [
            'delete_image' => 'on',
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'url' => 'http://test.com',
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'image_path' => null]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($cover);
    }

    public function test_project_delete_cover_image_when_delete_record(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $cover = UploadedFile::fake()->image('cover.png', 200, 100)->size(450)
            ->store(self::COVER_FOLDER, self::STORAGE_DISK);
        $project = Project::factory(1)->create([
            'image_path' => $cover,
        ])->first();
        $route = route($this->routeDestroy, $project);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($cover);
    }
}
