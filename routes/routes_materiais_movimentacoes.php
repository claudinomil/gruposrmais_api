<?php

use App\Http\Controllers\MaterialMovimentacaoController;

Route::prefix('materiais_movimentacoes')->group(function () {
    Route::get('/index', [MaterialMovimentacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MaterialMovimentacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MaterialMovimentacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [MaterialMovimentacaoController::class, 'store'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [MaterialMovimentacaoController::class, 'auxiliary'])->middleware(['auth:api']);

    // Buscar Materiais Entradas Itens
    Route::get('/materiais_entradas_itens/{operacao}/{estoque_local_id}/{material_movimentacao_id}', [MaterialMovimentacaoController::class, 'materiais_entradas_itens'])->middleware(['auth:api']);
});
