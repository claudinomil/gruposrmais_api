<?php

use App\Http\Controllers\BancoController;

Route::prefix('bancos')->group(function () {
    Route::get('/index', [BancoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [BancoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [BancoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [BancoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [BancoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [BancoController::class, 'destroy'])->middleware(['auth:api']);
});
