<?php

namespace Tests;

use App\Enums\UserRole;
use App\Models\User;

class AuthenticatedTestCase extends TestCase
{
    protected User $user;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => UserRole::User->value]);
        $this->admin = User::factory()->create(['role' => UserRole::Admin->value]);
    }
}
