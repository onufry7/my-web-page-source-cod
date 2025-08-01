<?php

namespace Tests\Feature\BoardGame;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BoardGameFileUploadingTest extends BoardGameTestCase
{
    private const STORAGE_DISK = 'public';
    private const IMG_BOX_FOLDER = 'board-games/boxes/';
    private const INSTRUCTION_FOLDER = 'board-games/instructions/';

    public function test_board_game_can_by_stored_with_box_image(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $file = UploadedFile::fake()->image('box.png')->size(400);

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), [
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'box_image' => $file,
            'type' => BoardGameType::BaseGame->value,
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        Storage::disk(self::STORAGE_DISK)->assertExists(self::IMG_BOX_FOLDER . $file->hashName());
    }

    public function test_board_game_updated_box_image_when_update(): void
    {
        $this->checkAvailabilityGDExtension();
        Storage::fake(self::STORAGE_DISK);

        $newFile = UploadedFile::fake()->image('new-box.png', 20, 20)->size(600);
        $oldFile = UploadedFile::fake()->image('old-box.png')->size(400)->store(self::IMG_BOX_FOLDER, self::STORAGE_DISK);
        $boardGame = BoardGame::factory()->create([
            'box_img' => $oldFile,
            'type' => BoardGameType::BaseGame->value,
        ]);

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $boardGame), [
            'name' => $boardGame->name,
            'slug' => $boardGame->slug,
            'box_image' => $newFile,
            'type' => BoardGameType::BaseGame->value,
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('board_games', ['id' => $boardGame->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($oldFile);
        Storage::disk(self::STORAGE_DISK)->assertExists(self::IMG_BOX_FOLDER . $newFile->hashName());
    }

    public function test_board_game_can_by_stored_with_instruction_file(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $file = UploadedFile::fake()->create('instruction.pdf', 20480, 'application/pdf');

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), [
            'name' => 'Nazwa',
            'slug' => 'nazwa',
            'instruction_file' => $file,
            'type' => BoardGameType::BaseGame->value,
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        Storage::disk(self::STORAGE_DISK)->assertExists(self::INSTRUCTION_FOLDER . $file->hashName());
    }

    public function test_board_game_updated_instruction_file_when_update(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $path = self::STORAGE_DISK . '/' . self::INSTRUCTION_FOLDER;
        $oldFile = UploadedFile::fake()->create('instruction_old.pdf', 17480, 'application/pdf')->store($path, self::STORAGE_DISK);
        $newFile = UploadedFile::fake()->create('instruction_new.pdf', 20480, 'application/pdf');
        $boardGame = BoardGame::factory()->create([
            'instruction' => $oldFile,
            'type' => BoardGameType::BaseGame->value,
        ]);

        $response = $this->actingAs($this->admin)->put(route($this->routeUpdate, $boardGame), [
            'name' => $boardGame->name,
            'slug' => $boardGame->slug,
            'instruction_file' => $newFile,
            'type' => BoardGameType::BaseGame->value,
        ]);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        Storage::disk(self::STORAGE_DISK)->assertMissing($oldFile);
        Storage::disk(self::STORAGE_DISK)->assertExists(self::INSTRUCTION_FOLDER . $newFile->hashName());
    }

    public function test_deleted_box_image_and_instruction_files_from_disc(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $boxImage = UploadedFile::fake()->image('old-box.png', 200, 100)->size(450)
            ->store(self::IMG_BOX_FOLDER, self::STORAGE_DISK);
        $instruction = UploadedFile::fake()->create('instruction.pdf', 17480, 'application/pdf')
            ->store(self::INSTRUCTION_FOLDER, self::STORAGE_DISK);
        $boardGame = BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
            'instruction' => $instruction,
            'box_img' => $boxImage,
        ]);

        $response = $this->actingAs($this->admin)->delete(route($this->routeDestroy, $boardGame));

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseMissing('board_games', ['id' => $boardGame->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($boxImage);
        Storage::disk(self::STORAGE_DISK)->assertMissing($instruction);
    }

    public function test_instruction_download(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $instruction = UploadedFile::fake()->create('instruction.pdf', 1748, 'application/pdf');
        $path = $instruction->store(self::INSTRUCTION_FOLDER, self::STORAGE_DISK);
        $boardGame = BoardGame::factory()->create(['instruction' => $path]);

        $response = $this->get(route($this->routeInstructionDownload, $boardGame));

        $response->assertStatus(200)->assertHeader('content-type', $instruction->getClientMimeType());
    }

    public function test_instruction_download_unsuccessful(): void
    {
        $boardGame = BoardGame::factory()->create(['instruction' => 'not-exist-path.pdf']);

        $response = $this->get(route($this->routeInstructionDownload, $boardGame));

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
    }

    public function test_deleted_folder_files_on_delete_game(): void
    {
        Storage::fake(self::STORAGE_DISK);
        $boardGame = BoardGame::factory()->create(['type' => BoardGameType::BaseGame->value]);
        $filesFolder = '/board-games/' . $boardGame->id;
        $fileUpload = UploadedFile::fake()->create('file.pdf', 200, 'application/pdf')->store($filesFolder, self::STORAGE_DISK);
        $fileRecord = File::factory()->create([
            'path' => $fileUpload,
            'model_id' => $boardGame->id,
            'model_type' => $boardGame::class,
        ]);

        $response = $this->actingAs($this->admin)->delete(route($this->routeDestroy, $boardGame));

        $response->assertRedirect()->assertSessionDoesntHaveErrors();
        $this->assertDatabaseMissing('board_games', ['id' => $boardGame->id]);
        $this->assertDatabaseMissing('files', ['id' => $fileRecord->id]);
        Storage::disk(self::STORAGE_DISK)->assertMissing($filesFolder);
        Storage::disk(self::STORAGE_DISK)->assertMissing($fileUpload);
    }
}
