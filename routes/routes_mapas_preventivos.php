<?php

use App\Http\Controllers\MapaPreventivoController;

Route::prefix('mapas_preventivos')->group(function () {
    Route::get('/index', [MapaPreventivoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MapaPreventivoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MapaPreventivoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [MapaPreventivoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [MapaPreventivoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [MapaPreventivoController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [MapaPreventivoController::class, 'auxiliary'])->middleware(['auth:api']);
});
