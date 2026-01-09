<?php

use App\Http\Controllers\ProdutoControleSituacaoController;

Route::prefix('produtos_controle_situacoes')->group(function () {
    Route::get('/index', [ProdutoControleSituacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ProdutoControleSituacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ProdutoControleSituacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ProdutoControleSituacaoController::class, 'update'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ProdutoControleSituacaoController::class, 'auxiliary'])->middleware(['auth:api']);
});
