<?php

namespace App\Http\Controllers;

use App\Http\Requests\AphorismRequest;
use App\Models\Aphorism;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AphorismController extends Controller
{
    public function index(): View
    {
        return view('aphorism.index', [
            'aphorisms' => Aphorism::orderBy('id', 'ASC')->paginate(40),
        ]);
    }

    public function create(): View
    {
        return view('aphorism.create');
    }

    public function store(AphorismRequest $request): RedirectResponse
    {
        $aphorism = new Aphorism($request->validated());

        return $aphorism->save()
            ? to_route('aphorism.show', $aphorism)->banner(__('Added aphorism.'))
            : to_route('aphorism.create')->withInput()->dangerBanner(__('Failed to add aphorism!'));
    }

    public function show(Aphorism $aphorism): View
    {
        return view('aphorism.show', compact('aphorism'));
    }

    public function edit(Aphorism $aphorism): View
    {
        return view('aphorism.edit', compact('aphorism'));
    }

    public function update(AphorismRequest $request, Aphorism $aphorism): RedirectResponse
    {
        return $aphorism->update($request->validated())
            ? to_route('aphorism.show', $aphorism)->banner(__('Updated aphorism.'))
            : to_route('aphorism.edit', compact('aphorism'))->dangerBanner(__('Failed to update aphorism!'));
    }

    public function destroy(Aphorism $aphorism): RedirectResponse
    {
        return $aphorism->delete()
            ? to_route('aphorism.index')->banner(__('Deleted aphorism.'))
            : to_route('aphorism.index')->dangerBanner(__('Failed to delete aphorism!'));
    }
}
