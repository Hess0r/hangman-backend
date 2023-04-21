<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->prefix('/auth')->group(function () {
    Route::middleware('guest')->post('/login', 'login')->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'user')->name('user');

        Route::post('/logout', 'logout')->name('logout');
    });
});

Route::controller(GameController::class)
    ->middleware('auth:sanctum')
    ->prefix('/game')
    ->name('game.')
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/', 'store')->name('create');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
