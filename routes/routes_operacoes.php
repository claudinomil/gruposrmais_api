<?php

use App\Http\Controllers\OperacaoController;

Route::prefix('operacoes')->group(function () {
    Route::get('/index/{empresa_id}', [OperacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [OperacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [OperacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [OperacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [OperacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [OperacaoController::class, 'destroy'])->middleware(['auth:api']);
});
