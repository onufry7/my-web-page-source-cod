<?php

namespace App\Http\Controllers\SingleActions;

use App\Enums\BoardGameType;
use App\Http\Controllers\Controller;
use App\Models\BoardGame;
use App\Models\Gameplay;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function __invoke(): View
    {
        $top10Games = Gameplay::with('boardGame')
            ->select('board_game_id', DB::raw('sum(count) as total_count'))
            ->groupBy('board_game_id')
            ->where('user_id', auth()->id())
            ->orderByDesc('total_count')
            ->limit(10)
            ->get();

        $gameplaysCount = Gameplay::where('user_id', auth()->id())->sum('count');

        $unplayedGamesCount = BoardGame::leftJoin('gameplays', function ($join) {
            $join->on('board_games.id', '=', 'gameplays.board_game_id')
                ->where('gameplays.user_id', auth()->id());
        })
            ->whereNull('gameplays.board_game_id')
            ->where('type', BoardGameType::BaseGame->value)
            ->count();

        $gameplaysCountByYear = Gameplay::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('SUM(count) as total_count')
        )
            ->where('user_id', auth()->id())
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderByDesc(DB::raw('YEAR(date)'))
            ->limit(10)
            ->get();

        $subQuery = DB::table('gameplays')
            ->selectRaw('YEAR(date) AS year, board_game_id, SUM(count) AS total_count, ROW_NUMBER() OVER (PARTITION BY YEAR(date) ORDER BY SUM(count) DESC) AS rn')
            ->where('user_id', auth()->id())
            ->groupBy('board_game_id', 'year');
        $mostPopularGameByYear = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery)
            ->leftJoin('board_games', 'board_games.id', '=', 'sub.board_game_id')
            ->select('sub.year', 'board_games.name')
            ->where('sub.rn', auth()->id())
            ->orderBy('sub.year', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('top10Games', 'gameplaysCount', 'unplayedGamesCount', 'gameplaysCountByYear', 'mostPopularGameByYear'));
    }
}
