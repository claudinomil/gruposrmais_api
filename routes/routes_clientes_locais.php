<?php

use App\Http\Controllers\ClienteLocalController;

Route::prefix('clientes_locais')->group(function () {
    Route::get('/index', [ClienteLocalController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteLocalController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ClienteLocalController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ClienteLocalController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ClienteLocalController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [ClienteLocalController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ClienteLocalController::class, 'auxiliary'])->middleware(['auth:api']);
});
