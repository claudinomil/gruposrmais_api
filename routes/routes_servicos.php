<?php

use App\Http\Controllers\ServicoController;

Route::prefix('servicos')->group(function () {
    Route::get('/index', [ServicoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ServicoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ServicoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ServicoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ServicoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [ServicoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [ServicoController::class, 'auxiliary'])->middleware(['auth:api']);
});
