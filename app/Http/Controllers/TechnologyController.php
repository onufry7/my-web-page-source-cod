<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnologyRequest;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class TechnologyController extends Controller
{
    public function index(): View
    {
        $technologies = Technology::paginate(40);

        return view('technology.index', compact('technologies'));
    }

    public function create(): View
    {
        return view('technology.create');
    }

    public function store(TechnologyRequest $request): RedirectResponse
    {
        $technology = new Technology($request->validated());

        return $technology->save()
            ? to_route('technology.show', compact('technology'))->banner(__('Added technology :name.', ['name' => $technology->name]))
            : to_route('technology.create')->withInput()->dangerBanner(__('Failed to add technology!'));
    }

    public function show(Technology $technology): View
    {
        return view('technology.show', compact('technology'));
    }

    public function edit(Technology $technology): View
    {
        return view('technology.edit', compact('technology'));
    }

    public function update(TechnologyRequest $request, Technology $technology): RedirectResponse
    {
        return $technology->update($request->validated())
            ? to_route('technology.show', compact('technology'))->banner(__('Updated technology :name.', ['name' => $technology->name]))
            : to_route('technology.edit', compact('technology'))->dangerBanner(__('Failed to update technology!'));
    }

    public function destroy(Technology $technology): Redirector|RedirectResponse
    {
        return $technology->delete()
            ? to_route('technology.index')->banner(__('Deleted technology :name.', ['name' => $technology->name]))
            : to_route('technology.show', compact('technology'))->dangerBanner(__('Failed to delete technology!'));
    }
}
