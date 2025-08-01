<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Interfaces\BoardGameStatisticService as BoardGameStatisticServiceInterface;
use App\Interfaces\StatisticService as StatisticServiceInterface;
use App\Models\User;
use App\Services\Statistics\BoardGameStatisticService;
use App\Services\Statistics\StatisticService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Register any application services.
    public function register(): void
    {
        $this->app->bind(StatisticServiceInterface::class, StatisticService::class);
        $this->app->bind(BoardGameStatisticServiceInterface::class, BoardGameStatisticService::class);
    }

    // Bootstrap any application services.
    public function boot(): void
    {
        Paginator::defaultView('components.paginations.tailwind');
        Paginator::defaultSimpleView('components.paginations.simple-tailwind');
        Route::resourceVerbs(['create' => 'dodawanie', 'edit' => 'edycja']);

        $this->definedUserRoleGate('isAdmin', UserRole::Admin->value);
        $this->definedUserRoleGate('isUser', UserRole::User->value);
    }

    private function definedUserRoleGate(string $name, string $role): void
    {
        Gate::define($name, fn (User $user) => ($user->role == $role));
    }
}
