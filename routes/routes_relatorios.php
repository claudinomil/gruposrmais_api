<?php

use App\Http\Controllers\RelatorioController;

Route::prefix('relatorios')->group(function () {
    Route::get('/index', [RelatorioController::class, 'index'])->middleware(['auth:api']);

    Route::get('/relatorios', [RelatorioController::class, 'relatorios'])->middleware(['auth:api']);

    Route::get('/relatorio1/{grupo_id}/{idioma}', [RelatorioController::class, 'relatorio1'])->middleware(['auth:api']);
    Route::get('/relatorio2/{grupo_id}/{situacao_id}/{idioma}', [RelatorioController::class, 'relatorio2'])->middleware(['auth:api']);
    Route::get('/relatorio3/{data}/{user_id}/{submodulo_id}/{operacao_id}/{dado}/{idioma}', [RelatorioController::class, 'relatorio3'])->middleware(['auth:api']);
    Route::get('/relatorio6/{data_inicio}/{data_fim}/{cidade_id}/{cidade}/{idioma}', [RelatorioController::class, 'relatorio6'])->middleware(['auth:api']);
});
