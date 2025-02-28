<?php

use App\Http\Controllers\ServicoController;

Route::prefix('servicos')->group(function () {
    Route::get('/index/{empresa_id}', [ServicoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ServicoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [ServicoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [ServicoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [ServicoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [ServicoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [ServicoController::class, 'auxiliary'])->middleware(['auth:api']);
});
