<?php

use App\Http\Controllers\TransacaoController;

Route::prefix('transacoes')->group(function () {
    Route::get('/index/{empresa_id}', [TransacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [TransacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [TransacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [TransacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [TransacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [TransacaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [TransacaoController::class, 'auxiliary'])->middleware(['auth:api']);
});
