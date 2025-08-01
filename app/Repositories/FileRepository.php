<?php

namespace App\Repositories;

use App\Exceptions\FileException;
use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Pagination\LengthAwarePaginator;

class FileRepository
{
    private FileService $service;

    public function __construct(FileService $fileService)
    {
        $this->service = $fileService;
    }

    public function filesPaginated(int $paginate = 40): LengthAwarePaginator
    {
        return File::orderBy('name', 'ASC')->paginate($paginate);
    }

    public function store(FileStoreRequest $request): false|File
    {
        $fileModel = new File($request->validated());
        $file = $request->file('file');

        if ($request->hasFile('file') && !is_null($file) && !is_array($file)) {
            $path = $this->service->storeFile($file, $request);
        }

        if (isset($path) && $path !== false) {
            $fileModel->path = $path;
        } else {
            throw new FileException(__('File path return null or false!'));
        }

        return ($fileModel->save()) ? $fileModel : false;
    }

    public function update(FileUpdateRequest $request, File $fileModel): bool
    {
        return $fileModel->update($request->validated());
    }

    public function delete(File $fileModel): ?bool
    {
        if (!empty($fileModel->path)) {
            $this->service->deleteFile($fileModel->path);
        }

        return $fileModel->delete();
    }
}
