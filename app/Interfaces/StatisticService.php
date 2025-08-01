<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface StatisticService
{
    public function countOfIndividualModels(): Collection;
}
