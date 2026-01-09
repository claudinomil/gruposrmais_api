<?php

use App\Http\Controllers\ProdutoMovimentacaoController;

Route::prefix('produtos_movimentacoes')->group(function () {
    Route::get('/index', [ProdutoMovimentacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ProdutoMovimentacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ProdutoMovimentacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ProdutoMovimentacaoController::class, 'store'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ProdutoMovimentacaoController::class, 'auxiliary'])->middleware(['auth:api']);

    // Buscar Materiais Entradas Itens
    Route::get('/produtos_entradas_itens/{operacao}/{estoque_local_id}/{produto_movimentacao_id}', [ProdutoMovimentacaoController::class, 'produtos_entradas_itens'])->middleware(['auth:api']);
});
