<?php

use App\Http\Controllers\Api\AuthController;
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
