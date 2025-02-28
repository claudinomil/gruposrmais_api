<?php

use App\Http\Controllers\FornecedorController;

Route::prefix('fornecedores')->group(function () {
    Route::get('/index/{empresa_id}', [FornecedorController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FornecedorController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [FornecedorController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [FornecedorController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [FornecedorController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [FornecedorController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [FornecedorController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/extradata/{id}', [FornecedorController::class, 'extraData'])->middleware(['auth:api']);
});
