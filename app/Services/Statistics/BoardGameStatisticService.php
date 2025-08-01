<?php

namespace App\Services\Statistics;

use App\Enums\BoardGameType;
use App\Interfaces\BoardGameStatisticService as BoardGameStatisticServiceInterface;
use App\Models\BoardGame;
use App\Models\Gameplay;
use App\Models\Publisher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BoardGameStatisticService implements BoardGameStatisticServiceInterface
{
    private int $gameCount = 0;
    private Collection $games;
    private Collection $gameplays;

    public function __construct()
    {
        $this->gameplays = Gameplay::all();
        $this->games = BoardGame::all();
        $this->gameCount = $this->games->count();
    }

    public function basicStatistics(): Collection
    {
        return collect([
            'baseCount' => $this->games->where('type', BoardGameType::BaseGame->value)->count(),
            'expansionCount' => $this->games->where('type', '!=', BoardGameType::BaseGame->value)->count(),
            'withoutInstructionCount' => $this->games->where('need_instruction', true)->whereNull('instruction')->count(),
            'neededInsertCount' => $this->games->where('need_insert', true)->count(),
            'toSleeved' => BoardGame::whereHas('boardGameSleeves', function ($query) {
                $query->where('sleeved', 0);
            })->count(),
            'toPainting' => $this->games->where('to_painting', true)->count(),
            'totalGameCount' => $this->gameCount,
        ]);
    }

    public function publishersGamesPercentCollect(bool $onlyBase): Collection
    {
        if ($onlyBase) {
            $publishers = Publisher::withCount(['publishBoardGames as publish_board_games_count' => function ($query) {
                $query->where('type', BoardGameType::BaseGame->value);
            }])->having('publish_board_games_count', '>', 0)->get();
            $countGamesWithoutPublishers = $this->games->whereNull('publisher_id')->where('type', BoardGameType::BaseGame->value);
            $allGames = $this->games->filter(fn ($game) => ($game instanceof BoardGame) && ($game->type == BoardGameType::BaseGame->value))->count();
        } else {
            $publishers = Publisher::withCount('publishBoardGames')->having('publish_board_games_count', '>', 0)->get();
            $countGamesWithoutPublishers = $this->games->whereNull('publisher_id');
            $allGames = $this->gameCount;
        }

        $data = [];

        // Obliczanie procentów i tworzenie tablicy danych
        if ($allGames > 0) {
            $gamesWithoutPublishers = 'Without publisher';
            $data[$gamesWithoutPublishers]['games_count'] = $countGamesWithoutPublishers->count();
            $data[$gamesWithoutPublishers]['percent'] = number_format(($countGamesWithoutPublishers->count() / $allGames) * 100, 2, ',') . '%';
            $data[$gamesWithoutPublishers]['model'] = null;

            foreach ($publishers as $publisher) {
                $data[$publisher->name]['games_count'] = $publisher->publish_board_games_count;
                $data[$publisher->name]['percent'] = number_format(($publisher->publish_board_games_count / $allGames) * 100, 2, ',') . '%';
                $data[$publisher->name]['model'] = $publisher;
            }
        }

        // Sortowanie danych po procentach
        uasort($data, function ($a, $b) {
            $percentA = str_replace([',', '%'], ['.', ''], $a['percent']);
            $percentB = str_replace([',', '%'], ['.', ''], $b['percent']);

            return floatval($percentB) <=> floatval($percentA);
        });

        return collect($data);
    }

    public function numberGamesForNumberPlayers(): Collection
    {
        $playersRange = DB::select('SELECT MIN(min_players) AS min_players_min, MAX(max_players) AS max_players_max FROM board_games')[0];

        $gamesCount = DB::select('
            SELECT COUNT(id) as games_count, min_players, max_players
            FROM board_games
            WHERE min_players BETWEEN ? AND ?
            OR max_players BETWEEN ? AND ?
            GROUP BY min_players, max_players
        ', [$playersRange->min_players_min, $playersRange->max_players_max, $playersRange->min_players_min, $playersRange->max_players_max]);

        $counts = array_fill($playersRange->min_players_min, $playersRange->max_players_max - $playersRange->min_players_min + 1, 0);

        foreach ($gamesCount as $count) {
            for ($i = $count->min_players; $i <= $count->max_players; $i++) {
                $counts[$i] += $count->games_count;
            }
        }

        return collect($counts);
    }

    public function topTenGames(): Collection
    {
        return Gameplay::with('boardGame')
            ->select('board_game_id', DB::raw('sum(count) as sum_count'))
            ->groupBy('board_game_id')
            ->orderByDesc('sum_count')
            ->limit(10)
            ->get();
    }

    public function playToNoPlay(): Collection
    {
        $allBoardGames = $this->games->where('type', BoardGameType::BaseGame->value)->count();
        $playedBoardGame = $this->gameplays->groupBy('board_game_id')->count();

        return collect([
            'played' => $playedBoardGame,
            'noPlayed' => $allBoardGames - $playedBoardGame,
        ]);
    }
}
