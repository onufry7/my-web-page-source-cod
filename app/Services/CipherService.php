<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use Illuminate\Http\UploadedFile;
use Throwable;

class CipherService
{
    private const COVER_FOLDER = 'ciphers/covers';

    private FileManager $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function storeCoverImage(UploadedFile $uploadFile): ?string
    {
        try {
            $path = $this->fileManager->saveFile($uploadFile, self::COVER_FOLDER);

            return ($path) ? $path : null;
        } catch (Throwable $th) {
            throw new FileException(__('Cover saving error.'));
        }
    }

    public function deleteCoverImage(string $file): bool
    {
        try {
            return $this->fileManager->deleteFile($file);
        } catch (Throwable $th) {
            throw new FileException(__('Cover image deleting error.'));
        }
    }

    public function prepareContentFile(UploadedFile $file): string
    {
        $allowedTags = '<div><span><caption><br><p><b><i><table><tr><td><th><small><ul><ol><li><strong><svg><img><hr>';

        try {
            $fileContent = file_get_contents($file->getRealPath());

            if ($fileContent === false || $fileContent == '') {
                throw new FileException(__('File content probably is empty.'));
            }

            return strip_tags($fileContent, $allowedTags);
        } catch (Throwable $th) {
            report($th);
            throw new FileException(__('The contents of the file could not be read.'));
        }
    }
}
