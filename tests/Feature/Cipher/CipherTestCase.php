<?php

namespace Tests\Feature\Cipher;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class CipherTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'cipher.index';
    protected string $routeCreate = 'cipher.create';
    protected string $routeStore = 'cipher.store';
    protected string $routeShow = 'cipher.show';
    protected string $routeEdit = 'cipher.edit';
    protected string $routeUpdate = 'cipher.update';
    protected string $routeDestroy = 'cipher.destroy';
    protected string $routeEntry = 'cipher.entry';
    protected string $routeCatalog = 'cipher.catalog';
}
