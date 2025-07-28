<?php

use App\Http\Controllers\ClienteServicoController;

Route::prefix('clientes_servicos')->group(function () {
    Route::get('/index', [ClienteServicoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteServicoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ClienteServicoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ClienteServicoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ClienteServicoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [ClienteServicoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [ClienteServicoController::class, 'auxiliary'])->middleware(['auth:api']);
});
