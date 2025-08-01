<?php

namespace Tests\Feature\File;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class FileTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'file.index';
    protected string $routeStore = 'file.store';
    protected string $routeShow = 'file.show';
    protected string $routeEdit = 'file.edit';
    protected string $routeUpdate = 'file.update';
    protected string $routeDestroy = 'file.destroy';
    protected string $routeDownload = 'file.download';
}
