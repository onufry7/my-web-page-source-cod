<?php

namespace App\Http\Controllers;

use App\Exceptions\FileException;
use App\Http\Requests\CorrectSleeveRequest;
use App\Http\Requests\SleeveRequest;
use App\Models\Sleeve;
use App\Repositories\SleeveRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class SleeveController extends Controller
{
    public function index(SleeveRepository $sleeveRepository): View
    {
        $sleeves = $sleeveRepository->getAllOrderedPaginatedSleeves(40);

        return view('sleeve.index', compact('sleeves'));
    }

    public function create(): View
    {
        return view('sleeve.create');
    }

    public function store(SleeveRequest $request, SleeveRepository $sleeveRepository): RedirectResponse
    {
        try {
            $sleeve = $sleeveRepository->store($request);

            return $sleeve
                ? to_route('sleeve.show', compact('sleeve'))->banner(__('Added sleeves :name.', ['name' => $sleeve->getFullName()]))
                : to_route('sleeve.create')->withInput()->dangerBanner(__('Failed to add sleeves!'));
        } catch (FileException $e) {
            return to_route('sleeve.create')->withInput()->dangerBanner($e->getCustomMessage());
        }
    }

    public function show(Sleeve $sleeve): View
    {
        $corrects = $sleeve->load('correctSleeves')->correctSleeves()->orderBy('created_at', 'desc')->paginate(25, ['*'], 'correctPage');
        $games = $sleeve->load('boardGames')->boardGames()->orderBy('name', 'asc')->paginate(25, ['*'], 'gamePage');

        return view('sleeve.show', compact('sleeve', 'corrects', 'games'));
    }

    public function edit(Sleeve $sleeve): View
    {
        return view('sleeve.edit', compact('sleeve'));
    }

    public function update(SleeveRequest $request, Sleeve $sleeve, SleeveRepository $sleeveRepository): RedirectResponse
    {
        try {
            return $sleeveRepository->update($request, $sleeve)
                ? to_route('sleeve.show', compact('sleeve'))->banner(__('Updated sleeves :name.', ['name' => $sleeve->getFullName()]))
                : to_route('sleeve.edit', compact('sleeve'))->dangerBanner(__('Failed to update sleeves!'));
        } catch (FileException $e) {
            return to_route('sleeve.edit', compact('sleeve'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function destroy(Sleeve $sleeve, SleeveRepository $sleeveRepository): Redirector|RedirectResponse
    {
        try {
            return $sleeveRepository->delete($sleeve)
                ? to_route('sleeve.index')->banner(__('Deleted sleeves :name.', ['name' => $sleeve->getFullName()]))
                : to_route('sleeve.show', compact('sleeve'))->dangerBanner(__('Failed to delete sleeves!'));
        } catch (FileException $e) {
            return to_route('sleeve.show', compact('sleeve'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function stock(Sleeve $sleeve): View
    {
        return view('sleeve.stock', compact('sleeve'));
    }

    public function stockUpdate(CorrectSleeveRequest $request, Sleeve $sleeve, SleeveRepository $sleeveRepository): RedirectResponse
    {
        return $sleeveRepository->stockUpdate($request, $sleeve)
            ? to_route('sleeve.show', compact('sleeve'))->banner(__('Updated stock sleeves :name.', ['name' => $sleeve->getFullName()]))
            : to_route('sleeve.stock', compact('sleeve'))->dangerBanner(__('Failed to update stock sleeves!'));
    }
}
