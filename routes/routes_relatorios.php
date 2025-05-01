<?php

use App\Http\Controllers\RelatorioController;

Route::prefix('relatorios')->group(function () {
    Route::get('/index/{empresa_id}', [RelatorioController::class, 'index'])->middleware(['auth:api']);

    Route::get('/relatorios/{empresa_id}', [RelatorioController::class, 'relatorios'])->middleware(['auth:api']);

    Route::get('/relatorio1/{empresa_id}/{grupo_id}/{idioma}', [RelatorioController::class, 'relatorio1'])->middleware(['auth:api']);
    Route::get('/relatorio2/{empresa_id}/{grupo_id}/{situacao_id}/{idioma}', [RelatorioController::class, 'relatorio2'])->middleware(['auth:api']);
    Route::get('/relatorio3/{empresa_id}/{data}/{user_id}/{submodulo_id}/{operacao_id}/{dado}/{idioma}', [RelatorioController::class, 'relatorio3'])->middleware(['auth:api']);
    Route::get('/relatorio4/{empresa_id}/{date}/{title}/{notificacao}/{user_id}/{idioma}', [RelatorioController::class, 'relatorio4'])->middleware(['auth:api']);
    Route::get('/relatorio5/{empresa_id}/{name}/{descricao}/{url}/{user_id}/{idioma}', [RelatorioController::class, 'relatorio5'])->middleware(['auth:api']);
    Route::get('/relatorio6/{empresa_id}/{data_inicio}/{data_fim}/{cidade_id}/{cidade}/{idioma}', [RelatorioController::class, 'relatorio6'])->middleware(['auth:api']);
});
