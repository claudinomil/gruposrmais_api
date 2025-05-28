<?php

use App\Http\Controllers\RelatorioExaustaoController;

Route::prefix('relatorios_exaustoes')->group(function () {
    Route::get('/index/{empresa_id}', [RelatorioExaustaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [RelatorioExaustaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [RelatorioExaustaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [RelatorioExaustaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [RelatorioExaustaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [RelatorioExaustaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [RelatorioExaustaoController::class, 'auxiliary'])->middleware(['auth:api']);
});
