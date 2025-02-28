<?php

use App\Http\Controllers\ClienteServicoController;

Route::prefix('clientes_servicos')->group(function () {
    Route::get('/index/{empresa_id}', [ClienteServicoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteServicoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [ClienteServicoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [ClienteServicoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [ClienteServicoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [ClienteServicoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [ClienteServicoController::class, 'auxiliary'])->middleware(['auth:api']);
});
