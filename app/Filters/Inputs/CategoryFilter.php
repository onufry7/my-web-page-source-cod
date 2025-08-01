<?php

namespace App\Filters\Inputs;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
{
    public function __invoke(Builder $query, ?string $categorySlug): Builder
    {
        return $query->when(!is_null($categorySlug), function ($query) use ($categorySlug) {
            $query->whereRaw('category = ?', $categorySlug);
        });
    }
}
