<?php

namespace App\Http\Controllers;

use App\Exceptions\FileException;
use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Models\File;
use App\Repositories\FileRepository;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function index(FileRepository $fileRepository): View
    {
        $files = $fileRepository->filesPaginated();

        return view('file.index', compact('files'));
    }

    public function store(FileStoreRequest $request, FileRepository $fileRepository): RedirectResponse
    {
        try {
            $file = $fileRepository->store($request);

            return $file
                ? to_route('file.show', compact('file'))->banner(__('Added file :name.', ['name' => $file->name]))
                : back()->withInput()->dangerBanner(__('File added failed.'));
        } catch (FileException $e) {
            return back()->dangerBanner($e->getCustomMessage());
        }
    }

    public function show(File $file): View
    {
        return view('file.show', compact('file'));
    }

    public function edit(File $file): View
    {
        return view('file.edit', compact('file'));
    }

    public function update(FileUpdateRequest $request, File $file, FileRepository $fileRepository): RedirectResponse
    {
        try {
            return $fileRepository->update($request, $file)
                ? to_route('file.show', compact('file'))->banner(__('Updated file :name.', ['name' => $file->name]))
                : to_route('file.edit', compact('file'))->dangerBanner(__('File name updated failed.'));
        } catch (FileException $e) {
            return back()->dangerBanner($e->getCustomMessage());
        }
    }

    public function destroy(File $file, FileRepository $fileRepository): RedirectResponse
    {
        try {
            return $fileRepository->delete($file)
                ? to_route('file.index', compact('file'))->banner(__('Deleted file :name.', ['name' => $file->name]))
                : to_route('file.show', compact('file'))->dangerBanner(__('File could not be deleted.'));
        } catch (FileException $e) {
            return back()->dangerBanner($e->getCustomMessage());
        }
    }

    public function download(File $file, FileService $service): RedirectResponse|StreamedResponse
    {
        try {
            return $service->downloadFile($file);
        } catch (FileException $e) {
            return back()->dangerBanner($e->getCustomMessage());
        }
    }
}
