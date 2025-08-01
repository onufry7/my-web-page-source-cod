<?php

use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Admin\StatisticController as AdminStatisticController;
use App\Http\Controllers\Admin\UserManager;
use App\Http\Controllers\AphorismController;
use App\Http\Controllers\BoardGameController;
use App\Http\Controllers\BoardGameSleeveController;
use App\Http\Controllers\CipherController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Fortify\CustomConfirmablePasswordController;
use App\Http\Controllers\GameplayController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SingleActions\ContactFormSend;
use App\Http\Controllers\SingleActions\CVDownload;
use App\Http\Controllers\SingleActions\CVUpload;
use App\Http\Controllers\SingleActions\Dashboard;
use App\Http\Controllers\SingleActions\ShelfOfShame;
use App\Http\Controllers\SleeveController;
use App\Http\Controllers\TechnologyController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\RoutePath;

// Other pages

Route::view('/', 'home')->name('home');
Route::view('o-mnie', 'about.show')->name('about');
Route::post('kontakt', ContactFormSend::class)->name('contact.submit');
Route::get('cv/pobierz', CVDownload::class)->name('cv.download');
Route::get('{file:id}/pobierz', [FileController::class, 'download'])->prefix('pliki')->name('file.download');

// Board game routs
Route::get('{boardGame}/pliki', [BoardGameController::class, 'files'])->prefix('planszowki')
    ->middleware('can:isAdmin')->name('board-game.files');
Route::get('{boardGame}/pliki/nowy', [BoardGameController::class, 'addFile'])->prefix('planszowki')
    ->middleware('can:isAdmin')->name('board-game.add-file');
Route::get('{boardGame}/instrukcja', [BoardGameController::class, 'downloadInstruction'])
    ->prefix('planszowki')->name('board-game.download-instruction');
Route::get('lista/{type}/{countPlayers?}', [BoardGameController::class, 'generateSpecificBoardGameList'])
    ->where(['type' => '[a-z\-]+', 'countPlayers' => '[0-9]*'])->prefix('planszowki')->name('board-game.specific-list');
Route::resource('planszowki', BoardGameController::class, [
    'names' => 'board-game',
    'parameters' => ['planszowki' => 'boardGame'],
    'except' => ['index', 'show'],
])->middleware('can:isAdmin');
Route::controller(BoardGameController::class)->prefix('planszowki')->group(function () {
    Route::get('/{type?}', 'index')->where(['type' => 'wszystkie|dodatki'])->name('board-game.index');
    Route::get('/{boardGame:slug}', 'show')->name('board-game.show');
});

// Cipher routs
Route::view('wstep', 'cipher.entry')->prefix('szyfry')->name('cipher.entry');
Route::get('alfabetyczny-spis-szyfrow', [CipherController::class, 'catalog'])->prefix('szyfry')->name('cipher.catalog');
Route::resource('szyfry', CipherController::class, [
    'names' => 'cipher',
    'parameters' => ['szyfry' => 'cipher'],
    'except' => ['index', 'show'],
])->middleware('can:isAdmin');
Route::resource('szyfry', CipherController::class, [
    'names' => 'cipher',
    'parameters' => ['szyfry' => 'cipher'],
    'only' => ['index', 'show'],
]);

// Project routs
Route::resource('projekty', ProjectController::class, [
    'names' => 'project',
    'parameters' => ['projekty' => 'project'],
    'except' => ['index', 'show'],
])->middleware('can:isAdmin');
Route::resource('projekty', ProjectController::class, [
    'names' => 'project',
    'parameters' => ['projekty' => 'project'],
    'only' => ['index', 'show'],
]);

// For logged users
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('dashboard/polka-wstydu', ShelfOfShame::class)->name('shelf.shame');
    Route::resource('dashboard/rozgrywki', GameplayController::class, [
        'names' => 'gameplay',
        'parameters' => ['rozgrywki' => 'gameplay'],
    ]);

    // For admin
    Route::middleware(['can:isAdmin'])->group(function () {
        Route::view('cv-upload', 'about.cv-upload')->name('cv.form');
        Route::post('cv-upload', CVUpload::class)->name('cv.upload');
        Route::view('admin', 'admin.dashboard')->name('admin.dashboard');
        Route::resource('admin/uzytkownicy', UserManager::class, [
            'names' => 'user',
            'parameters' => ['uzytkownicy' => 'user'],
            'only' => ['index', 'show', 'destroy'],
        ]);
        Route::get('admin/statystyki', [AdminStatisticController::class, 'index'])->name('admin.statistics.index');
        Route::resource('admin/technologie', TechnologyController::class, [
            'names' => 'technology',
            'parameters' => ['technologie' => 'technology'],
        ]);
        Route::resource('admin/wydawcy', PublisherController::class, [
            'names' => 'publisher',
            'parameters' => ['wydawcy' => 'publisher'],
        ]);
        Route::resource('admin/koszulki', SleeveController::class, [
            'names' => 'sleeve',
            'parameters' => ['koszulki' => 'sleeve'],
        ]);
        Route::get('admin/koszulki-magazyn/{sleeve}', [SleeveController::class, 'stock'])->name('sleeve.stock');
        Route::patch('admin/koszulki-magazyn/{sleeve}', [SleeveController::class, 'stockUpdate'])->name('sleeve.stock-update');

        // Board Game Sleeves
        Route::get('{boardGame}/koszulki', [BoardGameSleeveController::class, 'index'])->prefix('planszowki')->name('board-game-sleeve.index');
        Route::get('{boardGame}/koszulki/dodawanie', [BoardGameSleeveController::class, 'create'])->prefix('planszowki')->name('board-game-sleeve.create');
        Route::post('{boardGame}/koszulki', [BoardGameSleeveController::class, 'store'])->prefix('planszowki')->name('board-game-sleeve.store');
        Route::get('{boardGame}/koszulki/{boardGameSleeve}/zakladanie', [BoardGameSleeveController::class, 'putTheSleeves'])->prefix('planszowki')->name('board-game-sleeve.put');
        Route::get('{boardGame}/koszulki/{boardGameSleeve}/zdejmowanie', [BoardGameSleeveController::class, 'turnOffTheSleeves'])->prefix('planszowki')->name('board-game-sleeve.turn-off');
        Route::delete('{boardGame}/koszulki/{boardGameSleeveId}', [BoardGameSleeveController::class, 'destroy'])->prefix('planszowki')->name('board-game-sleeve.destroy');

        Route::resource('admin/pliki', FileController::class, [
            'names' => 'file',
            'parameters' => ['pliki' => 'file'],
            'except' => ['create'],
        ]);

        Route::resource('admin/aforyzmy', AphorismController::class, [
            'names' => 'aphorism',
            'parameters' => ['aforyzmy' => 'aphorism'],
        ]);

        Route::resource('admin/access-token', AccessTokenController::class, [
            'parameters' => ['access-token' => 'accessToken'],
        ]);
        Route::get('admin/wydruki', [PrintController::class, 'index'])->name('print.index');
        Route::get('admin/wydruki/{id}', [PrintController::class, 'printBoardGamePdf'])->name('print.board-game-pdf');
        Route::get('admin/uzytkownicy/{user}/role', [UserManager::class, 'switchRole'])->name('user.switch-role')->middleware('password.confirm:password.confirm,30');
    });
});

// Register routs
Route::middleware(['guest:' . (is_string(config('fortify.guard')) ? config('fortify.guard') : ''), 'access.token'])->group(function () {
    Route::get(RoutePath::for('register', '/rejestracja'), [RegisteredUserController::class, 'create'])->name('register');
    Route::post(RoutePath::for('register', '/rejestracja'), [RegisteredUserController::class, 'store'])->name('register.store');
});

// confirm-pasword
Route::get('/user/confirm-password', [CustomConfirmablePasswordController::class, 'show'])
    ->middleware(['auth', 'web'])
    ->name('password.confirm');

Route::post('/user/confirm-password', [CustomConfirmablePasswordController::class, 'store'])
    ->middleware(['auth', 'web'])
    ->name('password.confirm.store');

Route::get('/user/confirm-password/back', [CustomConfirmablePasswordController::class, 'back'])
    ->middleware(['auth', 'web'])
    ->name('password.confirm.back');
