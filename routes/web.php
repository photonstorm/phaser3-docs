<?php

use App\Http\Controllers\ClassesController;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\NamespacesController;

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

Route::get('/namespaces', [NamespacesController::class, 'show']);
Route::get('/namespace/{namespace}', [NamespacesController::class, 'showNamespace']);

Route::get('/classes', [ClassesController::class, 'show']);
Route::get('/class/{longname}', [ClassesController::class, 'showClass']);
// Route::get('/class/{class}');
