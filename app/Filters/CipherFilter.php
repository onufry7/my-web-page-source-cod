<?php

namespace App\Filters;

use App\Filters\Inputs\NameSubNameFilter;

class CipherFilter extends Filter
{
    protected array $filters = [
        'nazwa' => NameSubNameFilter::class,
    ];
}
