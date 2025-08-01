<?php

namespace App\Data;

use Illuminate\Support\Collection;

class PrintList
{
    public static function all(): Collection
    {
        return collect([
            [
                'id' => 'lista-gier',
                'title' => 'List of board games',
                'method' => 'generateBoardGameListPDF',
            ],
            [
                'id' => 'lista-gier-z-dodatkami',
                'title' => 'List of board games with expansions',
                'method' => 'generateBoardGameListWithExpansionPDF',
            ],
            [
                'id' => 'lista-gier-z-koszulkami',
                'title' => 'List of board games with sleeves',
                'method' => 'generateBoardGameListWithSleevesPDF',
            ],
            [
                'id' => 'lista-koszulek',
                'title' => 'List of sleeves',
                'method' => 'generateSleeveListPDF',
            ],
            [
                'id' => 'lista-koszulek-w-grach',
                'title' => 'List of sleeves used in board games',
                'method' => 'generateSleeveListUsedInGamesPDF',
            ],
            [
                'id' => 'lista-gier-z-datami-dodania',
                'title' => 'List of board games with add dates',
                'method' => 'generateBoardGameListWithAddDatePDF',
            ],
            [
                'id' => 'lista-brakujacych-koszulek',
                'title' => 'List of missing card sleeves',
                'method' => 'generateMissingSleevesListPDF',
            ],
        ]);
    }

    public static function find(string $id): ?array
    {
        $result = self::all()->firstWhere('id', $id);

        return is_array($result) ? $result : null;
    }
}
