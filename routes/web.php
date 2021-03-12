<?php
use Illuminate\Support\Facades\Route;

use App\Helpers\DataBaseSelector;

// Controllers
use App\Http\Controllers\Docs\ApiPhaserController;
use App\Http\Controllers\Docs\EventsController;
use App\Http\Controllers\Docs\NamespacesController;
use App\Http\Controllers\Docs\ClassesController;
use App\Http\Controllers\Docs\FocusController;
use App\Http\Controllers\Docs\GameobjectsController;
use App\Http\Controllers\Docs\PhysicsController;
use App\Http\Controllers\Docs\ScenesController;
use App\Http\Middleware\Docs\DocsVersionCheckMiddleware;
use App\Http\Middleware\Docs\PhaserVersionCheckMiddleware;
use Illuminate\Support\Facades\Cache;

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

// TODO: Remove this route when the page is with Phser.io site
Route::get('/', function () {
    return redirect("/docs/" . DataBaseSelector::getLastDB() . "/");
});

Route::prefix('/docs/')->group(function () {
    Route::get('', function() {
        return redirect("/docs/" . DataBaseSelector::getLastDB() . "/");
    });

    Route::get('/admin/cleancache', function() {
        Cache::flush();
        return redirect("/docs/" . DataBaseSelector::getLastDB() . "/");
    });
    Route::Group(['middleware' => PhaserVersionCheckMiddleware::class], function () {
        Route::get('/{version}/', function ($version) {
            return view('docs.landing');
        });

        Route::get('{version}/namespaces', [NamespacesController::class, 'index'])->name('docs.namespaces');
        Route::get('{version}/namespace/{namespace}', [NamespacesController::class, 'show'])->name('docs.namespace');

        Route::get('{version}/classes', [ClassesController::class, 'index'])->name('docs.classes');

        Route::get('{version}/gameobjects', [GameobjectsController::class, 'index'])->name('docs.gameobjects');
        Route::get('{version}/physics', [PhysicsController::class, 'index'])->name('docs.physics');
        Route::get('{version}/scenes', [ScenesController::class, 'index'])->name('docs.scenes');

        Route::get('{version}/events', [EventsController::class, 'index'])->name('docs.events');

        Route::get('{version}/{api}', [ApiPhaserController::class, 'show'])->name('docs.api.phaser');

        Route::get('{version}/focus/{api}', [FocusController::class, 'index'])->name('docs.focus');
    });
});
