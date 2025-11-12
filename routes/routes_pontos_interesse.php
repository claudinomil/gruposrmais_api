<?php

use App\Http\Controllers\PontoInteresseController;

Route::prefix('pontos_interesse')->group(function () {
    Route::get('/index', [PontoInteresseController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [PontoInteresseController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [PontoInteresseController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [PontoInteresseController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [PontoInteresseController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [PontoInteresseController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [PontoInteresseController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/pontos_tipo/{ponto_tipo_id}', [PontoInteresseController::class, 'pontos_tipo'])->middleware(['auth:api']);
});
