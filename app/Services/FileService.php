<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class FileService
{
    private FileManager $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function storeFile(UploadedFile $uploadFile, FormRequest $request): false|string
    {
        try {
            $folder = $this->prepareModelFolder($request->input('model_type'));
            $folder .= '/' . var_export($request->input('model_id'), true);

            return $this->fileManager->saveFile($uploadFile, $folder);
        } catch (Throwable $th) {
            throw new FileException(__('File saving error.'));
        }
    }

    public function deleteFile(string $file): bool
    {
        try {
            return $this->fileManager->deleteFile($file);
        } catch (Throwable $th) {
            throw new FileException(__('File deleting error.'));
        }
    }

    public function downloadFile(File $file): StreamedResponse
    {
        if (empty($file->path) || !Storage::disk('public')->exists($file->path)) {
            throw new FileException(__('No file.'));
        }

        $extension = pathinfo($file->path, PATHINFO_EXTENSION);
        $fileName = Str::lower($file->getNameWithModelName()) . '.' . $extension;

        try {
            return $this->fileManager->downloadFile($file->path, $fileName);
        } catch (Throwable $th) {
            throw new FileException(__('File download error.'));
        }
    }

    private function prepareModelFolder(mixed $model): string
    {
        return match ($model) {
            'App\Models\BoardGame' => 'board-games',
            'App\Models\Cipher' => 'cipher',
            'App\Models\Project' => 'projects',
            default => 'documents',
        };
    }
}
