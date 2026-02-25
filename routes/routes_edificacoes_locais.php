<?php

use App\Http\Controllers\EdificacaoLocalController;

Route::prefix('edificacoes_locais')->group(function () {
    Route::get('/index', [EdificacaoLocalController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EdificacaoLocalController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EdificacaoLocalController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EdificacaoLocalController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EdificacaoLocalController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EdificacaoLocalController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [EdificacaoLocalController::class, 'auxiliary'])->middleware(['auth:api']);
});
