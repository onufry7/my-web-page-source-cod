<?php

namespace App\Services;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use App\Models\BoardGameSleeve;
use App\Models\Sleeve;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PrintService
{
    public function generateBoardGameListPDF(): RedirectResponse|Response
    {
        $games = BoardGame::where('type', BoardGameType::BaseGame->value)
            ->orderBy('name')->get();

        if ($games->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.board-games-list', compact('games'));

        return $pdf->download('lista-gier.pdf');
    }

    public function generateBoardGameListWithExpansionPDF(): RedirectResponse|Response
    {
        $games = BoardGame::orderBy('type')->orderBy('name')->get();

        if ($games->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.board-games-list-with-expansion', compact('games'));

        return $pdf->download('lista-gier-z-dodatkami.pdf');
    }

    public function generateBoardGameListWithSleevesPDF(): RedirectResponse|Response
    {
        $games = BoardGame::orderBy('name')->orderBy('type')->has('Sleeves')->with('Sleeves')->get();

        if ($games->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.board-games-list-with-sleeves', compact('games'));

        return $pdf->download('lista-gier-z-koszulkami.pdf');
    }

    public function generateSleeveListPDF(): RedirectResponse|Response
    {
        $sleeves = Sleeve::orderBy('mark')->orderBy('width')->orderBy('height')->orderBy('name')->get();

        if ($sleeves->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.sleeve-list', compact('sleeves'));

        return $pdf->download('lista-koszulek.pdf');
    }

    public function generateSleeveListUsedInGamesPDF(): RedirectResponse|Response
    {
        $boardGameSleeves = BoardGameSleeve::with('sleeve')
            ->selectRaw('sleeve_id, sum(quantity) as quantity')
            ->groupBy('sleeve_id')
            ->join('sleeves', 'sleeves.id', '=', 'board_game_sleeve.sleeve_id')
            ->orderBy('sleeves.mark')
            ->orderBy('sleeves.name')
            ->orderBy('sleeves.width')
            ->orderBy('sleeves.height')
            ->get();

        if ($boardGameSleeves->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.sleeve-list-used-in-games', compact('boardGameSleeves'));

        return $pdf->download('lista-koszulek-w-grach.pdf');
    }

    public function generateBoardGameListWithAddDatePDF(): RedirectResponse|Response
    {
        $games = BoardGame::orderBy('created_at')->get();

        if ($games->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.board-games-with-add-dates', compact('games'));

        return $pdf->download('lista-gier-wedlug-daty-dodania.pdf');
    }

    public function generateMissingSleevesListPDF(): RedirectResponse|Response
    {
        $missingSleeves = BoardGameSleeve::query()
            ->join('sleeves', 'sleeves.id', '=', 'board_game_sleeve.sleeve_id')
            ->where('board_game_sleeve.sleeved', 0)
            ->selectRaw('
                board_game_sleeve.sleeve_id,
                CONCAT(sleeves.mark, " - ", sleeves.name) as name,
                GREATEST(SUM(board_game_sleeve.quantity) - COALESCE(sleeves.quantity_available, 0), 0) as missing_quantity
            ')
            ->groupBy(
                'board_game_sleeve.sleeve_id',
                'sleeves.mark',
                'sleeves.name',
                'sleeves.quantity_available'
            )
            ->having('missing_quantity', '>', 0)
            ->orderBy('sleeves.mark')
            ->orderBy('sleeves.name')
            ->orderBy('sleeves.width')
            ->orderBy('sleeves.height')
            ->get();

        if ($missingSleeves->isEmpty()) {
            return $this->handleEmptyBoardGameList();
        }

        $pdf = Pdf::loadView('print.pdf.missing-sleeves', compact('missingSleeves'));

        return $pdf->download('lista-brakujacych-koszulek.pdf');
    }

    private function handleEmptyBoardGameList(): RedirectResponse
    {
        return back()->warningBanner(__('No data to print.'));
    }
}
