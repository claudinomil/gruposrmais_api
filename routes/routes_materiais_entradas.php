<?php

use App\Http\Controllers\MaterialEntradaController;

Route::prefix('materiais_entradas')->group(function () {
    Route::get('/index', [MaterialEntradaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MaterialEntradaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MaterialEntradaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [MaterialEntradaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [MaterialEntradaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [MaterialEntradaController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [MaterialEntradaController::class, 'auxiliary'])->middleware(['auth:api']);
});
