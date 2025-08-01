<?php

namespace Tests\Feature\BoardGame;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class BoardGameTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'board-game.index';
    protected string $routeCreate = 'board-game.create';
    protected string $routeStore = 'board-game.store';
    protected string $routeShow = 'board-game.show';
    protected string $routeEdit = 'board-game.edit';
    protected string $routeUpdate = 'board-game.update';
    protected string $routeDestroy = 'board-game.destroy';
    protected string $routeAddFile = 'board-game.add-file';
    protected string $routeFiles = 'board-game.files';
    protected string $routeInstructionDownload = 'board-game.download-instruction';
    protected string $routeSpecificList = 'board-game.specific-list';
}
