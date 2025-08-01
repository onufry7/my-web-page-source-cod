<?php

namespace Tests\Unit\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Services\SleeveService;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class SleeveServiceTest extends TestCase
{
    public function test_store_image_successfully_saves_file(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), 'sleeves')
            ->andReturn('/path/to/saved/image.jpg');

        $uploadedFile = UploadedFile::fake()->create('image.jpg', 100);

        $service = new SleeveService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $result = $service->storeImage($uploadedFile);

        $this->assertEquals('/path/to/saved/image.jpg', $result);
    }

    public function test_store_image_returns_null_when_path_is_empty(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), 'sleeves')
            ->andReturn(null);

        $uploadedFile = UploadedFile::fake()->create('image.jpg', 100);
        $service = new SleeveService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

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
            ->with(Mockery::type(UploadedFile::class), 'sleeves')
            ->andThrow(new FileException(__('Image saving error.')));

        $uploadedFile = UploadedFile::fake()->create('image.jpg', 100);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Image saving error.'));

        $service = new SleeveService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);
        $service->storeImage($uploadedFile);
    }

    public function test_delete_image_successfully_deletes_file(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('deleteFile')
            ->once()
            ->with('image.jpg')
            ->andReturn(true);

        $service = new SleeveService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $result = $service->deleteImage('image.jpg');

        $this->assertTrue($result);
    }

    public function test_delete_image_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock
            ->shouldReceive('deleteFile')
            ->once()
            ->with('image.jpg')
            ->andThrow(new FileException(__('Image deleting error.')));

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Image deleting error.'));

        $service = new SleeveService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->deleteImage('image.jpg');
    }
}
