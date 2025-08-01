<?php

namespace Tests\Unit\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Services\ProjectService;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class ProjectServiceTest extends TestCase
{
    public function test_store_image_successfully_saves_file(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), 'projects/covers')
            ->andReturn('/path/to/saved/cover.png');

        $uploadedFile = UploadedFile::fake()->create('cover.png', 100);

        $service = new ProjectService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $result = $service->storeImage($uploadedFile);

        $this->assertEquals('/path/to/saved/cover.png', $result);
    }

    public function test_store_image_returns_null_when_path_is_empty(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), 'projects/covers')
            ->andReturn(null);

        $uploadedFile = UploadedFile::fake()->create('cover.png', 100);
        $service = new ProjectService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $this->expectException(FileException::class);

        $result = $service->storeImage($uploadedFile);

        $this->assertNull($result);
    }

    public function test_store_image_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), 'projects/covers')
            ->andThrow(new FileException(__('Image saving error.')));

        $uploadedFile = UploadedFile::fake()->create('cover.png', 100);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Image saving error.'));

        $service = new ProjectService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);
        $service->storeImage($uploadedFile);
    }

    public function test_delete_image_successfully_deletes_file(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('deleteFile')
            ->once()
            ->with('cover.png')
            ->andReturn(true);

        $service = new ProjectService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $result = $service->deleteImage('cover.png');

        $this->assertTrue($result);
    }

    public function test_delete_image_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('deleteFile')
            ->once()
            ->with('cover.png')
            ->andThrow(new FileException(__('Image deleting error.')));

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Image deleting error.'));

        $service = new ProjectService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->deleteImage('cover.png');
    }
}
