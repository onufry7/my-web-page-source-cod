<?php

namespace App\Repositories;

use App\Collections\CipherCollection;
use App\Filters\CipherFilter;
use App\Http\Requests\CipherRequest;
use App\Models\Cipher;
use App\Services\CipherService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CipherRepository
{
    private CipherService $service;

    public function __construct(CipherService $cipherService)
    {
        $this->service = $cipherService;
    }

    public function ciphersForListName(): Collection
    {
        return Cipher::orderBy('name', 'ASC')->get();
    }

    public function ciphersPaginated(CipherFilter $filters, int $paginate = 24): LengthAwarePaginator
    {
        return Cipher::filter($filters)->orderBy('name', 'ASC')->paginate($paginate);
    }

    public function adjacentCiphers(int $id): CipherCollection
    {
        $previousCipher = Cipher::select('name', 'slug')->where('id', '<', $id)->orderBy('id', 'desc')->first();
        $nextCipher = Cipher::select('name', 'slug')->where('id', '>', $id)->orderBy('id', 'asc')->first();

        return new CipherCollection([
            'previous' => $previousCipher,
            'next' => $nextCipher,
        ]);
    }

    public function store(CipherRequest $request): Cipher|false
    {
        $cipher = new Cipher($request->validated());
        $coverImage = $request->file('cover_image');
        $file = $request->file('file');

        if ($request->hasFile('file') && !is_null($file) && !is_array($file)) {
            $cipher->content = $this->service->prepareContentFile($file);
        }

        if ($request->hasFile('cover_image') && !is_null($coverImage) && !is_array($coverImage)) {
            $cipher->cover = $this->service->storeCoverImage($coverImage);
        }

        return $cipher->save() ? $cipher : false;
    }

    public function update(CipherRequest $request, Cipher $cipher): bool
    {
        $coverImage = $request->file('cover_image');
        $file = $request->file('file');

        if ($request->hasFile('file') && !is_null($file) && !is_array($file)) {
            $cipher->content = $this->service->prepareContentFile($file);
        }

        if ($request->hasAny(['delete_cover', 'cover_image']) && !is_null($cipher->cover)) {
            $this->service->deleteCoverImage($cipher->cover);
            $cipher->cover = null;
        }

        if ($request->hasFile('cover_image') && !is_null($coverImage) && !is_array($coverImage)) {
            $cipher->cover = $this->service->storeCoverImage($coverImage);
        }

        return $cipher->update($request->validated());
    }

    public function delete(Cipher $cipher): bool
    {
        if (!is_null($cipher->cover)) {
            $this->service->deleteCoverImage($cipher->cover);
        }

        return ($cipher->delete()) ? true : false;
    }
}
