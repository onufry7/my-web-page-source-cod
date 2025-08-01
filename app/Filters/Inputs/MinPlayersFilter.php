<?php

namespace App\Filters\Inputs;

use Illuminate\Database\Eloquent\Builder;

class MinPlayersFilter
{
    public function __invoke(Builder $query, ?string $minPlayers): Builder
    {
        return $query->when(!is_null($minPlayers), function ($query) use ($minPlayers) {
            $query->whereRaw('min_players >= ?', $minPlayers);
        });
    }
}
