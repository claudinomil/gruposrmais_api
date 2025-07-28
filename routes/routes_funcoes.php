<?php

use App\Http\Controllers\FuncaoController;

Route::prefix('funcoes')->group(function () {
    Route::get('/index', [FuncaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FuncaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [FuncaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [FuncaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [FuncaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [FuncaoController::class, 'destroy'])->middleware(['auth:api']);
});
