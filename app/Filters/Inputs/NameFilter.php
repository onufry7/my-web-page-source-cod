<?php

namespace App\Filters\Inputs;

use Illuminate\Database\Eloquent\Builder;

class NameFilter
{
    public function __invoke(Builder $query, ?string $name): Builder
    {
        return $query->when(!is_null($name), function ($query) use ($name) {
            $query->whereRaw('name like ?', "%$name%");
        });
    }
}
