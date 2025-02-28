<?php

use App\Http\Controllers\FuncaoController;

Route::prefix('funcoes')->group(function () {
    Route::get('/index/{empresa_id}', [FuncaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FuncaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [FuncaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [FuncaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [FuncaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [FuncaoController::class, 'destroy'])->middleware(['auth:api']);
});
