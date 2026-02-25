<?php

use App\Http\Controllers\EdificacaoController;

Route::prefix('edificacoes')->group(function () {
    Route::get('/index', [EdificacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EdificacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EdificacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EdificacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EdificacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EdificacaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [EdificacaoController::class, 'auxiliary'])->middleware(['auth:api']);

    // Outras Rotas de dados
    Route::get('/dados/medidas_seguranca', [EdificacaoController::class, 'medidas_seguranca'])->middleware(['auth:api']);
    Route::get('/dados/edificacao_medidas_seguranca/{edificacao_id}', [EdificacaoController::class, 'edificacao_medidas_seguranca'])->middleware(['auth:api']);
});
