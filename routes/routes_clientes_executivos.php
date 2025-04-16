<?php

use App\Http\Controllers\ClienteExecutivoController;

Route::prefix('clientes_executivos')->group(function () {
    Route::get('/index/{empresa_id}', [ClienteExecutivoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteExecutivoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [ClienteExecutivoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [ClienteExecutivoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [ClienteExecutivoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [ClienteExecutivoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [ClienteExecutivoController::class, 'auxiliary'])->middleware(['auth:api']);
});
