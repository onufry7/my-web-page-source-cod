<?php

namespace App\Http\Controllers\SingleActions;

use App\Enums\BoardGameType;
use App\Http\Controllers\Controller;
use App\Models\BoardGame;
use Illuminate\Contracts\View\View;

class ShelfOfShame extends Controller
{
    public function __invoke(): View
    {
        $unplayedGames = BoardGame::whereNotIn('id', function ($query) {
            $query->select('board_game_id')
                ->from('gameplays')
                ->where('user_id', auth()->id())
                ->distinct();
        })->where('type', BoardGameType::BaseGame->value)->get();

        return view('shelf-shame', compact('unplayedGames'));
    }
}
