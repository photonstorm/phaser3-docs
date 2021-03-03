<?php

use App\Helpers\DataBaseSelector;
use App\Http\Controllers\ApiPhaser;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FocusController;
use App\Http\Controllers\GameobjectsController;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\NamespacesController;
use App\Http\Controllers\PhysicsController;
use App\Http\Controllers\ScenesController;
use App\Http\Middleware\PhaserVersionCheckMiddleware;
// use App\Http\Middleware\SelectRouter;
// use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("/docs/" . DataBaseSelector::getLastDB() . "/");
});

Route::prefix('/docs/')->group(function () {
    Route::Group(['middleware' => PhaserVersionCheckMiddleware::class], function () {
        Route::get('/{version}/', function ($version) {
            return view('landing');
        });

        Route::get('{version}/namespaces', [NamespacesController::class, 'index'])->name('docs.namespaces');
        Route::get('{version}/namespace/{namespace}', [NamespacesController::class, 'show'])->name('docs.namespace');

        Route::get('{version}/classes', [ClassesController::class, 'index'])->name('docs.classes');

        Route::get('{version}/gameobjects', [GameobjectsController::class, 'index'])->name('docs.gameobjects');
        Route::get('{version}/physics', [PhysicsController::class, 'index'])->name('docs.physics');
        Route::get('{version}/scenes', [ScenesController::class, 'index'])->name('docs.scenes');

        Route::get('{version}/events', [EventsController::class, 'index'])->name('docs.events');

        Route::get('{version}/{api_word}', [ApiPhaser::class, 'show']);

        Route::get('{version}/focus/{api_word}', [FocusController::class, 'index'])->name('docs.focus');
    });
});
