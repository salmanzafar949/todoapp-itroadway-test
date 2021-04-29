<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function (){
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [UserController::class, 'login']);
        Route::post('verify-email/{user}', [UserController::class, 'verifyEmail']);
        Route::post('logout', [UserController::class, 'logout'])->middleware('auth:api');
    });

Route::prefix('todo')
    ->middleware(['auth:api', 'isEmailVerified', 'validateTodoAndUser'])
    ->group(function (){
        Route::apiResource('/', 'TodoController')
            ->parameters([
                '' => 'todo'
            ]);
    });
