<?php

use App\Http\Controllers\BrigadaController;

Route::prefix('brigadas')->group(function () {
    Route::get('/index', [BrigadaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [BrigadaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [BrigadaController::class, 'filter'])->middleware(['auth:api']);
    Route::put('/update/{id}', [BrigadaController::class, 'update'])->middleware(['auth:api']);

    //Escalas e Rondas
    Route::get('/escalas/{brigada_id}/{er_periodo_data_1}/{er_periodo_data_2}', [BrigadaController::class, 'escalas'])->middleware(['auth:api']);

    Route::get('/ronda_cliente_seguranca_medidas/{op}/{brigada_escala_id}/{brigada_ronda_id}', [BrigadaController::class, 'ronda_cliente_seguranca_medidas']);
});
