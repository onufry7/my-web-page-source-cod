<?php

namespace App\Http\Controllers;

use App\Data\PrintList;
use App\Services\PrintService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PrintController extends Controller
{
    public function index(): View
    {
        $prints = PrintList::all()->sortBy('title');

        return view('print.index', ['prints' => $prints]);
    }

    public function printBoardGamePdf(string $id, PrintService $printService): RedirectResponse|Response
    {
        $id = strip_tags($id);

        $print = PrintList::find($id);

        if (!$print) {
            abort(404);
        }

        return $printService->{$print['method']}();
    }
}
