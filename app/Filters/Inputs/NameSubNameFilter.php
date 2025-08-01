<?php

namespace App\Filters\Inputs;

use Illuminate\Database\Eloquent\Builder;

class NameSubNameFilter
{
    public function __invoke(Builder $query, ?string $subName): Builder
    {
        return $query->when(!is_null($subName), function ($query) use ($subName) {
            $query->whereRaw('name like ? or sub_name like ?', ["%$subName%", "%$subName%"]);
        });
    }
}
