<?php

use Illuminate\Support\Facades\Route;

Route::prefix('todo')
    ->middleware(['auth:api'])
    ->group(function (){
        Route::apiResource('/', 'TodoController');
    });
