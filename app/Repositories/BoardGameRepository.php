<?php

namespace App\Repositories;

use App\Enums\BoardGameType;
use App\Filters\BoardGameFilter;
use App\Http\Requests\BoardGameRequest;
use App\Models\BoardGame;
use App\Services\BoardGameService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BoardGameRepository
{
    private BoardGameService $service;

    private const DEFAULT_PAGINATED = 24;

    public function __construct(BoardGameService $boardGameService)
    {
        $this->service = $boardGameService;
    }

    public function gamesForDynamicList(string $type, ?string $countPlayers = '0'): Collection|LengthAwarePaginator
    {
        $perPage = 50;

        return match (mb_strtolower($type)) {
            'podstawowe-bez-wydawcy' => BoardGame::whereNull('publisher_id')
                ->where('type', BoardGameType::BaseGame->value)
                ->orderBy('name')->paginate($perPage),

            'bez-wydawcy' => BoardGame::whereNull('publisher_id')
                ->orderBy('name')->paginate($perPage),

            'bez-instrukcji' => BoardGame::where('need_instruction', true)->whereNull('instruction')
                ->orderBy('name')->paginate($perPage),

            'zagrane' => BoardGame::where('type', BoardGameType::BaseGame->value)
                ->has('gameplays')->orderBy('name')->paginate($perPage),

            'niezagrane' => BoardGame::where('type', BoardGameType::BaseGame->value)
                ->doesntHave('gameplays')->orderBy('name')->paginate($perPage),

            'liczba-graczy' => BoardGame::where('min_players', '<=', $countPlayers)
                ->where('max_players', '>=', $countPlayers)
                ->orderBy('name')->paginate($perPage),

            'bez-insertu' => BoardGame::where('need_insert', true)
                ->orderBy('name')->paginate($perPage),

            'do-koszulkowania' => BoardGame::whereHas('boardGameSleeves', function ($query) {
                $query->where('sleeved', 0);
            })->paginate($perPage),

            'do-malowania' => BoardGame::where('to_painting', true)
                ->orderBy('name')->paginate($perPage),

            default => new Collection(),
        };
    }

    public function games(array $selectFields = ['*']): Collection
    {
        return BoardGame::select(...$selectFields)->orderBy('name', 'ASC')->get();
    }

    public function gamesPaginated(BoardGameFilter $filters, int $perPage = self::DEFAULT_PAGINATED): LengthAwarePaginator
    {
        return BoardGame::filter($filters)->orderBy('name', 'ASC')->paginate($perPage);
    }

    public function baseGames(array $selectFields = ['*']): Collection
    {
        return BoardGame::select(...$selectFields)->orderBy('name', 'ASC')
            ->where('type', BoardGameType::BaseGame->value)
            ->get();
    }

    public function baseGamesPaginated(BoardGameFilter $filters, int $perPage = self::DEFAULT_PAGINATED): LengthAwarePaginator
    {
        return BoardGame::filter($filters)->orderBy('name', 'ASC')
            ->where('type', BoardGameType::BaseGame->value)
            ->paginate($perPage);
    }

    public function expansions(array $selectFields = ['*']): Collection
    {
        return BoardGame::select(...$selectFields)->orderBy('name', 'ASC')
            ->where('type', '<>', BoardGameType::BaseGame->value)
            ->get();
    }

    public function expansionsPaginated(BoardGameFilter $filters, int $perPage = self::DEFAULT_PAGINATED): LengthAwarePaginator
    {
        return BoardGame::filter($filters)->orderBy('name', 'ASC')
            ->where('type', '<>', BoardGameType::BaseGame->value)
            ->paginate($perPage);
    }

    public function selectGames(Request $request, array $fields = ['*']): Collection
    {
        $type = is_string($request->input('type')) ? $request->input('type') : 'default';

        return match (mb_strtolower($type)) {
            'all' => $this->games($fields),
            'expansion' => $this->expansions($fields),
            default => $this->baseGames($fields),
        };
    }

    public function selectGamesPaginated(BoardGameFilter $filters, ?string $type = null, int $perPage = self::DEFAULT_PAGINATED): LengthAwarePaginator
    {
        $type = is_string($type) ? mb_strtolower($type) : 'podstawki';

        return match ($type) {
            'wszystkie' => $this->gamesPaginated($filters, $perPage),
            'dodatki' => $this->expansionsPaginated($filters, $perPage),
            default => $this->baseGamesPaginated($filters, $perPage),
        };
    }

    public function store(BoardGameRequest $request): BoardGame|false
    {
        $boardGame = new BoardGame($request->validated());
        $boxImage = $request->file('box_image');
        $instruction = $request->file('instruction_file');

        if ($request->hasFile('box_image') && !is_null($boxImage) && !is_array($boxImage)) {
            $boardGame->box_img = $this->service->storeBoxImage($boxImage);
        }

        if ($request->hasFile('instruction_file') && !is_null($instruction) && !is_array($instruction)) {
            $boardGame->instruction = $this->service->storeInstruction($instruction);
        }

        return ($boardGame->push()) ? $boardGame : false;
    }

    public function update(BoardGameRequest $request, BoardGame $boardGame): bool
    {
        $boxImage = $request->file('box_image');
        $instruction = $request->file('instruction_file');

        if ($request->hasAny(['delete_box_img', 'box_image']) && !is_null($boardGame->box_img)) {
            $this->service->deleteBoxImage($boardGame->box_img);
            $boardGame->box_img = null;
        }

        if ($request->hasAny(['delete_instruction', 'instruction_file']) && !is_null($boardGame->instruction)) {
            $this->service->deleteInstruction($boardGame->instruction);
            $boardGame->instruction = null;
        }

        if ($request->hasFile('box_image') && !is_null($boxImage) && !is_array($boxImage)) {
            $boardGame->box_img = $this->service->storeBoxImage($boxImage);
        }

        if ($request->hasFile('instruction_file') && !is_null($instruction) && !is_array($instruction)) {
            $boardGame->instruction = $this->service->storeInstruction($instruction);
        }

        return $boardGame->update($request->validated());
    }

    public function delete(BoardGame $boardGame): bool
    {
        if (!is_null($boardGame->box_img)) {
            $this->service->deleteBoxImage($boardGame->box_img);
        }

        if (!is_null($boardGame->instruction)) {
            $this->service->deleteInstruction($boardGame->instruction);
        }

        if ($boardGame->files->count() > 0) {
            $this->service->deleteFolder((string) $boardGame->id);
        }

        $boardGame->files()->delete();

        return ($boardGame->delete()) ? true : false;
    }
}
