<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/folders/{id}/tasks', 'App\Http\Controllers\TaskController@index')->name('tasks.index');
Route::get('/fortune', [App\Http\Controllers\FortuneController::class, 'index']);
Route::get('/generate', [App\Http\Controllers\ImageController::class, 'generate']);
Route::post('/generate', [App\Http\Controllers\ImageController::class, 'generate']);