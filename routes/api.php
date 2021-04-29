<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function (){
        Route::post('register',[UserController::class, 'register']);
    });

Route::prefix('todo')
    ->middleware(['auth:api', 'isEmailVerified'])
    ->group(function (){
        Route::apiResource('/', 'TodoController');
    });
