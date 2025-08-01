<?php

namespace App\Http\Controllers;

use App\Enums\BoardGameType;
use App\Exceptions\FileException;
use App\Filters\BoardGameFilter;
use App\Http\Requests\BoardGameRequest;
use App\Models\BoardGame;
use App\Models\Publisher;
use App\Repositories\BoardGameRepository;
use App\Services\BoardGameService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BoardGameController extends Controller
{
    public function index(BoardGameFilter $filters, BoardGameRepository $boardGameRepository, ?string $type = null): View
    {
        return view('board-game.index', [
            'games' => $boardGameRepository->selectGamesPaginated($filters, $type),
            'type' => $type,
        ]);
    }

    public function create(BoardGameRepository $boardGameRepository): View
    {
        return view('board-game.create')->with([
            'baseGames' => $boardGameRepository->baseGames(['id', 'name']),
            'publishers' => Publisher::select('id', 'name')->get(),
            'boardGameType' => BoardGameType::class,
        ]);
    }

    public function store(BoardGameRequest $boardGameRequest, BoardGameRepository $boardGameRepository): RedirectResponse
    {
        try {
            $boardGame = $boardGameRepository->store($boardGameRequest);

            return $boardGame
                ? to_route('board-game.show', compact('boardGame'))->banner(__('Added board game :name.', ['name' => $boardGame->name]))
                : to_route('board-game.create')->withInput()->dangerBanner(__('Failed to add board game!'));
        } catch (FileException $e) {
            return to_route('board-game.create')->withInput()->dangerBanner($e->getCustomMessage());
        }
    }

    public function show(BoardGame $boardGame, BoardGameService $boardGameService): View
    {
        return view('board-game.show', compact('boardGame'))->with([
            'boardGameType' => BoardGameType::class,
            'publishers' => $boardGameService->getPublishers($boardGame),
            'relatedGames' => $boardGameService->relatedGames($boardGame),
        ]);
    }

    public function edit(BoardGame $boardGame, BoardGameRepository $boardGameRepository): View
    {
        return view('board-game.edit', compact('boardGame'))->with([
            'baseGames' => $boardGameRepository->baseGames(['id', 'name'])->except([$boardGame->id]),
            'publishers' => Publisher::select('id', 'name')->get(),
            'boardGameType' => BoardGameType::class,
        ]);
    }

    public function update(BoardGameRequest $boardGameRequest, BoardGame $boardGame, BoardGameRepository $boardGameRepository): RedirectResponse
    {
        try {
            return $boardGameRepository->update($boardGameRequest, $boardGame)
                ? to_route('board-game.show', compact('boardGame'))->banner(__('Updated board game :name.', ['name' => $boardGame->name]))
                : to_route('board-game.edit', compact('boardGame'))->dangerBanner(__('Failed to update board game!'));
        } catch (FileException $e) {
            return to_route('board-game.edit', compact('boardGame'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function destroy(BoardGame $boardGame, BoardGameRepository $boardGameRepository): RedirectResponse
    {
        try {
            return $boardGameRepository->delete($boardGame)
                ? to_route('board-game.index')->banner(__('Deleted board game :name.', ['name' => $boardGame->name]))
                : to_route('board-game.show', compact('boardGame'))->dangerBanner(__('Failed to delete board game!'));
        } catch (FileException $e) {
            return to_route('board-game.show', compact('boardGame'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function downloadInstruction(BoardGame $boardGame, BoardGameService $boardGameService): RedirectResponse|StreamedResponse
    {
        try {
            return $boardGameService->downloadInstruction($boardGame);
        } catch (FileException $e) {
            return back()->dangerBanner($e->getCustomMessage());
        }
    }

    public function addFile(BoardGame $boardGame): View
    {
        return view('file.create', ['model' => $boardGame]);
    }

    public function files(BoardGame $boardGame): View
    {
        return view('board-game.files', compact('boardGame'));
    }

    public function generateSpecificBoardGameList(BoardGameService $boardGameService, BoardGameRepository $boardGameRepository, string $type, ?string $countPlayers = '0'): View
    {
        return view('board-game.specific-list', [
            'games' => $boardGameRepository->gamesForDynamicList($type, $countPlayers),
            'title' => $boardGameService->titleForDynamicList($type),
            'countPlayers' => $countPlayers,
        ]);
    }
}
