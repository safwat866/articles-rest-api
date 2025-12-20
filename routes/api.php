<?php

use App\Http\Controllers\API\V1\ArticleController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Auth Routes
Route::prefix('v1')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::apiResource('/users', UserController::class)->except(['store', 'update', 'destroy']);
        Route::apiResource('/articles', ArticleController::class);

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});
