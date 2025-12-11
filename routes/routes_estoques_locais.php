<?php

use App\Http\Controllers\EstoqueLocalController;

Route::prefix('estoques_locais')->group(function () {
    Route::get('/index', [EstoqueLocalController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EstoqueLocalController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EstoqueLocalController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EstoqueLocalController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EstoqueLocalController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EstoqueLocalController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [EstoqueLocalController::class, 'auxiliary'])->middleware(['auth:api']);
});
