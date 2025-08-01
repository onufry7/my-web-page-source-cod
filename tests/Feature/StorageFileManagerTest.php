<?php

namespace Tests\Feature;

use App\Services\StorageFileManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageFileManagerTest extends TestCase
{
    private const STORAGE_DISK = 'public';

    public function test_save_file_return_corrext_name_and_store_file(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $fileManager = new StorageFileManager();
        $file = UploadedFile::fake()->create('instruction.pdf', 200, 'application/pdf');

        $response = $fileManager->saveFile($file, 'test');

        $this->assertEquals('test/' . $file->hashName(), $response);
        Storage::disk(self::STORAGE_DISK)->assertExists('test/' . $file->hashName());
    }

    public function test_delete_file(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $fileManager = new StorageFileManager();
        $file = UploadedFile::fake()->create('instruction.pdf', 200, 'application/pdf')->store('/', self::STORAGE_DISK);

        $fileManager->deleteFile($file, self::STORAGE_DISK);

        Storage::disk(self::STORAGE_DISK)->assertMissing($file);
    }

    public function test_delete_folder(): void
    {
        Storage::fake(self::STORAGE_DISK);

        $fileManager = new StorageFileManager();
        $file1 = UploadedFile::fake()->create('instruction.pdf', 200, 'application/pdf')->store('file-folder/', self::STORAGE_DISK);
        $file2 = UploadedFile::fake()->create('instruction.pdf', 200, 'application/pdf')->store('file-folder/', self::STORAGE_DISK);
        $file3 = UploadedFile::fake()->create('instruction.pdf', 200, 'application/pdf')->store('file-folder/', self::STORAGE_DISK);

        $fileManager->deleteFolder('file-folder', self::STORAGE_DISK);

        Storage::disk(self::STORAGE_DISK)->assertMissing($file1);
        Storage::disk(self::STORAGE_DISK)->assertMissing($file2);
        Storage::disk(self::STORAGE_DISK)->assertMissing($file3);
    }
}
