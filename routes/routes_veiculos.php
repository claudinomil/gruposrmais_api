<?php

use App\Http\Controllers\VeiculoController;

Route::prefix('veiculos')->group(function () {
    Route::get('/index/{empresa_id}', [VeiculoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [VeiculoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [VeiculoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [VeiculoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [VeiculoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [VeiculoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [VeiculoController::class, 'auxiliary'])->middleware(['auth:api']);
});
