<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::prefix('todo')
    ->middleware(['auth:api'])
    ->group(function (){
        Route::apiResource('todo', TodoController::class);
    });
