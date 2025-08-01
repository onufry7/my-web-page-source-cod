<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class AccentColor
{
    public function __invoke(): string
    {
        $colorAccent = 'accent';
        $controllerWitchAccent = ['project', 'cipher', 'board-game', 'sleeve', 'technology', 'publisher', 'access-token', 'user'];
        $routName = Route::currentRouteName();
        $controllerName = '';

        if ($routName) {
            list($controller) = explode('.', $routName);
            $controllerName = mb_strtolower($controller);
        }

        if (in_array($controllerName, $controllerWitchAccent)) {
            $colorAccent = 'accent-' . $controllerName;
        }

        return $colorAccent;
    }

    public function __toString(): string
    {
        return $this();
    }
}
