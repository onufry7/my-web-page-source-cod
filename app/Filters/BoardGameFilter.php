<?php

namespace App\Filters;

use App\Filters\Inputs\MaxPlayersFilter;
use App\Filters\Inputs\MinPlayersFilter;
use App\Filters\Inputs\NameFilter;

class BoardGameFilter extends Filter
{
    protected array $filters = [
        'nazwa' => NameFilter::class,
        'min-graczy' => MinPlayersFilter::class,
        'max-graczy' => MaxPlayersFilter::class,
    ];
}
