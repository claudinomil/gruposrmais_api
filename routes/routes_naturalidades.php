<?php

use App\Http\Controllers\NaturalidadeController;

Route::prefix('naturalidades')->group(function () {
    Route::get('/index/{empresa_id}', [NaturalidadeController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [NaturalidadeController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [NaturalidadeController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [NaturalidadeController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [NaturalidadeController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [NaturalidadeController::class, 'destroy'])->middleware(['auth:api']);
});
