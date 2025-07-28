<?php

use App\Http\Controllers\MapaController;

Route::prefix('mapas')->group(function () {
    Route::get('/index}', [MapaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MapaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MapaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [MapaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [MapaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [MapaController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [MapaController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/visualizar_mapa/{id}', [MapaController::class, 'visualizar_mapa'])->middleware(['auth:api']);

    Route::get('/ordem_servico_destinos/{ordem_servico_id}', [MapaController::class, 'ordem_servico_destinos'])->middleware(['auth:api']);

    Route::get('/buscar_pontos_interesse/{query}', [MapaController::class, 'buscar_pontos_interesse'])->middleware(['auth:api']);
});
