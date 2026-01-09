<?php

use App\Http\Controllers\RelatorioController;

Route::prefix('relatorios')->group(function () {
    Route::get('/index', [RelatorioController::class, 'index'])->middleware(['auth:api']);

    Route::get('/relatorios', [RelatorioController::class, 'relatorios'])->middleware(['auth:api']);

    Route::get('/relatorio1/{grupo_id}/{idioma}', [RelatorioController::class, 'relatorio1'])->middleware(['auth:api']);
    Route::get('/relatorio2/{grupo_id}/{situacao_id}/{idioma}', [RelatorioController::class, 'relatorio2'])->middleware(['auth:api']);
    Route::get('/relatorio3/{data}/{user_id}/{submodulo_id}/{operacao_id}/{dado}/{idioma}', [RelatorioController::class, 'relatorio3'])->middleware(['auth:api']);
    Route::get('/relatorio6/{data_inicio}/{data_fim}/{cidade_id}/{cidade}/{idioma}', [RelatorioController::class, 'relatorio6'])->middleware(['auth:api']);
    Route::get('/relatorio8/{ponto_tipo_id}/{ponto_natureza_id}/{modelo}/{idioma}', [RelatorioController::class, 'relatorio8'])->middleware(['auth:api']);
    Route::get('/relatorio9/{idioma}', [RelatorioController::class, 'relatorio9'])->middleware(['auth:api']);
    Route::get('/relatorio10/{produto_id}/{produto_categoria_id}/{estoque_local_id}/{empresa_id}/{cliente_id}/{produto_situacao_id}/{idioma}', [RelatorioController::class, 'relatorio10'])->middleware(['auth:api']);
});
