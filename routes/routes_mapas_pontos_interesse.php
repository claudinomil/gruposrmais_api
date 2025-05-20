<?php

use App\Http\Controllers\MapaPontoInteresseController;

Route::prefix('mapas_pontos_interesse')->group(function () {
    Route::get('/index/{empresa_id}', [MapaPontoInteresseController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MapaPontoInteresseController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [MapaPontoInteresseController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [MapaPontoInteresseController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [MapaPontoInteresseController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [MapaPontoInteresseController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables/{empresa_id}', [MapaPontoInteresseController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/mapa_pontos_tipo/{mapa_ponto_tipo_id}', [MapaPontoInteresseController::class, 'mapa_pontos_tipo'])->middleware(['auth:api']);
});
