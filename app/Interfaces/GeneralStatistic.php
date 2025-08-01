<?php

namespace App\Interfaces;

interface GeneralStatistic
{
    public function dominant(array $elementsList): ?array;

    public function arithmeticAverage(array $elementsList): null|float|int;
}
