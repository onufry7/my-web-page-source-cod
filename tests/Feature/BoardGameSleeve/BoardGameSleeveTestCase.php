<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Models\BoardGame;
use App\Models\Sleeve;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class BoardGameSleeveTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected BoardGame $boardGame;
    protected Sleeve $sleeve;
    protected string $routeCreate = 'board-game-sleeve.create';
    protected string $routeStore = 'board-game-sleeve.store';
    protected string $routePutSleeves = 'board-game-sleeve.put';
    protected string $routeTurnOffSleeves = 'board-game-sleeve.turn-off';
    protected string $routeIndex = 'board-game-sleeve.index';
    protected string $routeDestroy = 'board-game-sleeve.destroy';
}
