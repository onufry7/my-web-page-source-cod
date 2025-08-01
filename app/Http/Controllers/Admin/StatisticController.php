<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\BoardGameStatisticService;
use App\Interfaces\StatisticService;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function index(StatisticService $statisticService, BoardGameStatisticService $boardGameStatisticService): View
    {
        return view('admin.statistics.index', [
            'countModels' => $statisticService->countOfIndividualModels(),
            'boardGame' => $boardGameStatisticService->basicStatistics(),
            'topTenGames' => $boardGameStatisticService->topTenGames(),
            'playedToNotPlayed' => $boardGameStatisticService->playToNoPlay(),
            'publishersInCollect' => $boardGameStatisticService->publishersGamesPercentCollect(false),
            'publishersInCollectBaseGame' => $boardGameStatisticService->publishersGamesPercentCollect(true),
            'countGamesForPlayers' => $boardGameStatisticService->numberGamesForNumberPlayers(),
        ]);
    }
}
