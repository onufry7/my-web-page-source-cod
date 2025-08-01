<?php

namespace App\Services\Statistics;

use App\Interfaces\GeneralStatistic as GeneralStatisticInterface;
use App\Interfaces\StatisticService as StatisticServiceInterface;
use App\Models\BoardGame;
use App\Models\Cipher;
use App\Models\File;
use App\Models\Project;
use App\Models\Publisher;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Support\Collection;

class StatisticService implements GeneralStatisticInterface, StatisticServiceInterface
{
    public function dominant(array $elementsList): ?array
    {
        return collect($elementsList)->mode();
    }

    public function arithmeticAverage(array $elementsList): null|float|int
    {
        return collect($elementsList)->avg();
    }

    public function countOfIndividualModels(): Collection
    {
        return collect([
            'boardGame' => [
                'name' => 'Board games',
                'count' => BoardGame::count('id'),
            ],
            'cipher' => [
                'name' => 'Ciphers',
                'count' => Cipher::count('id'),
            ],
            'project' => [
                'name' => 'Projects',
                'count' => Project::count('id'),
            ],
            'technology' => [
                'name' => 'Technologies',
                'count' => Technology::count('id'),
            ],
            'publisher' => [
                'name' => 'Publishers',
                'count' => Publisher::count('id'),
            ],
            'user' => [
                'name' => 'Users',
                'count' => User::count('id'),
            ],
            'file' => [
                'name' => 'Files',
                'count' => File::count('id'),
            ],
        ]);
    }
}
