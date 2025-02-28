<?php

use App\Http\Controllers\SituacaoController;

Route::prefix('situacoes')->group(function () {
    Route::get('/index/{empresa_id}', [SituacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [SituacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [SituacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [SituacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [SituacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [SituacaoController::class, 'destroy'])->middleware(['auth:api']);
});
