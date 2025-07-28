<?php

use App\Http\Controllers\PropostaController;

Route::prefix('propostas')->group(function () {
    Route::get('/index', [PropostaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [PropostaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [PropostaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [PropostaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [PropostaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [PropostaController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [PropostaController::class, 'auxiliary'])->middleware(['auth:api']);
});
