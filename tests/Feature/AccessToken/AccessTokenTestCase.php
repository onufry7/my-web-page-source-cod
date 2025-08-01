<?php

namespace Tests\Feature\AccessToken;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class AccessTokenTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'access-token.index';
    protected string $routeCreate = 'access-token.create';
    protected string $routeStore = 'access-token.store';
    protected string $routeShow = 'access-token.show';
    protected string $routeEdit = 'access-token.edit';
    protected string $routeUpdate = 'access-token.update';
    protected string $routeDestroy = 'access-token.destroy';
}
