<?php

use App\Http\Controllers\EstadoController;

Route::prefix('estados')->group(function () {
    Route::get('/index/{empresa_id}', [EstadoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EstadoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [EstadoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [EstadoController::class, 'store'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [EstadoController::class, 'destroy'])->middleware(['auth:api']);
});
