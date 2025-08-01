<?php

namespace Tests\Unit\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Models\BoardGame;
use App\Services\BoardGameService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class BoardGameServiceTest extends TestCase
{
    public function test_store_box_image_throws_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), Mockery::type('string'))
            ->andThrow(new FileException('Error'));

        $uploadedFile = UploadedFile::fake()->create('cover.png', 100);

        $service = new BoardGameService($fileManagerMock);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Box image saving error.'));

        $service->storeBoxImage($uploadedFile);
    }

    public function test_store_instruction_throws_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), Mockery::type('string'))
            ->andThrow(new FileException('Error'));

        $uploadedFile = UploadedFile::fake()->create('instruction.pdf', 100);

        $service = new BoardGameService($fileManagerMock);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Instruction file saving error.'));

        $service->storeInstruction($uploadedFile);
    }

    public function test_delete_box_image_throws_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('deleteFile')
            ->once()
            ->with('cover.png')
            ->andThrow(new FileException(__('Box image deleting error.')));

        $service = new BoardGameService($fileManagerMock);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Box image deleting error.'));

        $service->deleteBoxImage('cover.png');
    }

    public function test_delete_instruction_throws_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('deleteFile')
            ->once()
            ->with('instruction.pdf')
            ->andThrow(new FileException(__('Instruction file deleting error.')));

        $service = new BoardGameService($fileManagerMock);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Instruction file deleting error.'));

        $service->deleteInstruction('instruction.pdf');
    }

    public function test_delete_folder_throws_exception_on_error(): void
    {
        $fileManager = Mockery::mock(FileManager::class);

        $folderName = 'some-folder';
        $directory = '/board-games/' . $folderName;

        $fileManager->shouldReceive('deleteFolder')
            ->once()
            ->with($directory)
            ->andThrow(new FileException('Deletion failed'));

        $boardGameService = new BoardGameService($fileManager);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Game files deleting error.'));

        $boardGameService->deleteFolder($folderName);
    }

    public function test_download_instruction_throws_exception_on_error(): void
    {
        $fileManager = Mockery::mock(FileManager::class);

        $boardGame = new BoardGame();
        $boardGame->instruction = 'instruction.pdf';
        $boardGame->name = 'name';

        Storage::shouldReceive('disk')
            ->once()
            ->with('public')
            ->andReturnSelf();
        Storage::shouldReceive('exists')
            ->once()
            ->with($boardGame->instruction)
            ->andReturn(true);

        $fileManager->shouldReceive('downloadFile')
            ->once()
            ->with($boardGame->instruction, "$boardGame->name - instrukcja.pdf")
            ->andThrow(new FileException('Download failed'));

        $boardGameService = new BoardGameService($fileManager);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Instruction download error.'));

        $boardGameService->downloadInstruction($boardGame);
    }
}
