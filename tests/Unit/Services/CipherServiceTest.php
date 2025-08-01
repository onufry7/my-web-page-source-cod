<?php

namespace Tests\Unit\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Services\CipherService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class CipherServiceTest extends TestCase
{
    public function test_store_file_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), Mockery::type('string'))
            ->andThrow(new FileException('Error'));

        $uploadedFile = UploadedFile::fake()->create('file.txt', 100);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Cover saving error.'));

        $service = new CipherService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->storeCoverImage($uploadedFile);
    }

    public function test_delete_file_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('deleteFile')
            ->once()
            ->with('invalid_path')
            ->andThrow(new FileException('Error'));

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('Cover image deleting error.'));

        $service = new CipherService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->deleteCoverImage('invalid_path');
    }

    public function test_prepare_content_file_throws_exception_when_file_content_is_empty(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('empty_file.txt', '');
        $uploadFile = UploadedFile::fake()->create('empty_file.txt', 0);
        $fileManagerMock = Mockery::mock(FileManager::class);

        $cipherService = new CipherService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('The contents of the file could not be read.'));

        $cipherService->prepareContentFile($uploadFile);
    }
}
