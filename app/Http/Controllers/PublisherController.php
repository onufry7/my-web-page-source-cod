<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function index(): View
    {
        $publishers = Publisher::orderBy('name', 'ASC')->paginate(perPage: 40);

        return view('publisher.index', compact('publishers'));
    }

    public function create(): View
    {
        return view('publisher.create');
    }

    public function store(PublisherRequest $request): RedirectResponse
    {
        $publisher = new Publisher($request->validated());

        return $publisher->save()
            ? to_route('publisher.show', compact('publisher'))->banner(__('Added publisher :name.', ['name' => $publisher->name]))
            : to_route('publisher.create')->withInput()->dangerBanner(__('Failed to add publisher!'));
    }

    public function show(Publisher $publisher): View
    {
        return view('publisher.show', compact('publisher'));
    }

    public function edit(Publisher $publisher): View
    {
        return view('publisher.edit', compact('publisher'));
    }

    public function update(PublisherRequest $request, Publisher $publisher): RedirectResponse
    {
        return $publisher->update($request->validated())
            ? to_route('publisher.show', compact('publisher'))->banner(__('Updated publisher :name.', ['name' => $publisher->name]))
            : to_route('publisher.edit', compact('publisher'))->dangerBanner(__('Failed to update publisher!'));
    }

    public function destroy(Publisher $publisher): Redirector|RedirectResponse
    {
        return $publisher->delete()
            ? to_route('publisher.index')->banner(__('Deleted publisher :name.', ['name' => $publisher->name]))
            : to_route('publisher.show', compact('publisher'))->dangerBanner(__('Failed to delete publisher!'));
    }
}
