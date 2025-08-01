<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    protected array $filters = [];

    public function apply(Builder $query): Builder
    {
        foreach ($this->receivedFilters() as $name => $value) {
            $filterInstance = new $this->filters[$name]();

            if (is_callable($filterInstance)) {
                $query = $filterInstance($query, $value);
            }
        }

        return $query;
    }

    public function receivedFilters(): array
    {
        return request()->only(array_keys($this->filters));
    }
}
