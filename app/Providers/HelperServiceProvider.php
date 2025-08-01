<?php

namespace App\Providers;

use App\Helpers\AccentColor;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('accentColor', new AccentColor());
        });
    }
}
