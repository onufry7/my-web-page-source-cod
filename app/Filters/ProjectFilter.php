<?php

namespace App\Filters;

use App\Filters\Inputs\CategoryFilter;
use App\Filters\Inputs\NameFilter;

class ProjectFilter extends Filter
{
    protected array $filters = [
        'kategoria' => CategoryFilter::class,
        'nazwa' => NameFilter::class,
    ];
}
