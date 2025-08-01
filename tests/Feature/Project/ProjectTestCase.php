<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class ProjectTestCase extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'project.index';
    protected string $routeCreate = 'project.create';
    protected string $routeStore = 'project.store';
    protected string $routeShow = 'project.show';
    protected string $routeEdit = 'project.edit';
    protected string $routeUpdate = 'project.update';
    protected string $routeDestroy = 'project.destroy';
}
