<?php

use App\Http\Controllers\PropostaController;

Route::prefix('propostas')->group(function () {
    Route::get('/index/{empresa_id}', [PropostaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [PropostaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [PropostaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [PropostaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [PropostaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [PropostaController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [PropostaController::class, 'auxiliary'])->middleware(['auth:api']);
});
