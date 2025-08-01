<?php

namespace App\Repositories;

use App\Exceptions\StockSleeveException;
use App\Http\Requests\BoardGameSleeveRequest;
use App\Models\BoardGameSleeve;
use App\Models\Sleeve;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class BoardGameSleeveRepository
{
    public function getSleevesForSelectInput(): Collection
    {
        return Sleeve::all()->map(function ($sleeve) {
            return new Fluent([
                'id' => $sleeve->id,
                'label' => $sleeve->getFullName() . ' (' . $sleeve->getSize() . ')',
            ]);
        });
    }

    public function store(BoardGameSleeveRequest $request): bool
    {
        $boardGameSleeve = new BoardGameSleeve($request->validated());

        return $boardGameSleeve->save();
    }

    public function delete(int $boardGameSleeveId): bool
    {
        $boardGameSleeve = BoardGameSleeve::find($boardGameSleeveId);

        if (!$boardGameSleeve || $boardGameSleeve->sleeved) {
            return false;
        }

        return $boardGameSleeve->delete() ? true : false;
    }

    public function putTheSleeves(int $id): bool
    {
        $boardGameSleeve = BoardGameSleeve::find($id);
        $sleeve = Sleeve::find($boardGameSleeve?->sleeve_id);

        if (!$boardGameSleeve || !$sleeve) {
            return false;
        }

        if ($boardGameSleeve->quantity > $sleeve->quantity_available) {
            throw new StockSleeveException(__('Not enough sleeves in stock! (:countSleeves)', ['countSleeves' => $sleeve->getQuantityAvailable()]));
        }

        $boardGameSleeve->sleeved = true;
        $sleeve->quantity_available -= $boardGameSleeve->quantity;

        return $boardGameSleeve->save() && $sleeve->save();
    }

    public function turnOffTheSleeves(int $id): bool
    {
        $boardGameSleeve = BoardGameSleeve::find($id);
        $sleeve = Sleeve::find($boardGameSleeve?->sleeve_id);

        if (!$boardGameSleeve || !$sleeve) {
            return false;
        }

        $boardGameSleeve->sleeved = false;
        $sleeve->quantity_available += $boardGameSleeve->quantity;

        return $boardGameSleeve->save() && $sleeve->save();
    }
}
