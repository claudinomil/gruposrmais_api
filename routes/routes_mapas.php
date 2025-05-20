<?php

use App\Http\Controllers\MapaController;

Route::prefix('mapas')->group(function () {
    Route::get('/index/{empresa_id}', [MapaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MapaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [MapaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [MapaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [MapaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [MapaController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables/{empresa_id}', [MapaController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/visualizar_mapa/{id}', [MapaController::class, 'visualizar_mapa'])->middleware(['auth:api']);
});
