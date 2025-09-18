<?php

use App\Http\Controllers\BrigadaIncendioController;

Route::prefix('brigadas_incendios')->group(function () {
    Route::get('/index', [BrigadaIncendioController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [BrigadaIncendioController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [BrigadaIncendioController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [BrigadaIncendioController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [BrigadaIncendioController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [BrigadaIncendioController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [BrigadaIncendioController::class, 'auxiliary'])->middleware(['auth:api']);
    Route::get('/dados/tables/{op}', [BrigadaIncendioController::class, 'dados'])->middleware(['auth:api']);
});
