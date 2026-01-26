<?php

use App\Http\Controllers\ClientesRelatorioController;

Route::prefix('clientes_relatorios')->group(function () {
    Route::get('/index', [ClientesRelatorioController::class, 'index'])->middleware(['auth:api']);

    Route::get('/relatorios', [ClientesRelatorioController::class, 'relatorios'])->middleware(['auth:api']);

    Route::get('/relatorio11/{data_inicio}/{data_fim}/{cidade_id}/{cidade}/{idioma}', [ClientesRelatorioController::class, 'relatorio11'])->middleware(['auth:api']);
    Route::get('/relatorio12/{ponto_tipo_id}/{ponto_natureza_id}/{modelo}/{idioma}', [ClientesRelatorioController::class, 'relatorio12'])->middleware(['auth:api']);
});
