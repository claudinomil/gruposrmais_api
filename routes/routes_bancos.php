<?php

use App\Http\Controllers\BancoController;

Route::prefix('bancos')->group(function () {
    Route::get('/index/{empresa_id}', [BancoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [BancoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [BancoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [BancoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [BancoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [BancoController::class, 'destroy'])->middleware(['auth:api']);
});
