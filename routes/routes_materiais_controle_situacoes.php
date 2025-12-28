<?php

use App\Http\Controllers\MaterialControleSituacaoController;

Route::prefix('materiais_controle_situacoes')->group(function () {
    Route::get('/index', [MaterialControleSituacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MaterialControleSituacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MaterialControleSituacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::put('/update/{id}', [MaterialControleSituacaoController::class, 'update'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [MaterialControleSituacaoController::class, 'auxiliary'])->middleware(['auth:api']);
});
