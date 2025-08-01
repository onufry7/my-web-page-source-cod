<?php

namespace App\Http\Controllers;

use App\Exceptions\FileException;
use App\Filters\CipherFilter;
use App\Http\Requests\CipherRequest;
use App\Models\Cipher;
use App\Repositories\CipherRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CipherController extends Controller
{
    public function index(CipherFilter $filters, CipherRepository $cipherRepository): View
    {
        return view('cipher.index', [
            'ciphers' => $cipherRepository->ciphersPaginated($filters),
        ]);
    }

    public function create(): View
    {
        return view('cipher.create');
    }

    public function store(CipherRequest $request, CipherRepository $cipherRepository): RedirectResponse
    {
        try {
            $cipher = $cipherRepository->store($request);

            return $cipher
                ? to_route('cipher.show', compact('cipher'))->banner(__('Added cipher :name.', ['name' => $cipher->name]))
                : to_route('cipher.create')->withInput()->dangerBanner(__('Failed to add cipher!'));
        } catch (FileException $e) {
            return to_route('cipher.create')->withInput()->dangerBanner($e->getCustomMessage());
        }
    }

    public function show(Cipher $cipher, CipherRepository $cipherRepository): View
    {
        $adjacent = $cipherRepository->adjacentCiphers($cipher->id);

        return view('cipher.show', compact('cipher', 'adjacent'));
    }

    public function edit(Cipher $cipher): View
    {
        return view('cipher.edit', compact('cipher'));
    }

    public function update(CipherRequest $request, Cipher $cipher, CipherRepository $cipherRepository): RedirectResponse
    {
        try {
            return $cipherRepository->update($request, $cipher)
                ? to_route('cipher.show', compact('cipher'))->banner(__('Updated cipher :name.', ['name' => $cipher->name]))
                : to_route('cipher.edit', compact('cipher'))->dangerBanner(__('Failed to update cipher!'));
        } catch (FileException $e) {
            return to_route('cipher.edit', compact('cipher'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function destroy(Cipher $cipher, CipherRepository $cipherRepository): RedirectResponse
    {
        try {
            return $cipherRepository->delete($cipher)
                ? to_route('cipher.index')->banner(__('Deleted cipher :name.', ['name' => $cipher->name]))
                : to_route('cipher.show', compact('cipher'))->dangerBanner(__('Failed to delete cipher!'));
        } catch (FileException $e) {
            return to_route('cipher.show', compact('cipher'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function catalog(CipherRepository $cipherRepository): View
    {
        return view('cipher.catalog', [
            'ciphers' => $cipherRepository->ciphersForListName(),
        ]);
    }
}
