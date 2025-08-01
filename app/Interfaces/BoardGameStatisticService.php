<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface BoardGameStatisticService
{
    public function topTenGames(): Collection;

    public function basicStatistics(): Collection;

    public function publishersGamesPercentCollect(bool $onlyBase): Collection;

    public function numberGamesForNumberPlayers(): Collection;

    public function playToNoPlay(): Collection;
}
