<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use Illuminate\Http\UploadedFile;
use Throwable;

class SleeveService
{
    private const IMG_FOLDER = 'sleeves';

    private FileManager $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function storeImage(UploadedFile $uploadFile): ?string
    {
        try {
            $path = $this->fileManager->saveFile($uploadFile, self::IMG_FOLDER);

            return ($path) ? $path : null;
        } catch (Throwable $th) {
            throw new FileException(__('Image saving error.'));
        }
    }

    public function deleteImage(string $file): bool
    {
        try {
            return $this->fileManager->deleteFile($file);
        } catch (Throwable $th) {
            throw new FileException(__('Image deleting error.'));
        }
    }
}
