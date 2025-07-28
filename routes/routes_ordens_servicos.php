<?php

use App\Http\Controllers\OrdemServicoController;

Route::prefix('ordens_servicos')->group(function () {
    Route::get('/index', [OrdemServicoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [OrdemServicoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [OrdemServicoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [OrdemServicoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [OrdemServicoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [OrdemServicoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [OrdemServicoController::class, 'auxiliary'])->middleware(['auth:api']);
});
