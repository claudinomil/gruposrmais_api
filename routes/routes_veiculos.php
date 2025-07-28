<?php

use App\Http\Controllers\VeiculoController;

Route::prefix('veiculos')->group(function () {
    Route::get('/index', [VeiculoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [VeiculoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [VeiculoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [VeiculoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [VeiculoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [VeiculoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [VeiculoController::class, 'auxiliary'])->middleware(['auth:api']);
});
