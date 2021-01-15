<?php

use App\Helpers\DataBaseSelector;
use App\Http\Controllers\ApiPhaser;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GameobjectsController;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\NamespacesController;
use App\Http\Controllers\PhysicsController;
use App\Http\Controllers\ScenesController;
use App\Http\Middleware\PhaserVersionCheckMiddleware;
use App\Http\Middleware\SelectRouter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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


Route::get('/', function() {
    return redirect("/".DataBaseSelector::getLastDB()."/");
});

Route::Group(['middleware' => PhaserVersionCheckMiddleware::class], function () {
    Route::get('/{version}/', function($version) {
        return view('landing');
    });

    Route::get('/{version}/namespaces', [NamespacesController::class, 'index']);
    Route::get('/{version}/namespace/{namespace}', [NamespacesController::class, 'show']);

    Route::get('/{version}/classes', [ClassesController::class, 'index']);
    // Route::get('/{version}/class/{longname}', [ClassesController::class, 'show']);

    Route::get('/{version}/gameobjects', [GameobjectsController::class, 'index']);
    Route::get('/{version}/physics', [PhysicsController::class, 'index']);
    Route::get('/{version}/scenes', [ScenesController::class, 'index']);

    Route::get('/{version}/events', [EventsController::class, 'index']);
    // Route::get('/{version}/class/{longname}', [ClassesController::class, 'show']);

    Route::get('/{version}/{api_word}', [ApiPhaser::class, 'show']);
});


