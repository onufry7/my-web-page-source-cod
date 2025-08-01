<?php

namespace Tests\Feature\Aphorism;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class AphorismTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'aphorism.index';
    protected string $routeCreate = 'aphorism.create';
    protected string $routeStore = 'aphorism.store';
    protected string $routeShow = 'aphorism.show';
    protected string $routeEdit = 'aphorism.edit';
    protected string $routeUpdate = 'aphorism.update';
    protected string $routeDestroy = 'aphorism.destroy';
}
