<?php

use App\Http\Controllers\GrupoController;

Route::prefix('grupos')->group(function () {
    Route::get('/index/{empresa_id}', [GrupoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [GrupoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [GrupoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [GrupoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [GrupoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [GrupoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [GrupoController::class, 'auxiliary'])->middleware(['auth:api']);
});
