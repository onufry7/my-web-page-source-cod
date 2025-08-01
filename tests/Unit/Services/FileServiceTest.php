<?php

namespace Tests\Unit\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use ReflectionMethod;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    public function test_store_file_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::type(UploadedFile::class), Mockery::type('string'))
            ->andThrow(new FileException('Error'));

        $uploadedFile = UploadedFile::fake()->create('file.txt', 100);

        $request = Mockery::mock(FormRequest::class);
        $request->shouldReceive('input')->with('model_type')->andReturn('App\Models\Project');
        $request->shouldReceive('input')->with('model_id')->andReturn(123);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('File saving error.'));

        $service = new FileService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->storeFile($uploadedFile, $request instanceof FormRequest ? $request : null);
    }

    public function test_delete_file_throws_file_exception_on_error(): void
    {
        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('deleteFile')
            ->once()
            ->with('invalid_path')
            ->andThrow(new FileException('Error'));

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('File deleting error.'));

        $service = new FileService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->deleteFile('invalid_path');
    }

    public function test_download_file_throws_file_exception_when_file_is_missing(): void
    {
        Storage::fake('public');

        $file = new File();
        $file->path = 'non_existent_path';

        $fileManagerMock = Mockery::mock(FileManager::class);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('No file.'));

        $service = new FileService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->downloadFile($file);
    }

    public function test_download_file_throws_file_exception_on_download_error(): void
    {
        $file = new File();
        $file->path = 'path/to/file.txt';
        $file->setAttribute('name', 'file_name');

        Storage::fake('public');
        Storage::disk('public')->put('path/to/file.txt', 'dummy content');

        $fileManagerMock = Mockery::mock(FileManager::class);
        $fileManagerMock->shouldReceive('downloadFile')
            ->once()
            ->with('path/to/file.txt', Mockery::type('string'))
            ->andThrow(new FileException(__('File download error.')));

        $this->expectException(FileException::class);
        $this->expectExceptionMessage(__('File download error.'));

        $service = new FileService($fileManagerMock instanceof FileManager ? $fileManagerMock : null);

        $service->downloadFile($file);
    }

    public function test_prepare_model_folder_for_board_game(): void
    {
        $fileManagerMock = $this->createMock(FileManager::class);
        $service = new FileService($fileManagerMock);
        $method = new ReflectionMethod(FileService::class, 'prepareModelFolder');
        $method->setAccessible(true);

        $folder = $method->invoke($service, 'App\Models\BoardGame');

        $this->assertEquals('board-games', $folder);
    }

    public function test_prepare_model_folder_for_cipher(): void
    {
        $fileManagerMock = $this->createMock(FileManager::class);
        $service = new FileService($fileManagerMock);
        $method = new ReflectionMethod(FileService::class, 'prepareModelFolder');
        $method->setAccessible(true);

        $folder = $method->invoke($service, 'App\Models\Cipher');

        $this->assertEquals('cipher', $folder);
    }

    public function test_prepare_model_folder_for_project(): void
    {
        $fileManagerMock = $this->createMock(FileManager::class);
        $service = new FileService($fileManagerMock);
        $method = new ReflectionMethod(FileService::class, 'prepareModelFolder');
        $method->setAccessible(true);

        $folder = $method->invoke($service, 'App\Models\Project');

        $this->assertEquals('projects', $folder);
    }

    public function test_prepare_model_folder_for_default_case(): void
    {
        $fileManagerMock = $this->createMock(FileManager::class);
        $service = new FileService($fileManagerMock);
        $method = new ReflectionMethod(FileService::class, 'prepareModelFolder');
        $method->setAccessible(true);

        $folder = $method->invoke($service, 'App\Models\OtherModel');

        $this->assertEquals('documents', $folder);
    }
}
