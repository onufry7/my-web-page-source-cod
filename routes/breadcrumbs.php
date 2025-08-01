<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('Home'), route('home'), ['icon' => 'home']);
});

Breadcrumbs::for('profile.show', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Profil'), route('profile.show'));
});

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Panel'), route('dashboard'));
});

Breadcrumbs::for('about', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('About me'), route('about'));
});

Breadcrumbs::for('cv.form', function (BreadcrumbTrail $trail) {
    $trail->parent('about');
    $trail->push(__('CV update'), route('cv.form'));
});

Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Admin Panel'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.statistics.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('Statistics'), route('admin.statistics.index'));
});

Breadcrumbs::for('sleeve.stock', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('sleeve.show', $model);
    $trail->push(__('Stock'), route('sleeve.stock', $model));
});

Breadcrumbs::for('board-game-sleeve.index', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('board-game.show', $model);
    $trail->push(__('Sleeves'), route('board-game-sleeve.index', $model));
});

Breadcrumbs::for('board-game-sleeve.create', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('board-game-sleeve.index', $model);
    $trail->push(__('Add sleeves'), route('board-game-sleeve.create', $model));
});

Breadcrumbs::for('print.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('Prints'), route('print.index'));
});

Breadcrumbs::for('shelf.shame', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('Shelf of shame'), route('shelf.shame'));
});

Breadcrumbs::for('cipher.catalog', function (BreadcrumbTrail $trail) {
    $trail->parent('cipher.index');
    $trail->push(__('Alphabetical list of ciphers'), route('cipher.catalog'));
});

Breadcrumbs::macro('resource', function (string $name, string $title) {
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('home');
        $trail->push(ucfirst($title), route("{$name}.index"));
    });

    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(__('Addition'), route("{$name}.create"));
    });

    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(ucfirst($model->name), route("{$name}.show", $model));
    });

    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.show", $model);
        $trail->push(__('Editing'), route("{$name}.edit", $model));
    });

    Breadcrumbs::for("{$name}.entry", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(__('Entry'), route("{$name}.entry"));
    });

    Breadcrumbs::for("{$name}.add-file", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.files", $model);
        $trail->push(__('Addition'), route("{$name}.add-file", $model));
    });

    Breadcrumbs::for("{$name}.files", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.show", $model);
        $trail->push(__('Files'), route("{$name}.files", $model));
    });
});
Breadcrumbs::resource('project', __('Projects'));
Breadcrumbs::resource('cipher', __('Ciphers'));
Breadcrumbs::resource('board-game', __('Board games'));

Breadcrumbs::macro('adminResource', function (string $name, string $title) {
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('admin.dashboard');
        $trail->push(ucfirst($title), route("{$name}.index"));
    });

    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(__('Addition'), route("{$name}.create"));
    });

    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(ucfirst($model->name ?? $model->token), route("{$name}.show", $model));
    });

    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.show", $model);
        $trail->push(__('Editing'), route("{$name}.edit", $model));
    });
});
Breadcrumbs::adminResource('aphorism', __('Aphorisms'));
Breadcrumbs::adminResource('technology', __('Technologies'));
Breadcrumbs::adminResource('publisher', __('Publishers'));
Breadcrumbs::adminResource('access-token', __('Access tokens'));
Breadcrumbs::adminResource('sleeve', __('Sleeves'));

Breadcrumbs::macro('indexShowEdit', function (string $name, string $title) {
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('admin.dashboard');
        $trail->push(ucfirst($title), route("{$name}.index"));
    });

    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(ucfirst($model->name), route("{$name}.show", $model));
    });

    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.show", $model);
        $trail->push(__('Editing'), route("{$name}.edit", $model));
    });
});
Breadcrumbs::indexShowEdit('file', __('Pliki'));
Breadcrumbs::indexShowEdit('user', __('Użytkownicy'));

Breadcrumbs::macro('userResource', function (string $name, string $title) {
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('dashboard');
        $trail->push(ucfirst($title), route("{$name}.index"));
    });

    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(__('Addition'), route("{$name}.create"));
    });

    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push(ucfirst($model->name), route("{$name}.show", $model));
    });

    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, $model) use ($name) {
        $trail->parent("{$name}.show", $model);
        $trail->push(__('Editing'), route("{$name}.edit", $model));
    });
});
Breadcrumbs::userResource('gameplay', __('Gameplays'));

Breadcrumbs::for('board-game.specific-list', function (BreadcrumbTrail $trail, string $type, ?int $countPlayers) {
    $type = ucfirst(str_replace('-', ' ', $type));
    $title = (is_null($countPlayers)) ? $type : $type . ': ' . $countPlayers;
    $trail->parent('board-game.index');
    $trail->push($title, route('board-game.specific-list', ['type' => $type]));
});
