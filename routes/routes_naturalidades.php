<?php

use App\Http\Controllers\NaturalidadeController;

Route::prefix('naturalidades')->group(function () {
    Route::get('/index', [NaturalidadeController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [NaturalidadeController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [NaturalidadeController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [NaturalidadeController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [NaturalidadeController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [NaturalidadeController::class, 'destroy'])->middleware(['auth:api']);
});
