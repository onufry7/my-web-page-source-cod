<?php

namespace App\Services;

use App\Interfaces\FileManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageFileManager implements FileManager
{
    private const DEFAULT_DISK = 'public';

    public function saveFile(UploadedFile $file, string $folder, string $disk = self::DEFAULT_DISK): false|string
    {
        return $file->store($folder, $disk);
    }

    public function deleteFile(string $path, string $disk = self::DEFAULT_DISK): bool
    {
        return (Storage::disk($disk)->exists($path))
            ? Storage::disk($disk)->delete($path)
            : true;
    }

    public function deleteFolder(string $path, string $disk = self::DEFAULT_DISK): bool
    {
        return (Storage::disk($disk)->exists($path))
            ? Storage::disk($disk)->deleteDirectory($path)
            : true;
    }

    public function downloadFile(string $path, string $fileName, string $disk = self::DEFAULT_DISK): StreamedResponse
    {
        $mimeType = Storage::disk($disk)->mimeType($path);
        $headers = ["Content-Type: $mimeType"];

        return Storage::disk($disk)->download($path, $fileName, $headers);
    }
}
