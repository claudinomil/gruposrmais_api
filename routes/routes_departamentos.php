<?php

use App\Http\Controllers\DepartamentoController;

Route::prefix('departamentos')->group(function () {
    Route::get('/index', [DepartamentoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [DepartamentoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [DepartamentoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [DepartamentoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [DepartamentoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [DepartamentoController::class, 'destroy'])->middleware(['auth:api']);
});
