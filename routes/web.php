<?php

use App\Http\Controllers\ApiPhaser;
use App\Http\Controllers\ClassesController;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\NamespacesController;
use App\Http\Middleware\SelectRouter;

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
    return view('welcome');
});

Route::get('/namespaces', [NamespacesController::class, 'index']);
Route::get('/namespace/{namespace}', [NamespacesController::class, 'show']);

Route::get('/classes', [ClassesController::class, 'index']);
Route::get('/class/{longname}', [ClassesController::class, 'show']);

Route::get('/{version}/{api_word}', [ApiPhaser::class, 'show'])->middleware(SelectRouter::class);
