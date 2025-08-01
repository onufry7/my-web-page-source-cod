<?php

namespace App\Interfaces;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileManager
{
    public function saveFile(UploadedFile $file, string $folder, string $disk = 'local'): false|string;

    public function deleteFile(string $path, string $disk = 'local'): bool;

    public function deleteFolder(string $path, string $disk = 'local'): bool;

    public function downloadFile(string $path, string $fileName, string $disk = 'local'): StreamedResponse;
}
