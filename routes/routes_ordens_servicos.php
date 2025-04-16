<?php

use App\Http\Controllers\OrdemServicoController;

Route::prefix('ordens_servicos')->group(function () {
    Route::get('/index/{empresa_id}', [OrdemServicoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [OrdemServicoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [OrdemServicoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [OrdemServicoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [OrdemServicoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [OrdemServicoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [OrdemServicoController::class, 'auxiliary'])->middleware(['auth:api']);
});
