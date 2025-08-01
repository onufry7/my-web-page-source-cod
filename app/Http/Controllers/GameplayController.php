<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameplayRequest;
use App\Models\Gameplay;
use App\Repositories\BoardGameRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class GameplayController extends Controller
{
    public function index(): View
    {
        $gameplays = Gameplay::select(['gameplays.*', 'board_games.name as game_name'])
            ->join('board_games', 'board_games.id', '=', 'gameplays.board_game_id')
            ->where('user_id', auth()->id())->orderByDesc('date')->orderBy('game_name')
            ->with('boardGame')->paginate(40);

        $gameplaysCount = Gameplay::where('user_id', auth()->id())->sum('count');

        return view('gameplay.index', compact('gameplays', 'gameplaysCount'));
    }

    public function create(BoardGameRepository $boardGameRepository): View
    {
        return view('gameplay.create', [
            'baseGames' => $boardGameRepository->baseGames(['id', 'name']),
        ]);
    }

    public function store(GameplayRequest $request): Redirector|RedirectResponse
    {
        $gameplay = new Gameplay($request->validated());

        return $gameplay->save()
            ? to_route('gameplay.show', compact('gameplay'))->banner(__('Added gameplay.'))
            : to_route('gameplay.create')->withInput()->dangerBanner(__('Failed to add gameplay!'));
    }

    public function show(Gameplay $gameplay): View
    {
        return view('gameplay.show', compact('gameplay'));
    }

    public function edit(Gameplay $gameplay, BoardGameRepository $boardGameRepository): View
    {
        if (!Gate::allows('isAdmin') && auth()->id() !== $gameplay->user_id) {
            abort(403);
        }

        return view('gameplay.edit', [
            'baseGames' => $boardGameRepository->baseGames(['id', 'name']),
            'gameplay' => $gameplay,
        ]);
    }

    public function update(GameplayRequest $request, Gameplay $gameplay): Redirector|RedirectResponse
    {
        return $gameplay->update($request->validated())
            ? to_route('gameplay.show', compact('gameplay'))->banner(__('Updated gameplay.'))
            : to_route('gameplay.edit', compact('gameplay'))->dangerBanner(__('Failed to update gameplay!'));
    }

    public function destroy(Gameplay $gameplay): Redirector|RedirectResponse
    {
        if (!Gate::allows('isAdmin') && auth()->id() !== $gameplay->user_id) {
            abort(403);
        }

        return $gameplay->delete()
            ? to_route('gameplay.index')->banner(__('Deleted gameplay.'))
            : to_route('gameplay.show', compact('gameplay'))->dangerBanner(__('Failed to delete gameplay!'));
    }
}
