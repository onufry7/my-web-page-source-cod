<?php

namespace App\Filters\Inputs;

use Illuminate\Database\Eloquent\Builder;

class MaxPlayersFilter
{
    public function __invoke(Builder $query, ?string $maxPlayers): Builder
    {
        return $query->when(!is_null($maxPlayers), function ($query) use ($maxPlayers) {
            $query->whereRaw('max_players <= ?', $maxPlayers);
        });
    }
}
