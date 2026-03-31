<?php

use App\Http\Controllers\SistemaPreventivoController;

Route::prefix('sistemas_preventivos')->group(function () {
    Route::get('/index', [SistemaPreventivoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [SistemaPreventivoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [SistemaPreventivoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [SistemaPreventivoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [SistemaPreventivoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [SistemaPreventivoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [SistemaPreventivoController::class, 'auxiliary'])->middleware(['auth:api']);
});
