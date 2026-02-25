<?php

use App\Http\Controllers\MedidaSegurancaController;

Route::prefix('medidas_seguranca')->group(function () {
    Route::get('/index', [MedidaSegurancaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MedidaSegurancaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MedidaSegurancaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [MedidaSegurancaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [MedidaSegurancaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [MedidaSegurancaController::class, 'destroy'])->middleware(['auth:api']);
});
