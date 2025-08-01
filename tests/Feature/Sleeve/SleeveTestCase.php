<?php

namespace Tests\Feature\Sleeve;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class SleeveTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'sleeve.index';
    protected string $routeCreate = 'sleeve.create';
    protected string $routeStore = 'sleeve.store';
    protected string $routeShow = 'sleeve.show';
    protected string $routeEdit = 'sleeve.edit';
    protected string $routeUpdate = 'sleeve.update';
    protected string $routeDestroy = 'sleeve.destroy';
    protected string $routeStock = 'sleeve.stock';
    protected string $routeStockUpdate = 'sleeve.stock-update';
}
