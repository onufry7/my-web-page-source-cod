<?php

namespace App\Http\Controllers;

use App\Exceptions\StockSleeveException;
use App\Http\Requests\BoardGameSleeveRequest;
use App\Models\BoardGame;
use App\Models\BoardGameSleeve;
use App\Repositories\BoardGameSleeveRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoardGameSleeveController extends Controller
{
    public function index(BoardGame $boardGame): View
    {
        $boardGame = $boardGame->load('sleeves');

        return view('board-game-sleeve.index', compact('boardGame'));
    }

    public function create(BoardGame $boardGame, BoardGameSleeveRepository $repository): View
    {
        $sleeves = $repository->getSleevesForSelectInput();

        return view('board-game-sleeve.create', compact('boardGame', 'sleeves'));
    }

    public function store(BoardGame $boardGame, BoardGameSleeveRequest $request, BoardGameSleeveRepository $repository): RedirectResponse
    {
        return $repository->store($request)
            ? to_route('board-game-sleeve.index', compact('boardGame'))->banner(__('Added sleeves for :name.', ['name' => $boardGame->name]))
            : to_route('board-game-sleeve.create', compact('boardGame'))->withInput()->dangerBanner(__('Failed to add sleeves to game!'));
    }

    public function destroy(BoardGame $boardGame, int $boardGameSleeveId, BoardGameSleeveRepository $repository): RedirectResponse
    {
        return $repository->delete($boardGameSleeveId)
            ? to_route('board-game-sleeve.index', compact('boardGame'))->banner(__('Deleted sleeves from :name.', ['name' => $boardGame->name]))
            : to_route('board-game-sleeve.index', compact('boardGame'))->dangerBanner(__('Failed to delete sleeves from game!'));
    }

    public function putTheSleeves(BoardGame $boardGame, BoardGameSleeve $boardGameSleeve, BoardGameSleeveRepository $repository): RedirectResponse
    {
        $sleeveName = $boardGameSleeve->getSleeveFullName();

        try {
            return $repository->putTheSleeves($boardGameSleeve->id)
                ? to_route('board-game-sleeve.index', compact('boardGame'))->banner(__('Sleeves :sleeves were put on :name.', ['sleeves' => $sleeveName, 'name' => $boardGame->name]))
                : to_route('board-game-sleeve.index', compact('boardGame'))->dangerBanner(__('Couldn\'t put the sleeves!'));
        } catch (StockSleeveException $e) {
            return to_route('board-game-sleeve.index', compact('boardGame'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function turnOffTheSleeves(BoardGame $boardGame, BoardGameSleeve $boardGameSleeve, BoardGameSleeveRepository $repository): RedirectResponse
    {
        $sleeveName = $boardGameSleeve->getSleeveFullName();

        return $repository->turnOffTheSleeves($boardGameSleeve->id)
            ? to_route('board-game-sleeve.index', compact('boardGame'))->banner(__('The sleeves :sleeves have been removed from :name.', ['sleeves' => $sleeveName, 'name' => $boardGame->name]))
            : to_route('board-game-sleeve.index', compact('boardGame'))->dangerBanner(__('Couldn\'t turn off the sleeves!'));
    }
}
